<?php
use Doctrine\DBAL\DriverManager;

$connectionParams = [
    'dbname' => 'your_database_name',
    'user' => 'your_username',
    'password' => 'your_password',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
];

return DriverManager::getConnection($connectionParams);