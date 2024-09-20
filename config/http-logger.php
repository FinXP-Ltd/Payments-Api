<?php

return [
    /**
     * Log requests
     *
     */
    'enabled' => env('HTTP_LOGGER_ENABLE', true),

    /**
     * Table Prefix for the migration table
     *
     */
    'table_prefix' => 'http_',

    /**
     * Specify database connection
     *
     */
    'connection' => env('HTTP_LOGGER_CONNECTION', env('DB_CONNECTION', 'mysql')),

    /**
     * Application name
     *
     */
    'application' => env('APP_NAME'),

    /**
     * Filter out fields which will never be logged
     *
     */
    'except' => [
        'password',
        'password_confirmation'
    ]
];
