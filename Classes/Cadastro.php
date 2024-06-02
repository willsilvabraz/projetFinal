<?php
class Cadastro {
    protected $database;
    protected $reference;

    public function __construct($database, $reference) {
        $this->database = $database;
        $this->reference = $reference;
    }

    public function cadastrar($dados) {
        $this->database->getReference($this->reference)->push($dados);
    }

    public function deletar($id) {
        $this->database->getReference($this->reference . '/' . $id)->remove();
    }

    public function listar() { 
        return $this->database->getReference($this->reference)->getSnapshot()->getValue();
    }
}