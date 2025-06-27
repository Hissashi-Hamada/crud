<?php
include '../backend/config.php';

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

// Verifica se a senha é a mesma (com o mesmo numero de caracteres, número, letra)
if (strlen($senha) > 8 || !preg_match('/[A-Za-z]/', $senha) || !preg_match('/[0-9]/', $senha)) {
    die("A senha não e a mesma snha de.");
}

// Inserir no banco
$sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nome, $email, $senha);

if ($stmt->execute()) {
    
} else {
    echo "Erro ao cadastrar: " . $stmt->error;

if (isset($_POST['botao_enviar'])) {
    // Aqui pode ter uma verificação ou ação qualquer
    if (/* condição para redirecionar */ true) {
        header("Location: outra_pagina.php");
        exit(); // Importante para parar o script após o redirecionamento
    }
}
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login e Cadastro</title>
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

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-center">

            <!-- Formulário de Login -->
            <div class="col-md-4 mb-4">
                <form action="" method="POST" class="p-4 border rounded shadow bg-white">
                    <h4 class="text-center mb-4">Login</h4>
                    <input type="hidden" name="formulario" value="login">

                    <div class="mb-3">
                        <label class="form-label" for="nome_login">Nome:</label>
                        <input type="text" name="nome" class="form-control" id="nome_login" placeholder="Digite seu nome">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label" for="senha_login">Senha:</label>
                        <input type="password" name="senha" class="form-control" id="senha_login" placeholder="Digite sua senha">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary"  >Entrar</button>

                    </div>

                    <div class="mt-3 text-center">
                        <a href="<?php echo $front ?>/cadastro.php">Não tem conta? Cadastre-se</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
