<?php

namespace App\Console\Commands;

use App\Models\PortfolioImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportPortfolioImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'portfolio:import {--fresh : Delete existing records before importing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import portfolio images from public/storage/images to database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $imagePath = public_path('storage/images');

        if (!File::exists($imagePath)) {
            $this->error("Directory {$imagePath} does not exist!");
            return 1;
        }

        $files = File::files($imagePath);
        $imageFiles = array_filter($files, function ($file) {
            return in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
        });

        if (empty($imageFiles)) {
            $this->warn("No image files found in {$imagePath}");
            return 0;
        }

        $this->info("Found " . count($imageFiles) . " image files");

        if ($this->option('fresh')) {
            $this->info('Deleting existing records...');
            PortfolioImage::truncate();
        }

        $order = PortfolioImage::max('order') ?? -1;
        $imported = 0;
        $skipped = 0;

        $bar = $this->output->createProgressBar(count($imageFiles));
        $bar->start();

        foreach ($imageFiles as $file) {
            $filename = $file->getFilename();
            $path = 'storage/images/' . $filename;

            // Check if already exists
            if (PortfolioImage::where('image_path', $path)->exists()) {
                $skipped++;
                $bar->advance();
                continue;
            }

            PortfolioImage::create([
                'title' => pathinfo($filename, PATHINFO_FILENAME),
                'description' => null,
                'image_path' => $path,
                'order' => ++$order,
                'is_active' => true,
            ]);

            $imported++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Import completed!");
        $this->table(
            ['Status', 'Count'],
            [
                ['Imported', $imported],
                ['Skipped (already exists)', $skipped],
                ['Total', count($imageFiles)],
            ]
        );

        return 0;
    }
}
