<?php
require_once __DIR__.'/../vendor/autoload.php';

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Controller\ClientController;
use Doctrine\DBAL\DriverManager;

// Inicializa o aplicativo Silex
$app = new Application();

// Configuração do banco de dados
$app['db'] = function() {
    return DriverManager::getConnection([
        'dbname' => 'testeprogramacaophp', 
        'user' => 'root',                   
        'password' => '',                   
        'host' => 'localhost',
        'port' => 3307,              
        'driver' => 'pdo_mysql',            
    ]);
};

// Inicializa o controlador com a conexão do banco de dados
$clientController = new ClientController($app['db']);

// Define as rotas da API
$app->get('/api/dados_pessoais', [$clientController, 'getClients']);
$app->post('/api/dados_pessoais', [$clientController, 'createClient']); 
$app->put('/api/dados_pessoais/{id}', [$clientController, 'updateClient']);
$app->delete('/api/dados_pessoais/{id}', [$clientController, 'deleteClient']); 

// Rota para servir arquivos estáticos
$app->get('/{path}', function ($path) {
    $file = __DIR__ . '/../../' . $path; 
    if (file_exists($file)) {
        return new Response(file_get_contents($file), 200);
    }
    return new Response('Not Found', 404);
})->assert('path', '.*');

// Configuração de CORS
$app->after(function (Request $request, Response $response) {
    $response->headers->set('Access-Control-Allow-Origin', '*'); 
    $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS'); 
    $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization'); 
});

// Resposta para requisições OPTIONS
$app->options('/api/dados_pessoais', function() {
    return new Response('', 200);
});

$app->options('/api/dados_pessoais/{id}', function() {
    return new Response('', 200);
});

// Executa o aplicativo
$app->run();