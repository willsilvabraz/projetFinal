<?php
require_once 'sessao.php';
require_once 'Firebase.php';

$sessao = Sessao::getInstancia();
$sessao->requerLogin();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require __DIR__.'/vendor/autoload.php';

$firebaseConnection = Firebase::getInstance();
$database = $firebaseConnection->getDatabase();

$vendas = $database->getReference('vendas')->getValue();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Vendas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <div class="col-lg-12">
        <h1>Listar Vendas</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID da Venda</th>
                    <th>ID do Cliente</th>
                    <th>ID do Produto</th>
                    <th>Quantidade</th>
                    <th>Total</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vendas as $key => $venda): ?>
                <tr>
                    <td><?php echo $key; ?></td>
                    <td><?php echo $venda['cliente_id']; ?></td>
                    <td><?php echo $venda['produto_id']; ?></td>
                    <td><?php echo $venda['quantidade']; ?></td>
                    <td><?php echo $venda['total']; ?></td>
                    <td><?php echo $venda['data']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
