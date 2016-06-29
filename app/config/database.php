<?php

return [
    'fetch'       => PDO::FETCH_CLASS,
    'default'     => 'cakephp_db',
    'connections' => [
        'sqlite'        => [
            'driver'   => 'sqlite',
            'database' => __DIR__ . '/../database/production.sqlite',
            'prefix'   => '',
        ],
        /**
         * コメントアウト分に関しては、メディアによって動的であるため
         * app/models/Initialize.phpにて、DBの値から当て込んでいる
         */
        'cakephp_db'        => [
            'driver'                           => 'mysql',
            'host'                             => 'localhost',
            'database'                         => 'cakephp_db',
            'username'                         => 'root',
            'password'                         => '',
            'charset'                          => 'utf8',
            'collation'                        => 'utf8_unicode_ci',
            'prefix'                           => '',
            'port'                             => 3306,
            'socket'                           => '/tmp/mysql.sock',
            PDO::ATTR_PERSISTENT               => true,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
        ],
        'login'      => [
            'driver'                           => 'mysql',
            'host'                             => 'localhost',
            'database'                         => 'login',
            'username'                         => 'root',
            'password'                         => '',
            'charset'                          => 'utf8',
            'collation'                        => 'utf8_unicode_ci',
            'prefix'                           => '',
            PDO::ATTR_PERSISTENT               => true,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
        ]
    ],
    'migrations'  => 'migrations',
    'redis'       => [
        'cluster' => false,
        'default' => [
            'scheme'   => 'unix',
            'path'     => '/tmp/redis.sock',
            'database' => 0,
        ],
    ],
];

