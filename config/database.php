<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB2_HOST', '10.45.70.100'),
            'port' => env('DB2_PORT', '3306'),
            'database' => env('DB2_DATABASE', 'check_weight'),
            'username' => env('DB2_USERNAME', 'lacouser'),
            'password' => env('DB2_PASSWORD', 'L@CO1993'),
        ],

        'dbweight1' => [
            'driver' => 'mysql',
            'host' => env('DBW1_HOST', '10.45.70.101'),
            'port' => env('DBW1_PORT', '3306'),
            'database' => env('DBW1_DATABASE', 'check_weight'),
            'username' => env('DBW1_USERNAME', 'lacouser'),
            'password' => env('DBW1_PASSWORD', 'L@CO1993'),
        ],

        'dbweight2' => [
            'driver' => 'mysql',
            'host' => env('DBW2_HOST', '10.45.70.102'),
            'port' => env('DBW2_PORT', '3306'),
            'database' => env('DBW2_DATABASE', 'check_weight'),
            'username' => env('DBW2_USERNAME', 'lacouser'),
            'password' => env('DBW2_PASSWORD', 'L@CO1993'),
        ],

        'dbweight3' => [
            'driver' => 'mysql',
            'host' => env('DBW3_HOST', '10.45.70.103'),
            'port' => env('DBW3_PORT', '3306'),
            'database' => env('DBW3_DATABASE', 'check_weight'),
            'username' => env('DBW3_USERNAME', 'lacouser'),
            'password' => env('DBW3_PASSWORD', 'L@CO1993'),
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],

];
