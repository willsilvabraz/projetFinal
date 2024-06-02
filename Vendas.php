<?php
require_once 'Cadastro.php';

class Vendas extends Cadastro {
    public function __construct($database) {
        parent::__construct($database, 'vendas');
    }

    public function cadastrar($dados) {
        if (
            isset($_POST['cliente_id']) && isset($_POST['produto_id']) && isset($_POST['quantidade'])  && isset($_POST['total']) &&
            !empty($_POST['cliente_id']) && !empty($_POST['produto_id']) && !empty($_POST['quantidade'] && !empty($_POST['total']))
        ) {
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