<?php
include '../backend/config.php';



// Recebe o valor do campo 'formulario' do POST
$login = $_POST['formulario'] ?? null;
print_r($login);

if ($login === "login") {
    // Recebe email e senha do formulário
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    print_r($email);
    print_r($senha);

    // Prepara e executa a consulta para buscar usuário pelo email
    $verifica = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
    $verifica->bindParam(':email', $email);
    $verifica->execute();

    $resultado = $verifica->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        // Usuário encontrado
        print_r($resultado);

        // Verifica se a senha corresponde (atenção: comparar senhas em texto plano não é seguro)
        if ($resultado['senha'] === $senha) {
            session_start(); // Inicia sessão se ainda não estiver iniciada
            $_SESSION = $resultado;
            header('Location: capa_do_site.php'); // Redireciona para a página desejada
            exit(); // Finaliza o script após o redirecionamento
        } else {
            echo "<script>alert('Senha incoreta');</script>";
        }
    } else {
        echo "<script>alert('Usúario não encontrado');</script>";
    }
} else {
    // echo "Formulário não encontrado";
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
                            <label class="form-label" for="email_login">email:</label>
                            <input type="text" name="email" class="form-control" id="email_login" placeholder="Digite seu email">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="senha_login">Senha:</label>
                            <input type="password" name="senha" class="form-control" id="senha_login" placeholder="Digite sua senha">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Entrar</button>
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