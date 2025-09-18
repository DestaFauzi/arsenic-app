<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class ExpenseController extends Controller
{
    public function index(Request $request): View
    {
        $query = Expense::with(['user']);

        // Filter berdasarkan status jika ada
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan category jika ada
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter berdasarkan tanggal jika ada
        if ($request->filled('date_from')) {
            $query->whereDate('payment_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('payment_date', '<=', $request->date_to);
        }

        $expenses = $query->orderBy('payment_date', 'desc')->paginate(10);

        // Hapus sources karena kolom tidak ada
        $categories = ['salary', 'bonus', 'operational', 'tax', 'equipment', 'other'];

        // Statistics
        $pendingExpenses = Expense::where('status', 1)->sum('amount');
        $totalExpenses = Expense::where('status', 5)->sum('amount');
        $pendingCount = Expense::where('status', 1)->count();
        $paidCount = Expense::where('status', 5)->count();

        return view('finance.expenses.index', compact(
            'expenses',
            'categories',
            'pendingExpenses',
            'totalExpenses',
            'pendingCount',
            'paidCount'
        ));
    }

    public function create(): View
    {
        $projects = Project::select('id', 'name')->get();
        $users = User::select('id', 'name')->get();
        $categories = ['salary', 'bonus', 'operational', 'tax', 'equipment', 'other'];

        return view('finance.expenses.create', compact('projects', 'users', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'payment_date' => 'required|date',
            'reference_number' => 'nullable|string|max:255',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['status'] = Expense::STATUS_NEED_ACCOUNTING_APPROVAL; // Default status

        Expense::create($validated);

        return redirect()->route('expenses.index')
            ->with('success', 'Data pengeluaran berhasil ditambahkan!');
    }

    public function show(Expense $expense): View
    {
        $expense->load(['user', 'createdBy']);
        return view('finance.expenses.show', compact('expense'));
    }

    public function edit(Expense $expense): View
    {
        $projects = Project::select('id', 'name')->get();
        $users = User::select('id', 'name')->get();
        $categories = ['salary', 'bonus', 'operational', 'tax', 'equipment', 'other'];

        return view('finance.expenses.edit', compact('expense', 'projects', 'users', 'categories'));
    }

    public function update(Request $request, Expense $expense): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'payment_date' => 'required|date',
            'reference_number' => 'nullable|string|max:255',
        ]);

        $expense->update($validated);

        return redirect()->route('expenses.index')
            ->with('success', 'Data pengeluaran berhasil diupdate!');
    }

    public function destroy(Expense $expense): RedirectResponse
    {
        $expense->delete();

        return redirect()->route('expenses.index')
            ->with('success', 'Data pengeluaran berhasil dihapus!');
    }

    // Approval methods
    public function approval(Expense $expense): View
    {
        $expense->load(['project', 'user', 'createdBy']);
        return view('finance.expenses.approval', compact('expense'));
    }

    public function approve(Request $request, Expense $expense): RedirectResponse
    {
        $validated = $request->validate([
            'action' => 'required|in:approve,reject',
            'notes' => 'nullable|string|max:500'
        ]);

        if ($validated['action'] === 'approve') {
            // Move to next approval stage
            $nextStatus = match ($expense->status) {
                Expense::STATUS_NEED_ACCOUNTING_APPROVAL => Expense::STATUS_NEED_FINANCE_APPROVAL,
                Expense::STATUS_NEED_FINANCE_APPROVAL => Expense::STATUS_NEED_DIRECTOR_APPROVAL,
                Expense::STATUS_NEED_DIRECTOR_APPROVAL => Expense::STATUS_APPROVED,
                default => $expense->status
            };

            $expense->update(['status' => $nextStatus]);
            $message = 'Expense berhasil disetujui dan diteruskan ke tahap berikutnya!';
        } else {
            $expense->update(['status' => Expense::STATUS_REJECTED]);
            $message = 'Expense ditolak!';
        }

        return redirect()->route('expenses.index')
            ->with('success', $message);
    }

    public function markAsPaid(Expense $expense): RedirectResponse
    {
        if ($expense->status !== Expense::STATUS_APPROVED) {
            return redirect()->back()
                ->with('error', 'Expense harus disetujui terlebih dahulu sebelum dapat dibayar!');
        }

        $expense->update(['status' => Expense::STATUS_PAID]);

        return redirect()->route('expenses.index')
            ->with('success', 'Expense berhasil ditandai sebagai sudah dibayar!');
    }

    public function salaryReport(): View
    {
        $startDate = request('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = request('end_date', now()->endOfMonth()->format('Y-m-d'));

        $salaryExpenses = Expense::salaryExpenses()
            ->with(['project', 'user'])
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->selectRaw('user_id, project_id, SUM(amount) as total_salary, COUNT(*) as payment_count')
            ->groupBy('user_id', 'project_id')
            ->get();

        return view('expenses.salary-report', compact('salaryExpenses', 'startDate', 'endDate'));
    }
}
