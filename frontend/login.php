<?php
session_start();
include '../backend/config.php';

$mensagemErro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['formulario'] ?? '') === 'login') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        $mensagemErro = 'Preencha todos os campos.';
    } else {
        $verifica = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $verifica->bindParam(':email', $email);
        $verifica->execute();
        $resultado = $verifica->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            if (password_verify($senha, $resultado['senha'])) {
                $_SESSION = $resultado;
                header('Location: pagina_inicial.php');
                exit();
            } else {
                $mensagemErro = 'Senha incorreta.';
            }
        } else {
            $mensagemErro = 'Usuário não encontrado.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/crud/capa_do_site.php">Menu</a>
            <div class="d-flex">
                <a class="btn btn-light me-2" href="/crud/login.php">Login</a>
                <a class="btn btn-success" href="/crud/cadastro.php">Cadastro</a>
            </div>
        </div>
    </nav>

    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-4">
            <form action="" method="POST" class="p-4 border rounded shadow bg-white">
                <h4 class="text-center mb-4">Login</h4>

                <?php if (!empty($mensagemErro)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($mensagemErro) ?></div>
                <?php endif; ?>

                <input type="hidden" name="formulario" value="login">

                <div class="mb-3">
                    <label for="email_login" class="form-label">Email:</label>
                    <input type="email" name="email" class="form-control" id="email_login" required>
                </div>

                <div class="mb-3">
                    <label for="senha_login" class="form-label">Senha:</label>
                    <input type="password" name="senha" class="form-control" id="senha_login" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </div>

                <div class="mt-3 text-center">
                    <a href="/crud/cadastro.php">Não tem conta? Cadastre-se</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>