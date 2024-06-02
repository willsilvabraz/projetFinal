<?php
require_once 'Cadastro.php';

class Usuarios extends Cadastro {
    public function __construct($database) {
        parent::__construct($database, 'usuarios');
    }

    public function cadastrar($dados) {
        if (isset($dados['nome']) && isset($dados['email']) && isset($dados['senha']) && isset($dados['cargo']) && !empty($dados['nome']) && !empty($dados['email']) && !empty($dados['senha']) && !empty($dados['cargo'])) {
            parent::cadastrar([
                'cliente_id' => $dados['cliente_id'],
                'produto_id' => $dados['produto_id'],
                'quantidade' => $dados['quantidade'],
                'total' => $dados['total'],
                'data' => date("Y-m-d H:i:s")
            ]);
        }
    }
}