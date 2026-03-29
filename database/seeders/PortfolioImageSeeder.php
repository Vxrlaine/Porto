<?php

namespace Database\Seeders;

use App\Models\PortfolioImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PortfolioImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imagePath = public_path('storage/images');
        
        if (File::exists($imagePath)) {
            $files = File::files($imagePath);
            $order = 0;
            
            foreach ($files as $file) {
                // Only process image files
                if (in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    PortfolioImage::create([
                        'title' => pathinfo($file->getFilename(), PATHINFO_FILENAME),
                        'description' => null,
                        'image_path' => 'storage/images/' . $file->getFilename(),
                        'order' => $order,
                        'is_active' => true,
                    ]);
                    $order++;
                }
            }
        }
    }
}
