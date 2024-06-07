<?php
require_once 'Cadastro.php';

class Usuarios extends Cadastro {
    public function __construct($database) {
        parent::__construct($database, 'usuarios');
    }

    public function cadastrar($dados) {
        if (isset($dados['nome']) && isset($dados['email']) && isset($dados['senha']) && isset($dados['cargo']) && !empty($dados['nome']) && !empty($dados['email']) && !empty($dados['senha']) && !empty($dados['cargo'])) {
            parent::cadastrar([
                'nome' => $dados['nome'],
                'email' => $dados['email'],
                'senha' => $dados['senha'],
                'cargo' => $dados['cargo'],
                
            ]);
        }
    }
}
