<?php
require __DIR__.'/vendor/autoload.php';
require_once 'Sessao.php';
require_once 'Firebase.php';
require_once 'CadastroFactory.php';
require_once 'Vendas.php';

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
    $produto_id = $_POST['produto_id'];
    $quantidade = $_POST['quantidade'];
    $produto = $produtos[$produto_id];
    $total = $produto['preco'] * $quantidade;

    $_POST['total'] = $total;

    $cadastro->cadastrar($_POST);
}

$vendas = $cadastro->listar();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Vendas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <div class="col-12" id="cad">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h1>Registro de Vendas</h1>
            <div class="form-group">
                <label for="cliente_id">Cliente:</label>
                <select class="form-control" id="cliente_id" name="cliente_id" required>
                    <?php foreach ($clientes as $key => $cliente): ?>
                        <option value="<?php echo $key; ?>"><?php echo $cliente['nome']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="produto_id">Produto:</label>
                <select class="form-control" id="produto_id" name="produto_id" required>
                    <?php foreach ($produtos as $key => $produto): ?>
                        <option value="<?php echo $key; ?>"><?php echo $produto['nome']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="quantidade">Quantidade:</label>
                <input type="number" class="form-control" id="quantidade" name="quantidade" required>
            </div>

            <div class="form-group">
                <label for="total">Total:</label>
                <input type="text" class="form-control" id="total" name="total" readonly required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar Venda</button>
        </form>
    </div>

    <table class="table-responsive" id="listavendas">
        <h2>Lista de Vendas</h2>
        <thead>
            <tr>
                <th>ID Cliente</th>
                <th>ID Produto</th>
                <th>Quantidade</th>
                <th>Total</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vendas as $key => $venda): ?>
                <tr>
                    <td><?php echo htmlspecialchars($venda['cliente_id']); ?></td>
                    <td><?php echo htmlspecialchars($venda['produto_id']); ?></td>
                    <td><?php echo htmlspecialchars($venda['quantidade']); ?></td>
                    <td><?php echo htmlspecialchars($venda['total']); ?></td>
                    <td><?php echo htmlspecialchars($venda['data']); ?></td>
                    <td>
                        <a href="?delete=<?php echo $key; ?>" class="btn btn-danger">Deletar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
document.getElementById('produto_id').addEventListener('change', function() {
    var produto_id = this.value;
    var quantidade = document.getElementById('quantidade').value;
    var produtos = <?php echo json_encode($produtos); ?>;
    var produto = produtos[produto_id];
    var total = produto.preco * quantidade;
    document.getElementById('total').value = total;
});

document.getElementById('quantidade').addEventListener('input', function() {
    var produto_id = document.getElementById('produto_id').value;
    var quantidade = this.value;
    var produtos = <?php echo json_encode($produtos); ?>;
    var produto = produtos[produto_id];
    var total = produto.preco * quantidade;
    document.getElementById('total').value = total;
});
</script>

</body>
</html>
