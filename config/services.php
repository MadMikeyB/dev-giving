<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'justgiving' => [
        'key'    => env('JUSTGIVING_KEY'),
        'secret' => env('JUSTGIVING_secret'),
    ],

    'github' => [
        'client_id'     => env('GITHUB_KEY'),         // Your GitHub Client ID
        'client_secret' => env('GITHUB_SECRET'), // Your GitHub Client Secret
        'redirect'      => env('GITHUB_REDIRECT', 'http://your-callback-url'),
    ],

];
