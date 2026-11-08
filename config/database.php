<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | الاتصال الافتراضي بقاعدة البيانات
    |--------------------------------------------------------------------------
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | اتصالات قواعد البيانات
    |--------------------------------------------------------------------------
    */

    'connections' => [

        /*
        |--------------------------------------------------------------------------
        | SQLite
        |--------------------------------------------------------------------------
        */

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DB_URL'),
            'database' => env(
                'DB_DATABASE',
                database_path('database.sqlite')
            ),
            'prefix' => '',
            'foreign_key_constraints' => env(
                'DB_FOREIGN_KEYS',
                true
            ),
            'busy_timeout' => null,
            'journal_mode' => null,
            'synchronous' => null,
        ],

        /*
        |--------------------------------------------------------------------------
        | MySQL - Wasmer
        |--------------------------------------------------------------------------
        */

        'mysql' => [
            'driver' => 'mysql',

            /*
            |--------------------------------------------------------------------------
            | لا تستخدم DATABASE_URL إذا كنت تعتمد على متغيرات DB_*.
            |--------------------------------------------------------------------------
            */
            'url' => null,

            'host' => env(
                'DB_HOST',
                '127.0.0.1'
            ),

            'port' => env(
                'DB_PORT',
                '3306'
            ),

            /*
            |--------------------------------------------------------------------------
            | Wasmer يستخدم DB_NAME
            | وLaravel يستخدم عادة DB_DATABASE
            | لذلك نقرأ DB_NAME أولاً.
            |--------------------------------------------------------------------------
            */
            'database' => env(
                'DB_NAME',
                env(
                    'DB_DATABASE',
                    'laravel'
                )
            ),

            'username' => env(
                'DB_USERNAME',
                'root'
            ),

            'password' => env(
                'DB_PASSWORD',
                ''
            ),

            'unix_socket' => env(
                'DB_SOCKET',
                ''
            ),

            'charset' => env(
                'DB_CHARSET',
                'utf8mb4'
            ),

            'collation' => env(
                'DB_COLLATION',
                'utf8mb4_unicode_ci'
            ),

            'prefix' => '',

            'prefix_indexes' => true,

            'strict' => true,

            'engine' => null,

            'options' => extension_loaded('pdo_mysql')
                ? array_filter([
                    PDO::MYSQL_ATTR_SSL_CA => env(
                        'MYSQL_ATTR_SSL_CA'
                    ),
                ])
                : [],
        ],

        /*
        |--------------------------------------------------------------------------
        | MariaDB
        |--------------------------------------------------------------------------
        */

        'mariadb' => [
            'driver' => 'mariadb',
            'url' => env('DATABASE_URL'),

            'host' => env(
                'DB_HOST',
                '127.0.0.1'
            ),

            'port' => env(
                'DB_PORT',
                '3306'
            ),

            'database' => env(
                'DB_NAME',
                env(
                    'DB_DATABASE',
                    'laravel'
                )
            ),

            'username' => env(
                'DB_USERNAME',
                'root'
            ),

            'password' => env(
                'DB_PASSWORD',
                ''
            ),

            'unix_socket' => env(
                'DB_SOCKET',
                ''
            ),

            'charset' => env(
                'DB_CHARSET',
                'utf8mb4'
            ),

            'collation' => env(
                'DB_COLLATION',
                'utf8mb4_unicode_ci'
            ),

            'prefix' => '',

            'prefix_indexes' => true,

            'strict' => true,

            'engine' => null,

            'options' => extension_loaded('pdo_mysql')
                ? array_filter([
                    PDO::MYSQL_ATTR_SSL_CA => env(
                        'MYSQL_ATTR_SSL_CA'
                    ),
                ])
                : [],
        ],

        /*
        |--------------------------------------------------------------------------
        | PostgreSQL
        |--------------------------------------------------------------------------
        */

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),

            'host' => env(
                'DB_HOST',
                '127.0.0.1'
            ),

            'port' => env(
                'DB_PORT',
                '5432'
            ),

            'database' => env(
                'DB_NAME',
                env(
                    'DB_DATABASE',
                    'laravel'
                )
            ),

            'username' => env(
                'DB_USERNAME',
                'root'
            ),

            'password' => env(
                'DB_PASSWORD',
                ''
            ),

            'charset' => env(
                'DB_CHARSET',
                'utf8'
            ),

            'prefix' => '',

            'prefix_indexes' => true,

            'search_path' => 'public',

            'sslmode' => 'require',
        ],

        /*
        |--------------------------------------------------------------------------
        | SQL Server
        |--------------------------------------------------------------------------
        */

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),

            'host' => env(
                'DB_HOST',
                'localhost'
            ),

            'port' => env(
                'DB_PORT',
                '1433'
            ),

            'database' => env(
                'DB_NAME',
                env(
                    'DB_DATABASE',
                    'laravel'
                )
            ),

            'username' => env(
                'DB_USERNAME',
                'root'
            ),

            'password' => env(
                'DB_PASSWORD',
                ''
            ),

            'charset' => env(
                'DB_CHARSET',
                'utf8'
            ),

            'prefix' => '',

            'prefix_indexes' => true,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | جدول تسجيل عمليات Migration
    |--------------------------------------------------------------------------
    */

    'migrations' => [
        'table' => 'migrations',
        'update_date_on_publish' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Redis
    |--------------------------------------------------------------------------
    */

    'redis' => [

        'client' => env(
            'REDIS_CLIENT',
            'phpredis'
        ),

        'options' => [
            'cluster' => env(
                'REDIS_CLUSTER',
                'redis'
            ),

            'prefix' => Str::slug(
                (string) env(
                    'APP_NAME',
                    'laravel'
                )
            ) . '-database-',

            'persistent' => env(
                'REDIS_PERSISTENT',
                false
            ),
        ],

        'default' => [
            'url' => env('REDIS_URL'),

            'host' => env(
                'REDIS_HOST',
                '127.0.0.1'
            ),

            'username' => env(
                'REDIS_USERNAME'
            ),

            'password' => env(
                'REDIS_PASSWORD'
            ),

            'port' => env(
                'REDIS_PORT',
                '6379'
            ),

            'database' => env(
                'REDIS_DB',
                '0'
            ),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),

            'host' => env(
                'REDIS_HOST',
                '127.0.0.1'
            ),

            'username' => env(
                'REDIS_USERNAME'
            ),

            'password' => env(
                'REDIS_PASSWORD'
            ),

            'port' => env(
                'REDIS_PORT',
                '6379'
            ),

            'database' => env(
                'REDIS_CACHE_DB',
                '1'
            ),
        ],

    ],

];
