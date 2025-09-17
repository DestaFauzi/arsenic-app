<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class FinanceController extends Controller
{
    public function index(): View
    {
        // Income Statistics
        $totalIncomes = Income::where('status', 5)->sum('grand_total'); // Status 5 = Completed
        $pendingIncomes = Income::whereIn('status', [1, 2, 3, 4])->sum('grand_total'); // Status 1-4 = Pending
        $pendingCount = Income::whereIn('status', [1, 2, 3, 4])->count();
        $completedCount = Income::where('status', 5)->count();

        // Expense Statistics (using Finance model for now, can be updated when Expense model is ready)
        $totalExpenses = Finance::where('type', 'expense')->where('status', 'paid')->sum('amount');
        
        // Recent Incomes (last 5)
        $recentIncomes = Income::with(['project'])
            ->latest()
            ->take(5)
            ->get();

        // Recent Expenses (last 5) - using Finance model
        $recentExpenses = Finance::where('type', 'expense')
            ->latest()
            ->take(5)
            ->get();

        return view('finance.index', compact(
            'totalIncomes',
            'pendingIncomes',
            'pendingCount',
            'completedCount',
            'totalExpenses',
            'recentIncomes',
            'recentExpenses'
        ));
    }

    public function create(): View
    {
        $projects = Project::select('id', 'name')->get();
        $users = User::select('id', 'name')->get();

        $categories = [
            'income' => ['project_payment', 'additional_service', 'other_income'],
            'expense' => ['salary', 'bonus', 'operational', 'tax', 'other_expense']
        ];

        return view('finances.create', compact('projects', 'users', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'in:income,expense'],
            'category' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string', 'max:1000'],
            'transaction_date' => ['required', 'date'],
            'project_id' => ['nullable', 'exists:projects,id'],
            'reference_number' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:pending,approved,paid']
        ]);

        $validated['created_by'] = auth()->id();

        Finance::create($validated);

        return redirect()->route('finances.index')
            ->with('success', 'Finance record created successfully.');
    }

    public function show(Finance $finance): View
    {
        $finance->load(['project', 'createdBy']);
        return view('finances.show', compact('finance'));
    }

    public function edit(Finance $finance): View
    {
        $projects = Project::select('id', 'name')->get();
        $users = User::select('id', 'name')->get();

        $categories = [
            'income' => ['project_payment', 'additional_service', 'other_income'],
            'expense' => ['salary', 'bonus', 'operational', 'tax', 'other_expense']
        ];

        return view('finances.edit', compact('finance', 'projects', 'users', 'categories'));
    }

    public function update(Request $request, Finance $finance): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'in:income,expense'],
            'category' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string', 'max:1000'],
            'transaction_date' => ['required', 'date'],
            'project_id' => ['nullable', 'exists:projects,id'],
            'reference_number' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:pending,approved,paid']
        ]);

        $finance->update($validated);

        return redirect()->route('finances.index')
            ->with('success', 'Finance record updated successfully.');
    }

    public function destroy(Finance $finance): RedirectResponse
    {
        $finance->delete();

        return redirect()->route('finances.index')
            ->with('success', 'Finance record deleted successfully.');
    }

    public function updateStatus(Request $request, Finance $finance): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,approved,paid']
        ]);

        $finance->update($validated);

        return redirect()->back()
            ->with('success', 'Status updated successfully.');
    }

    public function report(): View
    {
        $startDate = request('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = request('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Income Report from Income model
        $incomes = Income::whereBetween('received_date', [$startDate, $endDate])
            ->selectRaw('source as category, SUM(grand_total) as total, COUNT(*) as count')
            ->groupBy('source')
            ->get();

        // Expense Report from Finance model
        $expenses = Finance::where('type', 'expense')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->selectRaw('category, SUM(amount) as total, COUNT(*) as count')
            ->groupBy('category')
            ->get();

        // Monthly Data combining both models
        $monthlyIncomes = Income::whereBetween('received_date', [$startDate, $endDate])
            ->selectRaw('DATE_FORMAT(received_date, "%Y-%m") as month, "income" as type, SUM(grand_total) as total')
            ->groupBy('month')
            ->get();

        $monthlyExpenses = Finance::where('type', 'expense')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->selectRaw('DATE_FORMAT(transaction_date, "%Y-%m") as month, type, SUM(amount) as total')
            ->groupBy('month', 'type')
            ->get();

        $monthlyData = $monthlyIncomes->merge($monthlyExpenses)->sortBy('month');

        return view('finances.report', compact('incomes', 'expenses', 'monthlyData', 'startDate', 'endDate'));
    }

    // Legacy methods for backward compatibility
    public function incomesIndex()
    {
        return redirect()->route('incomes.index');
    }

    public function expensesIndex()
    {
        $expenses = Finance::where('type', 'expense')
            ->with(['project', 'createdBy'])
            ->orderBy('transaction_date', 'desc')
            ->get();

        return view('finance.expenses.index', compact('expenses'));
    }

    public function approveIncome($id)
    {
        // This method should redirect to the proper income approval
        return redirect()->route('incomes.show', $id)
            ->with('info', 'Please use the income management system for approvals.');
    }
}
