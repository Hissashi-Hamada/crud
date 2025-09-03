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
            if ($senha == $resultado['senha']) {
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= $front ?>/pagina_inicial.php">Menu</a>

            <!-- Botão para toggle do menu mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Alternar navegação">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- <li class="nav-item"><a class="nav-link active text-white" aria-current="page" href="#">Menu</a>
                    </li>
                    <li class="nav-item"><a class="nav-link text-white" href="#">Link</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">Mostrar mais</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Ação</a></li>
                            <li><a class="dropdown-item" href="#">Outra Ação</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Algo a Mais</a></li>
                        </ul>
                    </li> -->
                </ul>
                <?php if (($_SESSION['id'] == null)) { ?>
                    <div class="d-flex gap-2">
                        <a class="btn btn-primary" style="border: 1px solid white;" href="<?= $front ?>/login.php">Login</a>
                        <a class="btn btn-success" style="border: 1px solid white;"
                            href="<?= $front ?>/cadastro.php">Cadastro</a>
                    </div>
                <?php } else { ?>
                    <div class="d-flex gap-2">
                        <h4 class="text-white"><?php echo $_SESSION['nome'] ?></h4>
                        <a class="btn btn-primary" style="border: 1px solid white;"
                            href="<?= $back ?>/deslogar.php">Sair</a>
                    </div>
                <?php } ?>
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

                <div class="mt-3 text-center">,
                    <a href="<?php echo $front ?>/cadastro.php">Não tem conta? Cadastre-se</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>