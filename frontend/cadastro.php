<?php
session_start();
include '../backend/config.php';

$erro = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['formulario'] ?? '') === 'cadastro') {

    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmar = $_POST['confirmar_senha'] ?? '';

    if (empty($nome) || empty($email) || empty($senha) || empty($confirmar)) {
        $erro = "Preencha todos os campos.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "E-mail inválido.";
    } elseif ($senha !== $confirmar) {
        $erro = "As senhas não coincidem.";
    } elseif (strlen($senha) < 6 || !preg_match('/[A-Za-z]/', $senha) || !preg_match('/[0-9]/', $senha)) {
        $erro = "A senha deve ter pelo menos 6 caracteres, incluindo letras e números.";
    } else {
        try {
            $verifica = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
            $verifica->bindParam(':email', $email);
            $verifica->execute();

            if ($verifica->rowCount() > 0) {
                $erro = "Este e-mail já está cadastrado.";
            } else {

                $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':senha', $senha);

                if ($stmt->execute()) {
                    $PegarUsuario = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
                    $PegarUsuario->bindParam(':email', $email);
                    $PegarUsuario->execute();
                    $_SESSION = $PegarUsuario->fetch(PDO::FETCH_ASSOC);

                    header('Location: pagina_inicial.php');
                    exit();
                } else {
                    $erro = "Erro ao cadastrar usuário.";
                }
            }
        } catch (PDOException $e) {
            $erro = "Erro de banco de dados. Tente novamente.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<?php if (!empty($erro)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?= $front ?>/pagina_inicial.php">Menu</a>

                <!-- Botão para toggle do menu mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Alternar navegação">
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
                            <a class="btn btn-primary" style="border: 1px solid white;"
                                href="<?= $front ?>/login.php">Login</a>
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
    </header>

    <!--<div class="d-flex justify-content-center align-items-center vh-100"> -->
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="container">
            <div class="row justify-content-center ">
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
                            <input type="email" name="email" class="form-control" id="email"
                                placeholder="Digite seu e-mail">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="senha">Senha:</label>
                            <input type="password" name="senha" class="form-control" id="senha"
                                placeholder="Digite sua senha">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="confirmar_senha">Confirme a Senha:</label>
                            <input type="password" name="confirmar_senha" class="form-control" id="confirmar_senha"
                                placeholder="Confirme sua senha">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Cadastrar</button>
                        </div>

                        <div class="mt-3 text-center">
                            <a href="<?php echo $front ?>/login.php">Já tem uma conta?
                                Faça login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>