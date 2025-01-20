<?php
namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Método para obter todos os clientes
    public function getClients() {
        $clients = $this->db->fetchAll('SELECT * FROM clients');
        return new Response(json_encode($clients), 200, ['Content-Type' => 'application/json']);
    }

    // Método para criar um novo cliente
    public function createClient(Request $request) {
        $data = json_decode($request->getContent(), true);
        $this->db->insert('clients', [
            'name' => $data['name'],
            'type' => $data['type'],
        ]);
        return new Response('Client created', 201);
    }

    // Método para atualizar um cliente existente
    public function updateClient(Request $request, $id) {
        $data = json_decode($request->getContent(), true);
        $this->db->update('clients', [
            'name' => $data['name'],
            'type' => $data['type'],
        ], ['id' => $id]);
        return new Response('Client updated', 200);
    }

    // Método para excluir um cliente
    public function deleteClient($id) {
        $this->db->delete('clients', ['id' => $id]);
        return new Response('Client deleted', 204);
    }
}