<?php

return [
    /*
    |--------------------------------------------------------------------------
    | DASH (VOD)
    |--------------------------------------------------------------------------
    |
    | This configures the DASH parameters.
    |
    */

    'dash' => [
        'url' => env('DASH_URL'),
        'key' => env('DASH_KEY'),
        'iv' => env('DASH_IV'),
    ],
];
