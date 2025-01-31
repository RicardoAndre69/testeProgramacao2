<?php
namespace Controller;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Model\Client; // Importa a classe Client

class ClientController {
    private $db;

    public function __construct(Connection $db) {
        $this->db = $db;
    }

    // Método para obter todos os clientes
    public function getClients() {
        try {
            // Prepara a consulta
            $sql = 'SELECT * FROM dadospessoais';
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            
            // Obtém todos os resultados
            $data = $stmt->fetchAll();
            $clients = [];

            // Cria instâncias de Client
            foreach ($data as $row) {
                $clients[] = new Client($row['id'], $row['nome'], $row['tipo']);
            }

            // Retorna a resposta JSON
            return new Response(json_encode($clients), 200, ['Content-Type' => 'application/json']);
        } catch (\Exception $e) {
            return new Response('Erro ao obter clientes: ' . $e->getMessage(), 500);
        }
    }

    public function createClient(Request $request) {
        $data = json_decode($request->getContent(), true);
    
        // Validação dos dados
        if (empty($data['nome']) || empty($data['tipo'])) {
            return new Response('Nome e tipo são obrigatórios.', 400);
        }
    
        try {
            // Insere o novo cliente
            $this->db->insert('dadospessoais', [
                'nome' => $data['nome'],
                'tipo' => $data['tipo'],
            ]);
            
            // Obtém o ID do último registro inserido
            $id = $this->db->lastInsertId();
            
            // Retorna o ID do cliente criado
            return new Response(json_encode(['id' => $id]), 201, ['Content-Type' => 'application/json']);
        } catch (\Exception $e) {
            return new Response('Erro ao criar cliente: ' . $e->getMessage(), 500);
        }
    }

    // Método para atualizar um cliente existente
    public function updateClient(Request $request, $id) {
        $data = json_decode($request->getContent(), true);

        // Validação dos dados
        if (empty($data['nome']) || empty($data['tipo'])) {
            return new Response('Nome e tipo são obrigatórios.', 400);
        }

        try {
            $this->db->update('dadospessoais', [
                'nome' => $data['nome'],
                'tipo' => $data['tipo'],
            ], ['id' => $id]);
            return new Response('Cliente atualizado', 200);
        } catch (\Exception $e) {
            return new Response('Erro ao atualizar cliente: ' . $e->getMessage(), 500);
        }
    }

    // Método para excluir um cliente
    public function deleteClient($id) {
        try {
            $this->db->delete('dadospessoais', ['id' => $id]);
            return new Response('Cliente excluído', 204);
        } catch (\Exception $e) {
            return new Response('Erro ao excluir cliente: ' . $e->getMessage(), 500);
        }
    }
}