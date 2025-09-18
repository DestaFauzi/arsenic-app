<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use PDF; // Tambahkan import ini

class IncomeController extends Controller
{
    public function index(): View
    {
        $incomes = Income::with(['project', 'createdBy'])
            ->when(request('source'), function ($query, $source) {
                return $query->where('source', $source);
            })
            ->when(request('status'), function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when(request('project_id'), function ($query, $projectId) {
                return $query->where('project_id', $projectId);
            })
            ->latest()
            ->paginate(15);

        $projects = Project::select('id', 'name')->get();
        $sources = ['project_completion', 'project_payment', 'additional_service', 'maintenance', 'consultation'];
        $statuses = Income::getStatusOptions();

        // Dashboard Statistics
        $pendingIncomes = Income::whereIn('status', [1, 2, 3, 4])->sum('amount'); // Status 1-4 (belum completed)
        $totalIncomes = Income::where('status', 5)->sum('amount'); // Status 5 (completed)
        $pendingCount = Income::whereIn('status', [1, 2, 3, 4])->count();
        $completedCount = Income::where('status', 5)->count();

        return view('finance.incomes.index', compact(
            'incomes',
            'projects',
            'sources',
            'statuses',
            'pendingIncomes',
            'totalIncomes',
            'pendingCount',
            'completedCount'
        ));
    }

    public function create(): View
    {
        $projects = Project::select('id', 'name')->get();
        $sources = ['project_payment', 'additional_service', 'maintenance', 'consultation'];

        return view('finance.incomes.create', compact('projects', 'sources'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'amount' => 'required|numeric|min:0',
            'source' => 'required|string|max:255',
            'description' => 'nullable|string',
            'received_date' => 'required|date',
            'invoice_number' => 'nullable|string|max:255',
            'status' => ['required', Rule::in([1, 2, 3, 4, 5])]
        ]);

        $validated['created_by'] = auth()->id();

        Income::create($validated);

        return redirect()->route('incomes.index')
            ->with('success', 'Data pemasukan berhasil ditambahkan!');
    }

    public function show(Income $income): View
    {
        $income->load(['project', 'createdBy']);
        return view('finance.incomes.show', compact('income'));
    }

    public function edit(Income $income): View
    {
        $projects = Project::select('id', 'name')->get();
        $sources = ['project_payment', 'additional_service', 'maintenance', 'consultation'];

        return view('finance.incomes.edit', compact('income', 'projects', 'sources'));
    }

    public function update(Request $request, Income $income): RedirectResponse
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'amount' => 'required|numeric|min:0',
            'source' => 'required|string|max:255',
            'description' => 'nullable|string',
            'received_date' => 'required|date',
            'invoice_number' => 'nullable|string|max:255',
            'status' => ['required', Rule::in([1, 2, 3, 4, 5])]
        ]);

        $income->update($validated);

        return redirect()->route('incomes.index')
            ->with('success', 'Data pemasukan berhasil diupdate!');
    }

    public function destroy(Income $income): RedirectResponse
    {
        $income->delete();

        return redirect()->route('incomes.index')
            ->with('success', 'Data pemasukan berhasil dihapus!');
    }

    /**
     * Show approval page for income
     */
    public function approval(Income $income): View
    {
        $income->load(['project', 'createdBy']);
        return view('finance.incomes.approval', compact('income'));
    }

    /**
     * Approve income by Accounting (Status 1 -> 2)
     */
    public function approveByAccounting(Income $income): RedirectResponse
    {
        if ($income->status !== 1) {
            return redirect()->back()->with('error', 'Income tidak dalam status yang tepat untuk approval accounting.');
        }

        $income->update([
            'status' => 2 // STATUS_NEED_DEPT_HEAD_APPROVAL
        ]);

        return redirect()->back()->with('success', 'Income berhasil di-approve oleh Accounting.');
    }

    /**
     * Approve income by Department Head (Status 2 -> 3)
     */
    public function approveByDeptHead(Income $income): RedirectResponse
    {
        if ($income->status !== 2) {
            return redirect()->back()->with('error', 'Income tidak dalam status yang tepat untuk approval dept head.');
        }

        $income->update([
            'status' => 3 // STATUS_NEED_PRESIDENT_APPROVAL
        ]);

        return redirect()->back()->with('success', 'Income berhasil di-approve oleh Department Head.');
    }

    /**
     * Approve income by President (Status 3 -> 4)
     */
    public function approveByPresident(Income $income): RedirectResponse
    {
        if ($income->status !== 3) {
            return redirect()->back()->with('error', 'Income tidak dalam status yang tepat untuk approval president.');
        }

        $income->update([
            'status' => 4 // STATUS_NEED_EXECUTE
        ]);

        return redirect()->back()->with('success', 'Income berhasil di-approve oleh President Director.');
    }

    /**
     * Reject Income - Only available for Dept Head and President Director
     * Returns to Accounting Approval status
     */
    public function reject(Income $income): RedirectResponse
    {
        // Only allow reject from Dept Head Approval (status 2) or President Approval (status 3)
        // if (!in_array($income->status, [2, 3])) {
        //     return redirect()->back()->with('error', 'Income tidak dapat di-reject pada status ini.');
        // }

        $income->update([
            'status' => 1 // Return to Need Accounting Approval
        ]);

        return redirect()->back()->with('success', 'Income berhasil di-reject. Status dikembalikan ke Need Accounting Approval.');
    }

    /**
     * Execute Incomes (Status 4 -> 5)
     */
    public function executeIncome(Income $income): RedirectResponse
    {
        if ($income->status !== 4) {
            return redirect()->back()->with('error', 'Income tidak dalam status yang tepat untuk execute.');
        }

        $income->update([
            'status' => 5 // STATUS_FINISH
        ]);

        return redirect()->back()->with('success', 'Income berhasil di-execute. Status diubah ke "Finish".');
    }

    /**
     * Export invoice for income
     */
    public function exportInvoice(Income $income)
    {
        // Check if income has invoice and is approved
        if ($income->status < 4 || !$income->invoice_number) {
            return redirect()->back()->with('error', 'Invoice tidak tersedia untuk income ini.');
        }

        $income->load(['project', 'createdBy']);

        // Generate PDF using DomPDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('finance.incomes.invoice', compact('income'));

        return $pdf->download('invoice-' . $income->invoice_number . '.pdf');
    }
}
