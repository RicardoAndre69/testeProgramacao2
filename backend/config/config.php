<?php
use Doctrine\DBAL\DriverManager;

$connectionParams = [
    'dbname' => 'testeprogramacaophp',
    'user' => 'root',
    'password' => '',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
];

try {
    $conn = DriverManager::getConnection($connectionParams);
    echo "Conexão bem-sucedida!";
} catch (Exception $e) {
    echo "Erro ao conectar: " . $e->getMessage();
}

return DriverManager::getConnection($connectionParams);