<?php
require_once 'Cadastro.php';
require_once 'Firebase.php';

class Produto extends Cadastro {
    public function __construct($database) {
        parent::__construct($database, 'produtos');
    }

    public function cadastrar($dados) {
        if (isset($dados['nome']) && isset($dados['descricao']) && isset($dados['preco']) && !empty($dados['nome']) && !empty($dados['descricao']) && !empty($dados['preco'])) {
            parent::cadastrar([
                'nome' => $dados['nome'],
                'descricao' => $dados['descricao'],
                'preco' => $dados['preco']
            ]);
        }
    }
    public function getPreco($produtoId) {
        $firebase = Firebase::getInstance();
        $database = $firebase->getDatabase();

        $produtoRef = $database->getReference('produtos/' . $produtoId);
        $produto = $produtoRef->getValue();

        if ($produto && isset($produto['preco'])) {
            return $produto['preco'];
        } else {
            throw new Exception("Produto não encontrado ou preço não definido.");
        }
    }
}
