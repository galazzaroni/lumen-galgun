<?php

return [

    /*
    |--------------------------------------------------------------------------
    | User Defined Variables
    |--------------------------------------------------------------------------
    |
    | This is a set of variables that are made specific to this application
    | that are better placed here rather than in .env file.
    | Use config('your_key') to get the values.
    |
    */

    'website_name' => env('WEBSITE_NAME','Galgun'),
    'website_email' => env('WEBSITE_EMAIL','galgunapp@gmail.com'),
    'frontend_url' => env('FRONTEND_URL', 'http://127.0.0.1:8080'),
];
