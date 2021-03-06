<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\Models\Users\Entities\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_OAUTH_CLIENT_ID', '174734986373-i2cf552os2l0ui4hmfbk66h43h0k3kuv.apps.googleusercontent.com'),
        'client_secret' => env('GOOGLE_OAUTH_CLIENT_SECRET', 'VIF83p_Rnn4W6aIq7oZ21FpX'),
        'redirect' => env('GOOGLE_OAUTH_CLIENT_REDIRECT_URL', 'http://admin.atypical-ecommerce-app.dev:8080/auth/social/callback/google')
    ],
];
