<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Environment - Users
    |--------------------------------------------------------------------------
    */
    'admin' => [
        'name' => env('ADMIN_NAME'),
        'email' => env('ADMIN_EMAIL'),
        'password' => env('ADMIN_PASSWORD'),
    ],
    'cashier' => [
        'name' => env('CASHIER_NAME'),
        'email' => env('CASHIER_EMAIL'),
        'password' => env('CASHIER_PASSWORD'),
    ],
    'customer' => [
        'name' => env('CUSTOMER_NAME'),
        'email' => env('CUSTOMER_EMAIL'),
        'password' => env('CUSTOMER_PASSWORD'),
    ],

];
