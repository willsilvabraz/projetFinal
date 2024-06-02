<?php
require_once 'Cliente.php';
require_once 'Produto.php';
require_once 'Usuarios.php';
require_once 'Vendas.php'; 

class CadastroFactory {
    public static function criarCadastro($tipo, $database) {
        switch ($tipo) {
            case 'cliente':
                return new Cliente($database);
            case 'produto':
                return new Produto($database);
            case 'usuarios':
                return new Usuarios($database);
            case 'vendas':
                return new Vendas($database);
            default:
                throw new Exception("Tipo de cadastro desconhecido.");
        }
    }
}
