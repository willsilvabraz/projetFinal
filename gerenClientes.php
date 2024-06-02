<?php
require_once 'sessao.php';
require_once 'Firebase.php';
require_once 'CadastroFactory.php';

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
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .compact-table {
        max-height: 300px;
        overflow-y: auto;
    }
    .compact-table th, .compact-table td {
        padding: 5px;
    }
    .form-section {
        margin-bottom: 20px;
    }
    </style>
</head>
<body>

<div class="container">
    <div class="col-12 form-section">
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h1 class="mb-4">Cadastro de Clientes</h1>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome" required placeholder="Digite seu Nome">
                </div>
                <div class="form-group col-md-6">
                    <label for="sobrenome">Sobrenome:</label>
                    <input type="text" class="form-control" id="sobrenome" name="sobrenome" required placeholder="Digite seu Sobrenome">
                </div>
            </div>
            <div class="form-group">
                <label for="endereco">Endereço:</label>
                <input type="text" class="form-control" id="endereco" name="endereco" required placeholder="Digite seu Endereço">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="Digite seu Email">
                </div>
                <div class="form-group col-md-6">
                    <label for="telefone">Telefone:</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" required placeholder="Digite seu Telefone">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="cpf">CPF:</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Digite seu CPF">
                </div>
                <div class="form-group col-md-6">
                    <label for="cnpj">CNPJ:</label>
                    <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="Digite seu CNPJ">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar Cliente</button>
        </form>
    </div>

    <div class="col-12">
        <h2>Lista de Clientes</h2>
        <table class="table table-striped compact-table" id="listacli">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Sobrenome</th>
                    <th>Endereço</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>CPF</th>
                    <th>CNPJ</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($clientes): ?>
                    <?php foreach ($clientes as $key => $cliente): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cliente['nome']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['sobrenome']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['endereco']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['email']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['telefone']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['cpf']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['cnpj']); ?></td>
                            <td>
                                <a href="?delete=<?php echo $key; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja deletar este cliente?')">Deletar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">Nenhum cliente encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="./scripts/gerenClientes.js"></script>

</body>
</html>
