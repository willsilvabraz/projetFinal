<?php
require __DIR__ . '/../vendor/autoload.php';
require_once '../Classes/sessao.php';
require_once '../Classes/Firebase.php';
require_once '../Classes/CadastroFactory.php';
require_once '../Classes/Vendas.php';

$sessao = Sessao::getInstancia();
$sessao->requerLogin();

$firebaseConnection = Firebase::getInstance();
$database = $firebaseConnection->getDatabase();

$gerenciadorClientes = CadastroFactory::criarCadastro('cliente', $database);
$gerenciadorProdutos = CadastroFactory::criarCadastro('produto', $database);

$clientes = $gerenciadorClientes->listar();
$produtos = $gerenciadorProdutos->listar();

$cadastro = CadastroFactory::criarCadastro('vendas', $database);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['produto_id']) && !empty($_POST['quantidade'])) {
        $produto_id = $_POST['produto_id'];
        $quantidade = $_POST['quantidade'];
        $produto = $produtos[$produto_id];
        $total = $produto['preco'] * $quantidade;

        $_POST['total'] = $total;

        $cadastro->cadastrar($_POST);
        echo json_encode(['status' => 'success']);
        exit;
    }
}

if (isset($_GET['delete'])) {
    $cadastro->deletar($_GET['delete']);
    echo json_encode(['status' => 'success']);
    exit;
}

$vendas = $cadastro->listar();
header('Content-Type: application/json');
echo json_encode(['vendas' => $vendas, 'clientes' => $clientes, 'produtos' => $produtos]);

