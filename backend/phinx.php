<?php

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/seeds',
    ],

    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'development',

        'development' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'testeprogramacaophp',
            'user' => 'root',
            'pass' => '',
            'port' => 3307,
            'charset' => 'utf8',
        ],
    ],
];