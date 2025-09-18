<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrator', 
                'description' => 'Full access to all features',
                'permissions' => [
                    // User Management
                    'manage_users',
                    'view_users',
                    'edit_users',
                    'delete_users',

                    // Role Management
                    'manage_roles',
                    'view_roles',

                    // Project Type Management
                    'manage_project_types',
                    'view_project_types',
                    'create_project_types', 
                    'edit_project_types',
                    'delete_project_types',

                    // Project Management (Updated from Product Management)
                    'manage_projects',
                    'view_projects',
                    'edit_projects',
                    'delete_projects',
                    'assign_pic',

                    // Finance Management
                    'manage_finances',
                    'view_finances',
                    'manage_incomes',
                    'view_incomes',
                    'manage_expenses',
                    'view_expenses',
                    'approve_expenses',
                    'view_finance_reports',
                    'manage_taxes',

                    // Order Management
                    'manage_orders',
                    'view_orders',
                    'edit_orders',
                    'process_orders',

                    // Reports
                    'view_reports',
                    'manage_reports',
                    'export_reports',

                    // System
                    'manage_settings',
                    'view_logs',
                    'manage_backups'
                ]
            ],
            [
                'name' => 'editor',
                'display_name' => 'Editor',
                'description' => 'Can manage content and view users',
                'permissions' => [
                    'view_users',
                    'view_project_types',
                    'create_project_types',
                    'edit_project_types',
                    'view_projects',
                    'edit_projects',
                    'view_orders',
                    'view_reports'
                ]
            ],
            [
                'name' => 'project_manager',
                'display_name' => 'Project Manager',
                'description' => 'Mengelola project dan tim',
                'permissions' => [
                    'view_users',
                    'view_project_types',
                    'manage_projects',
                    'view_projects',
                    'edit_projects',
                    'assign_pic',
                    'view_reports'
                ]
            ]
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(
                ['name' => $roleData['name']],
                $roleData
            );
        }
    }
}
