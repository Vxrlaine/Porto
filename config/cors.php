<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

    'allowed_origins' => env('CORS_ALLOWED_ORIGINS', '*') === '*' ? ['*'] : explode(',', env('CORS_ALLOWED_ORIGINS', '')),

    'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],

    'allowed_headers' => ['Content-Type', 'Authorization', 'X-Requested-With', 'X-CSRF-TOKEN'],

    'max_age' => 86400,
];
