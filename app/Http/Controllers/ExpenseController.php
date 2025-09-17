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
    public function index(): View
    {
        $expenses = Expense::with(['project', 'user', 'createdBy'])
            ->when(request('category'), function ($query, $category) {
                return $query->where('category', $category);
            })
            ->when(request('status'), function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when(request('project_id'), function ($query, $projectId) {
                return $query->where('project_id', $projectId);
            })
            ->when(request('user_id'), function ($query, $userId) {
                return $query->where('user_id', $userId);
            })
            ->latest()
            ->paginate(15);

        $projects = Project::select('id', 'name')->get();
        $users = User::select('id', 'name')->get();
        $categories = ['salary', 'bonus', 'operational', 'tax', 'equipment', 'other'];
        $statuses = ['pending', 'approved', 'paid'];

        return view('expenses.index', compact('expenses', 'projects', 'users', 'categories', 'statuses'));
    }

    public function create(): View
    {
        $projects = Project::select('id', 'name')->get();
        $users = User::select('id', 'name')->get();
        $categories = ['salary', 'bonus', 'operational', 'tax', 'equipment', 'other'];

        return view('expenses.create', compact('projects', 'users', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'nullable|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'payment_date' => 'required|date',
            'reference_number' => 'nullable|string|max:255',
            'status' => ['required', Rule::in(['pending', 'approved', 'paid'])]
        ]);

        $validated['created_by'] = auth()->id();

        Expense::create($validated);

        return redirect()->route('expenses.index')
            ->with('success', 'Data pengeluaran berhasil ditambahkan!');
    }

    public function show(Expense $expense): View
    {
        $expense->load(['project', 'user', 'createdBy']);
        return view('expenses.show', compact('expense'));
    }

    public function edit(Expense $expense): View
    {
        $projects = Project::select('id', 'name')->get();
        $users = User::select('id', 'name')->get();
        $categories = ['salary', 'bonus', 'operational', 'tax', 'equipment', 'other'];

        return view('expenses.edit', compact('expense', 'projects', 'users', 'categories'));
    }

    public function update(Request $request, Expense $expense): RedirectResponse
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'nullable|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'payment_date' => 'required|date',
            'reference_number' => 'nullable|string|max:255',
            'status' => ['required', Rule::in(['pending', 'approved', 'paid'])]
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