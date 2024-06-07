<?php
require __DIR__.'/../vendor/autoload.php';
require_once '../Classes/sessao.php';
require_once '../Classes/Firebase.php';
require_once '../Classes/CadastroFactory.php';

$sessao = Sessao::getInstancia();
$sessao->requerLogin();

$firebaseConnection = Firebase::getInstance();
$database = $firebaseConnection->getDatabase();

$cadastro = CadastroFactory::criarCadastro('produto', $database);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cadastro->cadastrar($_POST);
    echo json_encode(['status' => 'success']);
    exit;
}

if (isset($_GET['delete'])) {
    $cadastro->deletar($_GET['delete']);
    echo json_encode(['status' => 'success']);
    exit;
}

$produtos = $cadastro->listar();
echo json_encode($produtos);
