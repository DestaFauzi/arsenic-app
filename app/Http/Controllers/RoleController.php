<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function __construct()
    {
        // Hapus middleware ini karena sudah dihandle di routes
        // $this->middleware('role:admin');

        // ATAU gunakan permission middleware yang konsisten:
        // $this->middleware('permission:manage_roles');
    }

    public function index(): View
    {
        $roles = Role::with('users')->paginate(10);
        return view('roles.index', compact('roles'));
    }

    public function create(): View
    {
        $availablePermissions = $this->getAvailablePermissions();
        return view('roles.create', compact('availablePermissions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'display_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string',
            'is_active' => 'boolean'
        ]);

        Role::create($validated);

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil dibuat!');
    }

    public function show(Role $role): View
    {
        $role->load('users');
        return view('roles.show', compact('role'));
    }

    public function edit(Role $role): View
    {
        $availablePermissions = $this->getAvailablePermissions();
        $rolePermissions = $role->permissions ?? [];

        return view('roles.edit', compact('role', 'availablePermissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'display_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string',
            'is_active' => 'boolean'
        ]);

        $role->update($validated);

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil diupdate!');
    }

    public function destroy(Role $role): RedirectResponse
    {
        // Prevent deleting role if it has users
        if ($role->users()->count() > 0) {
            return redirect()->route('roles.index')
                ->with('error', 'Tidak dapat menghapus role yang masih memiliki user!');
        }

        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil dihapus!');
    }

    /**
     * Update permissions untuk role
     */
    public function updatePermissions(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'string'
        ]);

        $role->update([
            'permissions' => $request->permissions ?? []
        ]);

        return redirect()->route('roles.edit', $role)
            ->with('success', 'Permissions berhasil diupdate!');
    }

    /**
     * Get available permissions
     */
    public function getAvailablePermissions()
    {
        return [
            'User Management' => [
                'manage_users' => 'Kelola Semua User',
                'view_users' => 'Lihat Daftar User',
                'edit_users' => 'Edit User Lain',
                'delete_users' => 'Hapus User'
            ],
            'Role Management' => [
                'manage_roles' => 'Kelola Roles & Permissions',
                'view_roles' => 'Lihat Roles'
            ],
            'Project Management' => [
                'manage_projects' => 'Kelola Semua Project',
                'view_projects' => 'Lihat Project',
                'edit_projects' => 'Edit Project',
                'delete_projects' => 'Hapus Project',
                'assign_pic' => 'Assign PIC Project'
            ],
            'Finance Management' => [
                'manage_finances' => 'Kelola Semua Keuangan',
                'view_finances' => 'Lihat Data Keuangan',
                'manage_expenses' => 'Kelola Pengeluaran',
                'view_expenses' => 'Lihat Pengeluaran',
                'approve_expenses' => 'Approve Pengeluaran',
                'view_finance_reports' => 'Lihat Laporan Keuangan',
                'manage_taxes' => 'Kelola Pajak'
            ],
            'Income Management' => [
                'manage_incomes' => 'Kelola Pemasukan',
                'view_incomes' => 'Lihat Pemasukan',
                'approve_incomes_accounting' => 'Approval by Accounting',
                'approve_incomes_dept_head' => 'Approval by Dept Head Accounting',
                'approve_incomes_president' => 'Approval by President Director',
                'execute_incomes' => 'Execute Incomes'
            ],
            'Reports' => [
                'view_reports' => 'Lihat Laporan',
                'manage_reports' => 'Kelola Laporan',
                'export_reports' => 'Export Laporan'
            ],
            'System' => [
                'manage_settings' => 'Kelola Pengaturan',
                'view_logs' => 'Lihat System Logs',
                'manage_backups' => 'Kelola Backup'
            ]
        ];
    }
}
