<?php

namespace Database\Seeders;

use App\Models\ProjectType;
use Illuminate\Database\Seeder;

class ProjectTypeSeeder extends Seeder
{
    public function run(): void
    {
        $projectTypes = [
            [
                'name' => 'Website Development',
                'description' => 'Pengembangan website dan aplikasi web'
            ],
            [
                'name' => 'Mobile Application',
                'description' => 'Pengembangan aplikasi mobile iOS dan Android'
            ],
            [
                'name' => 'Cyber Security',
                'description' => 'Proyek keamanan siber dan penetration testing'
            ],
            [
                'name' => 'System Integration',
                'description' => 'Integrasi sistem dan API development'
            ],
            [
                'name' => 'UI/UX Design',
                'description' => 'Desain antarmuka dan pengalaman pengguna'
            ],
            [
                'name' => 'Data Analytics',
                'description' => 'Analisis data dan business intelligence'
            ]
        ];

        foreach ($projectTypes as $type) {
            ProjectType::firstOrCreate(
                ['name' => $type['name']],
                $type
            );
        }
    }
}
