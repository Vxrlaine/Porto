<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Portfolio Carousel Images
    |--------------------------------------------------------------------------
    |
    | Add your project images here. Each image will be displayed as a card
    | in the fan-style carousel. Images should be stored in:
    | public/storage/images/
    |
    | You can add as many images as you want. The carousel will automatically
    | display 5 cards at a time (2 left, 1 center, 2 right).
    |
    */
    'carousel_images' => [
        [
            'src' => 'storage/images/project1.jpg',
            'alt' => 'Project 1',
            'title' => 'Project Title 1',
            'description' => 'Project description here',
        ],
        [
            'src' => 'storage/images/project2.jpg',
            'alt' => 'Project 2',
            'title' => 'Project Title 2',
            'description' => 'Project description here',
        ],
        [
            'src' => 'storage/images/project3.jpg',
            'alt' => 'Project 3',
            'title' => 'Project Title 3',
            'description' => 'Project description here',
        ],
        [
            'src' => 'storage/images/project4.jpg',
            'alt' => 'Project 4',
            'title' => 'Project Title 4',
            'description' => 'Project description here',
        ],
        [
            'src' => 'storage/images/project5.jpg',
            'alt' => 'Project 5',
            'title' => 'Project Title 5',
            'description' => 'Project description here',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | About Section
    |--------------------------------------------------------------------------
    */
    'about' => [
        'title' => 'About me',
        'description' => "Hi, I'm a character illustrator passionate about bringing unique characters to life. From expressive anime-style designs to detailed character concepts, I create visuals that tell stories and capture personality. My work focuses on emotion, style, and imagination turning ideas into memorable characters. Let's create something amazing together!",
        'image' => 'storage/images/about-me.jpg', // Set to null to show placeholder
        'subtitle' => 'illustrator',
    ],

    /*
    |--------------------------------------------------------------------------
    | Experience Section
    |--------------------------------------------------------------------------
    */
    'experiences' => [
        [
            'title' => 'ILLUSTRATOR',
            'description' => 'Create stylized illustrations and character artwork using Ibis Paint. Focused on expressive designs, detailed visuals, and storytelling through art.',
        ],
        [
            'title' => 'FREELANCE',
            'description' => 'Work with clients to create custom character illustrations and commissioned artwork based on their ideas, concepts, and creative direction.',
        ],
        [
            'title' => 'CHARACTER DESIGNER',
            'description' => 'Design unique and memorable characters for personal projects and client commissions, combining creativity, personality, and visual storytelling.',
        ],
    ],
];
