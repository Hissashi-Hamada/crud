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
                $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

                $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':senha', $senhaHash);

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
            // error_log($e->getMessage());
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                <a class="navbar-brand text-white" href="<?php echo $front ?>/pagina_inicial.php">Menu</a>
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