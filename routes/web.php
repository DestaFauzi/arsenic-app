<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes dengan Permission-based Access Control
Route::middleware(['auth'])->group(function () {

    // User Management - Hanya user dengan permission 'manage_users'
    Route::middleware(['permission:manage_users'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // AJAX routes untuk role management
        Route::post('/users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assign-role');
        Route::post('/users/{user}/remove-role', [UserController::class, 'removeRole'])->name('users.remove-role');
        Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    });

    // Role Management - Hanya user dengan permission 'manage_roles'
    Route::middleware(['permission:manage_roles'])->group(function () {
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
        //routes roles.show
        Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show');

        // Permission management untuk role
        Route::post('/roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.permissions.update');
    });

    // Project Management - Permission 'manage_projects'
    Route::middleware(['permission:manage_projects'])->group(function () {
        Route::resource('projects', ProjectController::class);
    });

    // View Projects - Permission 'view_projects' (lebih rendah dari manage_projects)
    Route::middleware(['permission:view_projects'])->group(function () {
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    });


    // Settings - Permission 'manage_settings'
    Route::middleware(['permission:manage_settings'])->group(function () {
        Route::get('/settings', function () {
            return view('settings.index');
        })->name('settings.index');
    });
});

// Finance Management - Permission 'manage_finances'
Route::middleware(['permission:manage_finances'])->group(function () {
    Route::resource('finances', FinanceController::class);
    Route::patch('/finances/{finance}/status', [FinanceController::class, 'updateStatus'])->name('finances.status.update');
    Route::get('/finance-report', [FinanceController::class, 'report'])->name('finances.report');
});

// Income Management - Permission 'manage_incomes'
Route::middleware(['permission:manage_incomes'])->group(function () {
    Route::resource('incomes', IncomeController::class);
});

// View Incomes
Route::get('/incomes', [IncomeController::class, 'index'])->name('incomes.index')->middleware('permission:view_incomes');
Route::get('/incomes/{income}', [IncomeController::class, 'show'])->name('incomes.show')->middleware('permission:view_incomes');

// Add new approval route
Route::get('/incomes/{income}/approval', [IncomeController::class, 'approval'])->name('incomes.approval')->middleware('permission:view_incomes');

// Export Invoice Route
Route::get('/incomes/{income}/export', [IncomeController::class, 'exportInvoice'])->name('incomes.export')->middleware('permission:view_incomes');

// Income Approval Routes
Route::post('/incomes/{income}/approve-accounting', [IncomeController::class, 'approveByAccounting'])->name('incomes.approve.accounting')->middleware('permission:approve_incomes_accounting');
Route::post('/incomes/{income}/approve-dept-head', [IncomeController::class, 'approveByDeptHead'])->name('incomes.approve.dept_head')->middleware('permission:approve_incomes_dept_head');
Route::post('/incomes/{income}/approve-president', [IncomeController::class, 'approveByPresident'])->name('incomes.approve.president')->middleware('permission:approve_incomes_president');
Route::patch('/incomes/{income}/reject', [IncomeController::class, 'reject'])->name('incomes.reject');
Route::patch('/incomes/{income}/execute', [IncomeController::class, 'executeIncome'])->name('incomes.execute')->middleware('permission:execute_incomes');

// Expense Management - Permission 'manage_expenses'
Route::middleware(['permission:manage_expenses'])->group(function () {
    Route::resource('expenses', ExpenseController::class);
    Route::get('/salary-report', [ExpenseController::class, 'salaryReport'])->name('expenses.salary-report');
});

// View Finance Data - Permission 'view_finances'
Route::middleware(['permission:view_finances'])->group(function () {
    // Finance routes
    Route::get('/finances', [FinanceController::class, 'index'])->name('finances.index');
    Route::post('/finances/incomes/{id}/approve', [FinanceController::class, 'approveIncome'])->name('finances.incomes.approve');
    Route::get('/finances/{finance}', [FinanceController::class, 'show'])->name('finances.show');
});

// View Income Data - Permission 'view_incomes'
Route::middleware(['permission:view_incomes'])->group(function () {
    // Update to use IncomeController instead of FinanceController
    Route::get('/incomes', [IncomeController::class, 'index'])->name('incomes.index');
    Route::get('/incomes/{income}', [IncomeController::class, 'show'])->name('incomes.show');
    Route::get('/incomes/{income}/approval', [IncomeController::class, 'approval'])->name('incomes.approval');
});

// View Expense Data - Permission 'view_expenses'
Route::middleware(['permission:view_expenses'])->group(function () {
    Route::get('/expenses', [FinanceController::class, 'expensesIndex'])->name('finances.expenses');
    Route::get('/expenses/{expense}', [FinanceController::class, 'expenseShow'])->name('expenses.show');
});
// Approved Expense - Permission 'view_approved_expenses'
Route::middleware(['permission:view_approved_expenses'])->group(function () {
    Route::get('/expenses/approved', [FinanceController::class, 'approvedExpensesIndex'])->name('expenses.approved.index');
    Route::get('/expenses/approved/{expense}', [FinanceController::class, 'approvedExpenseShow'])->name('expenses.approved.show');
});



// Include authentication routes
require __DIR__ . '/auth.php';
