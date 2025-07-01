<?php
include '../backend/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['formulario']) && $_POST['formulario'] === 'cadastro') {

        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $confirmar = $_POST['confirmar_senha'] ?? '';

        if ($senha !== $confirmar) {    
            die("❌ As senhas não coincidem.");
        }

        if (strlen($senha) < 6 || !preg_match('/[A-Za-z]/', $senha) || !preg_match('/[0-9]/', $senha)) {
            die("❌ A senha deve ter pelo menos 6 caracteres, incluindo letras e números.");
        }

        try {
            // Verifica se o e-mail já está cadastrado
            $verifica = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
            $verifica->bindParam(':email', $email);
            $verifica->execute();

            if ($verifica->rowCount() > 0) {
                die("❌ Este e-mail já está cadastrado.");
            }

            // Inserir no banco
            $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha);

            if ($stmt->execute()) {

                $PegarUsuarioCadastrado = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
                $PegarUsuarioCadastrado->bindParam(':email', $email);
                $PegarUsuarioCadastrado->execute();

                $resultado = $PegarUsuarioCadastrado->fetch(PDO::FETCH_ASSOC);
                session_start(); // Inicia sessão se ainda não estiver iniciada
                $_SESSION = $resultado;


                header('Location: capa_do_site.php'); // Redireciona para a página desejada
                exit(); // Finaliza o script após o redirecionamento
            } else {
                echo "❌ Erro ao cadastrar.";
            }
        } catch (PDOException $e) {
            echo "❌ Erro no banco de dados: " . $e->getMessage();
        }
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

<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo $front ?>/capa_do_site.php">Menu</a>
                <div class="container mt-4" style="display: flex; align-content: center; flex-wrap: wrap; align-items: center; justify-content: flex-end; ">
        <a class="btn btn-primary me-2" style="border: 1px solid white;" href="<?php echo $front ?>/login.php">Login</a>
        <a class="btn btn-success"  style="border: 1px solid white;"  href="<?php echo $front ?>/cadastro.php">Cadastro</a>
        </div>
        </div>
    </nav>
</header>

    <!-- Formulário de Cadastro -->
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
        <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="container">
            <div class="row justify-content-center">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>