<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Skill;
use App\Models\PortfolioImage;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample projects
        $projects = [
            [
                'title' => 'Character Design - Fantasy Warrior',
                'description' => 'A detailed character design for a fantasy game project. Created with attention to armor details, weapon design, and dynamic pose.',
                'client_name' => 'Game Studio XYZ',
                'completion_date' => '2026-03-15',
                'project_url' => 'https://example.com',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Anime Style Portrait',
                'description' => 'Custom anime-style portrait commission with vibrant colors and expressive character design.',
                'client_name' => 'Private Client',
                'completion_date' => '2026-03-20',
                'project_url' => null,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Manga Cover Art',
                'description' => 'Cover illustration for an indie manga series. Features dynamic composition and dramatic lighting.',
                'client_name' => 'Manga Publisher ABC',
                'completion_date' => '2026-03-25',
                'project_url' => 'https://example.com/manga',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Chibi Character Set',
                'description' => 'A set of chibi characters with various expressions and poses for a mobile game.',
                'client_name' => 'Mobile Games Inc',
                'completion_date' => '2026-03-28',
                'project_url' => null,
                'order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Concept Art - Environment',
                'description' => 'Environment concept art for an upcoming RPG game. Features mystical forest and ancient ruins.',
                'client_name' => 'RPG Studios',
                'completion_date' => '2026-04-01',
                'project_url' => 'https://example.com/concept',
                'order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }

        $this->command->info('✅ 5 sample projects created!');

        // Create sample skills
        $skills = [
            ['name' => 'Adobe Photoshop', 'category' => 'Software', 'proficiency' => 95, 'order' => 1, 'is_active' => true],
            ['name' => 'Clip Studio Paint', 'category' => 'Software', 'proficiency' => 90, 'order' => 2, 'is_active' => true],
            ['name' => 'Character Design', 'category' => 'Technique', 'proficiency' => 92, 'order' => 3, 'is_active' => true],
            ['name' => 'Digital Painting', 'category' => 'Technique', 'proficiency' => 88, 'order' => 4, 'is_active' => true],
            ['name' => 'Anime Style', 'category' => 'Style', 'proficiency' => 95, 'order' => 5, 'is_active' => true],
            ['name' => 'Semi-Realistic', 'category' => 'Style', 'proficiency' => 85, 'order' => 6, 'is_active' => true],
            ['name' => 'Concept Art', 'category' => 'Technique', 'proficiency' => 80, 'order' => 7, 'is_active' => true],
            ['name' => 'Illustration', 'category' => 'Technique', 'proficiency' => 90, 'order' => 8, 'is_active' => true],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }

        $this->command->info('✅ 8 sample skills created!');

        // Note: Portfolio images require actual image files, so we'll skip them for now
        // You can upload them manually through the admin panel

        $this->command->info('');
        $this->command->info('🎉 Sample data seeding complete!');
        $this->command->info('💡 Tip: Upload portfolio images manually through admin panel.');
    }
}
