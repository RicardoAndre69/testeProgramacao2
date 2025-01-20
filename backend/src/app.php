<?php
require_once __DIR__.'/../vendor/autoload.php';

use Silex\Application;
use Controller\ClientController;

$app = new Application();
$db = require __DIR__.'/../config/config.php';

// Instanciando o controlador de clientes
$clientController = new ClientController($db);

// Definindo as rotas da API
$app->get('/clients', [$clientController, 'getClients']);
$app->post('/clients', [$clientController, 'createClient']);
$app->put('/clients/{id}', [$clientController, 'updateClient']);
$app->delete('/clients/{id}', [$clientController, 'deleteClient']);

// Adicione rotas para editar e excluir clientes conforme necessário

$app->run();