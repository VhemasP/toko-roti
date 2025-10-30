<?php

return [
    'defaults' => [
        'guard' => 'customer', // <-- Ubah defaultnya ke customer
        'passwords' => 'users',
    ],

    'guards' => [
        // Guard untuk Customer
        'customer' => [
            'driver' => 'session',
            'provider' => 'customers', // <-- Perhatikan 's' di akhir
        ],

        // Guard untuk Admin
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins', // <-- Perhatikan 's' di akhir
        ],
    ],

    'providers' => [
        // Provider untuk Customer
        'customers' => [ // <-- 's' di akhir harus sama dengan 'provider' di atas
            'driver' => 'eloquent',
            'model' => App\Models\Customer::class,
        ],

        // Provider untuk Admin
        'admins' => [ // <-- 's' di akhir harus sama dengan 'provider' di atas
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],

        // Biarkan 'users' ini, mungkin dibutuhkan oleh password reset
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];