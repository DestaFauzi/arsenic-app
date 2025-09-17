<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan roles sudah ada
        $adminRole = Role::where('name', 'admin')->first();
        $editorRole = Role::where('name', 'editor')->first();
        $userRole = Role::where('name', 'user')->first();

        // Buat Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@arsenic.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        // Assign admin role
        if ($adminRole && !$admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
        }

        // Buat Editor User
        $editor = User::firstOrCreate(
            ['email' => 'editor@arsenic.com'],
            [
                'name' => 'Content Editor',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        // Assign editor role
        if ($editorRole && !$editor->hasRole('editor')) {
            $editor->assignRole($editorRole);
        }

        // Buat Regular User
        $regularUser = User::firstOrCreate(
            ['email' => 'user@arsenic.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        // Assign user role
        if ($userRole && !$regularUser->hasRole('user')) {
            $regularUser->assignRole($userRole);
        }

        // Buat beberapa user tambahan untuk testing
        $additionalUsers = [
            [
                'name' => 'John Doe',
                'email' => 'john@arsenic.com',
                'role' => 'editor'
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@arsenic.com',
                'role' => 'user'
            ],
            [
                'name' => 'Bob Wilson',
                'email' => 'bob@arsenic.com',
                'role' => 'user'
            ],
            [
                'name' => 'Alice Johnson',
                'email' => 'alice@arsenic.com',
                'role' => 'editor'
            ],
        ];

        foreach ($additionalUsers as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('password123'),
                    'email_verified_at' => now(),
                ]
            );

            // Assign role berdasarkan data
            $role = Role::where('name', $userData['role'])->first();
            if ($role && !$user->hasRole($userData['role'])) {
                $user->assignRole($role);
            }
        }

        // Buat user dengan multiple roles (contoh)
        $multiRoleUser = User::firstOrCreate(
            ['email' => 'multi@arsenic.com'],
            [
                'name' => 'Multi Role User',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        // Assign multiple roles
        if ($editorRole && !$multiRoleUser->hasRole('editor')) {
            $multiRoleUser->assignRole($editorRole);
        }
        if ($userRole && !$multiRoleUser->hasRole('user')) {
            $multiRoleUser->assignRole($userRole);
        }

        // Buat Project Manager Users
        $projectManagerRole = Role::where('name', 'project_manager')->first();
        
        $projectManagers = [
            [
                'name' => 'Ahmad Rizki',
                'email' => 'ahmad.pm@arsenic.com'
            ],
            [
                'name' => 'Sari Dewi', 
                'email' => 'sari.pm@arsenic.com'
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.pm@arsenic.com'
            ]
        ];

        foreach ($projectManagers as $pmData) {
            $pm = User::firstOrCreate(
                ['email' => $pmData['email']],
                [
                    'name' => $pmData['name'],
                    'password' => Hash::make('password123'),
                    'email_verified_at' => now(),
                ]
            );

            // Assign project manager role
            if ($projectManagerRole && !$pm->hasRole('project_manager')) {
                $pm->assignRole($projectManagerRole);
            }
        }
        $this->command->info('Users created successfully!');
        $this->command->table(
            ['Name', 'Email', 'Roles'],
            [
                [$admin->name, $admin->email, $admin->roles->pluck('name')->implode(', ')],
                [$editor->name, $editor->email, $editor->roles->pluck('name')->implode(', ')],
                [$regularUser->name, $regularUser->email, $regularUser->roles->pluck('name')->implode(', ')],
                [$multiRoleUser->name, $multiRoleUser->email, $multiRoleUser->roles->pluck('name')->implode(', ')],
            ]
        );
    }
}
