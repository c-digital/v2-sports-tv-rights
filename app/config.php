<?php

return [
    // General.
    'application_name' => 'Sports TV Rights',
    'version' => '1.0.0',

    // Region.
    'language' => 'es',
    'timezone' => 'America/La_Paz',
    'charset' => 'utf-8',

    // Environment.
    'environment' => 'development',
    'errors' => true,
    'maintenance' => false,

    // Database.
    'database' => [
        [
            'name' => 'default',
            'driver' => 'mysql',
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'database' => 'sports-tv-rights',
            'port' => '3306',
        ],
    ],

    // Emails in localhost.
    'smtp' => [
        'host' => '',
        'username' => '',
        'password' => '',
        'port' => '',
    ],
];
