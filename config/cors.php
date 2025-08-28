<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    // 'paths' => ['api/*', 'sanctum/csrf-cookie'],

    // 'allowed_methods' => ['*'],

    // 'allowed_origins' => ['https://csd-dashboard.vercel.app', 'http://localhost:5174', 'http://localhost:5173', 'https://csd-website-xi.vercel.app', 'https://cs.fs.rupp.edu.kh'],

    // // 'allowed_origins' => ['*'],

    // 'allowed_origins_patterns' => [],

    // 'allowed_headers' => ['*'],

    // 'exposed_headers' => [],

    // 'max_age' => 0,

    // // 'supports_credentials' => false,

    // 'supports_credentials' => true,

    // In config/cors.php

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [], // <-- Make this empty

    'allowed_origins_patterns' => [
        '~^http://localhost:(5173|5174)$~',
        '~^https://(csd-website-xi\.vercel\.app|cs\.fs\.rupp\.edu\.kh|csd-dashboard\.vercel\.app)$~'
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];

