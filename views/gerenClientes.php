<?php

require __DIR__.'views/../vendor/autoload.php';

require_once '../Classes/sessao.php';
require_once '../Classes/Firebase.php';
require_once '../Classes/CadastroFactory.php';

$sessao = Sessao::getInstancia();
$sessao->requerLogin();

$firebase = Firebase::getInstance();
$database = $firebase->getDatabase();

$cadastro = CadastroFactory::criarCadastro('cliente', $database);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cadastro->cadastrar($_POST);
}

if (isset($_GET['delete'])) {
    $cadastro->deletar($_GET['delete']);
}

$clientes = $cadastro->listar();

header('Content-Type: application/json');
echo json_encode($clientes);


