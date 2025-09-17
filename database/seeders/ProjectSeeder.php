<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada project types dan project managers
        $projectTypes = ProjectType::all();
        $projectManagers = User::projectManagers()->get();
        
        if ($projectTypes->isEmpty() || $projectManagers->isEmpty()) {
            $this->command->warn('Project types atau project managers tidak ditemukan. Jalankan seeder lain terlebih dahulu.');
            return;
        }

        $sampleProjects = [
            [
                'name' => 'Website Company Profile Arsenic',
                'description' => 'Pembuatan website company profile untuk PT Arsenic dengan fitur lengkap dan responsive design',
                'project_type_id' => $projectTypes->where('name', 'Website Development')->first()?->id ?? $projectTypes->first()->id,
                'pic_user_id' => $projectManagers->random()->id,
                'status' => 'in_progress',
                'start_date' => Carbon::now()->subDays(30),
                'end_date' => Carbon::now()->addDays(30),
                'budget' => 50000000
            ],
            [
                'name' => 'Mobile App E-Commerce',
                'description' => 'Pengembangan aplikasi mobile e-commerce untuk iOS dan Android dengan fitur payment gateway',
                'project_type_id' => $projectTypes->where('name', 'Mobile Application')->first()?->id ?? $projectTypes->first()->id,
                'pic_user_id' => $projectManagers->random()->id,
                'status' => 'planning',
                'start_date' => Carbon::now()->addDays(7),
                'end_date' => Carbon::now()->addDays(90),
                'budget' => 150000000
            ],
            [
                'name' => 'Security Audit Bank XYZ',
                'description' => 'Penetration testing dan security audit untuk sistem perbankan',
                'project_type_id' => $projectTypes->where('name', 'Cyber Security')->first()?->id ?? $projectTypes->first()->id,
                'pic_user_id' => $projectManagers->random()->id,
                'status' => 'completed',
                'start_date' => Carbon::now()->subDays(60),
                'end_date' => Carbon::now()->subDays(10),
                'budget' => 75000000
            ],
            [
                'name' => 'Dashboard Analytics',
                'description' => 'Pembuatan dashboard analytics untuk monitoring business intelligence',
                'project_type_id' => $projectTypes->where('name', 'Data Analytics')->first()?->id ?? $projectTypes->first()->id,
                'pic_user_id' => $projectManagers->random()->id,
                'status' => 'on_hold',
                'start_date' => Carbon::now()->subDays(15),
                'end_date' => Carbon::now()->addDays(45),
                'budget' => 80000000
            ]
        ];

        foreach ($sampleProjects as $projectData) {
            Project::firstOrCreate(
                ['name' => $projectData['name']],
                $projectData
            );
        }

        $this->command->info('Sample projects created successfully!');
    }
}