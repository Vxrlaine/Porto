<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProjectImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete all existing projects
        Project::truncate();
        $this->command->info('🗑️  All existing projects deleted.');

        // Get all images from public/storage/images
        $sourceDir = public_path('storage/images');
        
        if (!File::exists($sourceDir)) {
            $this->command->error("❌ Directory not found: public/storage/images");
            return;
        }

        $imageFiles = File::files($sourceDir);
        
        if (empty($imageFiles)) {
            $this->command->warn("⚠️  No images found in public/storage/images");
            return;
        }

        $this->command->info("📸 Found " . count($imageFiles) . " images");

        // Create projects with images
        $order = 1;
        foreach ($imageFiles as $index => $file) {
            $filename = $file->getFilename();
            $extension = $file->getExtension();
            $title = pathinfo($filename, PATHINFO_FILENAME);
            
            // Copy image to storage (both locations for compatibility)
            $destinationPath = 'projects/' . $filename;
            
            // Copy to storage/app/public (Laravel storage)
            Storage::disk('public')->put($destinationPath, File::get($file->getPathname()));
            
            // Copy to public/storage (direct web access)
            $publicDest = public_path('storage/' . $destinationPath);
            $publicDir = dirname($publicDest);
            if (!File::exists($publicDir)) {
                File::makeDirectory($publicDir, 0755, true);
            }
            File::copy($file->getPathname(), $publicDest);

            // Create project
            Project::create([
                'title' => ucfirst(str_replace(['-', '_'], ' ', $title)),
                'description' => 'Project showcase featuring ' . $title . '. Created with attention to detail and creative vision.',
                'client_name' => 'Portfolio Project',
                'completion_date' => now()->subDays(rand(1, 60))->format('Y-m-d'),
                'project_url' => null,
                'order' => $order,
                'is_active' => true,
                'image_path' => $destinationPath,
            ]);

            $this->command->info("✅ Project {$order}: {$title}");
            $order++;
        }

        $this->command->info('');
        $this->command->info('🎉 Project seeding complete!');
        $this->command->info('📊 Total projects created: ' . Project::count());
        $this->command->info('💡 Images location: storage/app/public/projects/');
    }
}
