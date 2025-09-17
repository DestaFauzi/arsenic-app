<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Define gates for all permissions
        Gate::define('manage_users', function (User $user) {
            return $user->hasPermission('manage_users');
        });

        Gate::define('view_users', function (User $user) {
            return $user->hasPermission('view_users');
        });

        Gate::define('edit_users', function (User $user) {
            return $user->hasPermission('edit_users');
        });

        Gate::define('delete_users', function (User $user) {
            return $user->hasPermission('delete_users');
        });

        Gate::define('manage_roles', function (User $user) {
            return $user->hasPermission('manage_roles');
        });

        Gate::define('view_roles', function (User $user) {
            return $user->hasPermission('view_roles');
        });

        Gate::define('manage_products', function (User $user) {
            return $user->hasPermission('manage_products');
        });

        Gate::define('view_products', function (User $user) {
            return $user->hasPermission('view_products');
        });

        Gate::define('edit_products', function (User $user) {
            return $user->hasPermission('edit_products');
        });

        Gate::define('delete_products', function (User $user) {
            return $user->hasPermission('delete_products');
        });

        Gate::define('manage_orders', function (User $user) {
            return $user->hasPermission('manage_orders');
        });

        Gate::define('view_orders', function (User $user) {
            return $user->hasPermission('view_orders');
        });

        Gate::define('edit_orders', function (User $user) {
            return $user->hasPermission('edit_orders');
        });

        Gate::define('process_orders', function (User $user) {
            return $user->hasPermission('process_orders');
        });

        Gate::define('view_reports', function (User $user) {
            return $user->hasPermission('view_reports');
        });

        Gate::define('manage_reports', function (User $user) {
            return $user->hasPermission('manage_reports');
        });

        Gate::define('export_reports', function (User $user) {
            return $user->hasPermission('export_reports');
        });

        Gate::define('manage_settings', function (User $user) {
            return $user->hasPermission('manage_settings');
        });

        Gate::define('view_logs', function (User $user) {
            return $user->hasPermission('view_logs');
        });

        Gate::define('manage_backups', function (User $user) {
            return $user->hasPermission('manage_backups');
        });

        Gate::define('view_projects', function (User $user) {
            return $user->hasPermission('view_projects');
        });

        Gate::define('manage_projects', function (User $user) {
            return $user->hasPermission('manage_projects');
        });

        Gate::define('edit_projects', function (User $user) {
            return $user->hasPermission('edit_projects');
        });

        Gate::define('delete_projects', function (User $user) {
            return $user->hasPermission('delete_projects');
        });

        // Finance Management Gates
        Gate::define('manage_finances', function (User $user) {
            return $user->hasPermission('manage_finances');
        });

        Gate::define('view_finances', function (User $user) {
            return $user->hasPermission('view_finances');
        });

        Gate::define('manage_incomes', function (User $user) {
            return $user->hasPermission('manage_incomes');
        });

        Gate::define('view_incomes', function (User $user) {
            return $user->hasPermission('view_incomes');
        });

        Gate::define('manage_expenses', function (User $user) {
            return $user->hasPermission('manage_expenses');
        });

        Gate::define('view_expenses', function (User $user) {
            return $user->hasPermission('view_expenses');
        });

        // Income Approval Gates
        Gate::define('approve_incomes_accounting', function (User $user) {
            return $user->hasPermission('approve_incomes_accounting');
        });

        Gate::define('approve_incomes_dept_head', function (User $user) {
            return $user->hasPermission('approve_incomes_dept_head');
        });

        Gate::define('approve_incomes_president', function (User $user) {
            return $user->hasPermission('approve_incomes_president');
        });

        Gate::define('execute_incomes', function (User $user) {
            return $user->hasPermission('execute_incomes');
        });
    }
}
