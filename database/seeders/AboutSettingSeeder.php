<?php

namespace Database\Seeders;

use App\Models\AboutSetting;
use Illuminate\Database\Seeder;

class AboutSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AboutSetting::create([
            'title' => 'About me',
            'description' => "Hi, I'm a character illustrator passionate about bringing unique characters to life. From expressive anime-style designs to detailed character concepts, I create visuals that tell stories and capture personality. My work focuses on emotion, style, and imagination turning ideas into memorable characters. Let's create something amazing together!",
            'image_path' => 'storage/images/whale.png',
            'subtitle' => 'illustrator',
            'is_active' => true,
        ]);
    }
}
