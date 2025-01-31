<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;
use Controller\ClientController;

// Inicializa o aplicativo
$app = new Application();

// Carrega a configuração do banco de dados
$app['db'] = function() {
    return \Doctrine\DBAL\DriverManager::getConnection([
        'dbname' => 'testeprogramacaophp',
        'user' => 'root',
        'password' => '', 
        'host' => 'localhost',
        'port' => 3307,
        'driver' => 'pdo_mysql',
    ]);
};

// Instância do ClientController
$clientController = new ClientController($app['db']);

// Definindo as rotas
$app->get('/api/dados_pessoais', [$clientController, 'getClients']);
$app->post('/api/dados_pessoais', [$clientController, 'createClient']);
$app->put('/api/dados_pessoais/{id}', [$clientController, 'updateClient']);
$app->delete('/api/dados_pessoais/{id}', [$clientController, 'deleteClient']);

// Cria a requisição a partir dos dados globais
$request = Request::createFromGlobals();

// Manipula a requisição e obtém a resposta
$response = $app->handle($request);

// Envia a resposta
$response->send();