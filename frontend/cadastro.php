<?php
include '../backend/config.php';

// Verifica se formulário foi enviado
if ($_POST) {
    // Evita erro se o campo não existir
    $formulario = $_POST['formulario'] ?? '';

    echo '<br>';

    if ($formulario === 'cadastro') {
        echo 'Formulário de Cadastro recebido<br>';
        echo 'Nome: ' . htmlspecialchars($_POST['nome']) . '<br>';
        echo 'Email: ' . htmlspecialchars($_POST['email']) . '<br>';
        echo 'Senha: ' . htmlspecialchars($_POST['senha']) . '<br>';
        echo 'Confirmação: ' . htmlspecialchars($_POST['confirmar_senha']) . '<br>';
    } else {
        echo 'Tipo de formulário não reconhecido.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo $front ?>/capa_do_site.php">Menu</a>
        <div class="container mt-4">
            <a class="btn btn-primary me-2" style="border: 1px solid white;" href="<?php echo $front ?>/login.php">Login</a>
            <a class="btn btn-success" style="border: 1px solid white;" href="<?php echo $front ?>/cadastro.php">Cadastro</a>
        </div>
    </div>
</nav>

<!-- Formulário de Cadastro -->
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <form action="" method="POST" class="p-4 border rounded shadow bg-white">
                    <h4 class="text-center mb-4">Cadastre-se</h4>

                    <input type="hidden" name="formulario" value="cadastro">

                    <div class="mb-3">
                        <label class="form-label" for="nome">Nome:</label>
                        <input type="text" name="nome" class="form-control" id="nome" placeholder="Digite seu nome">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="email">E-mail:</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Digite seu e-mail">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="senha">Senha:</label>
                        <input type="password" name="senha" class="form-control" id="senha" placeholder="Digite sua senha">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="confirmar_senha">Confirme a Senha:</label>
                        <input type="password" name="confirmar_senha" class="form-control" id="confirmar_senha" placeholder="Confirme sua senha">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">Cadastrar</button>
                    </div>

                    <div class="mt-3 text-center">
                        <a href="<?php echo $front ?>/login.php">Já tem uma conta? Faça login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
