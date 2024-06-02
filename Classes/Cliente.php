<?php
require_once 'Cadastro.php';

class Cliente extends Cadastro {
    public function __construct($database) {
        parent::__construct($database, 'clientes');
    }

    public function cadastrar($dados) {
        if (
            isset($dados['nome']) && isset($dados['sobrenome']) && isset($dados['endereco']) &&
            isset($dados['email']) && isset($dados['telefone']) && 
            (isset($dados['cpf']) || isset($dados['cnpj'])) && 
            !empty($dados['nome']) && !empty($dados['sobrenome']) && !empty($dados['endereco']) && 
            !empty($dados['email']) && !empty($dados['telefone']) && 
            (!empty($dados['cpf']) || !empty($dados['cnpj']))
        ) {
            parent::cadastrar([
                'nome' => $dados['nome'],
                'sobrenome' => $dados['sobrenome'],
                'endereco' => $dados['endereco'],
                'email' => $dados['email'],
                'telefone' => $dados['telefone'],
                'cpf' => $dados['cpf'] ?? '',
                'cnpj' => $dados['cnpj'] ?? ''
            ]);
        }
    }
}
