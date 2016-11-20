<?php

return [

    /**
     *  Supported adapters: flock, memcache, memcached, mysql, redis, predis
     */
    "driver" => env("MUTEX_DRIVER", "memcached"),

    /**
     * Driver storage
     */
    "storage" => [

        'mysql' => [
            'user' => '',
            'passsword' => '',
            'host' => "",
            'port' => 3306,
        ],

        'flock' => [
            'dir' => storage_path('framework/mutex'),
        ],

        'memcached' => [
            'persistent_id' => env('MEMCACHED_PERSISTENT_ID'),
            'sasl' => [
                env('MEMCACHED_USERNAME'),
                env('MEMCACHED_PASSWORD'),
            ],
            'options' => [
                // Memcached::OPT_CONNECT_TIMEOUT  => 2000,
            ],
            'servers' => [
                [
                    'host' => env('MEMCACHED_HOST', '127.0.0.1'),
                    'port' => env('MEMCACHED_PORT', 11211),
                    'weight' => 100,
                ],
            ],
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],
    ]
];