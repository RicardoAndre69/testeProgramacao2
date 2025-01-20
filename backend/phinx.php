<?php

return [
    'paths' => [
        'migrations' => 'db/migrations', // Atualize o caminho aqui
        'seeds' => 'db/seeds',
    ],

    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'development',

        'development' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'your_database_name',
            'user' => 'your_username',
            'pass' => 'your_password',
            'port' => 3306,
            'charset' => 'utf8',
        ],
    ],
];