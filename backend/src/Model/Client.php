<?php
namespace Model;

class Client {
    private $id;
    private $nome; 
    private $tipo;

    public function __construct($id, $nome, $tipo) { 
        $this->id = $id;
        $this->nome = $nome;
        $this->tipo = $tipo;
    }

    // Getters e Setters
    public function getId() {
        return $this->id;
    }

    public function getNome() { 
        return $this->nome;
    }

    public function getTipo() {
        return $this->tipo; 
    }
}