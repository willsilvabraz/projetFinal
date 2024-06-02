
<?php
require __DIR__.'/vendor/autoload.php';
require_once 'sessao.php';
require_once 'Firebase.php';
require_once 'CadastroFactory.php';

$sessao = Sessao::getInstancia();
$sessao->requerLogin();

$firebase = Firebase::getInstance();
$database = $firebase->getDatabase();

$cadastroUsuarios = CadastroFactory::criarCadastro('usuarios', $database);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    cadastrarUsuario($cadastroUsuarios);
}

function cadastrarUsuario($cadastroUsuarios) {
    $dadosUsuario = [
        'nome' => $_POST['nome'],
        'email' => $_POST['email'],
        'senha' => $_POST['senha'],
        'cargo' => $_POST['cargo']
    ];
    
    $cadastroUsuarios->cadastrar($dadosUsuario);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <div class="col-12">
        <h1>Cadastro de Usuário</h1>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <div class="form-group">
                <label for="cargo">Cargo:</label>
                <input type="text" class="form-control" id="cargo" name="cargo" required>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar Usuário</button>
        </form>
    </div>
</div>

</body>
</html>
