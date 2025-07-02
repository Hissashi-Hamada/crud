<?php
include '../backend/config.php';
// Configurações do banco de dados (substitua com suas informações)
$servername = "localhost"; // Ou o endereço do seu servidor de banco de dados
$username = "seu_usuario"; // Seu nome de usuário do banco de dados
$password = "sua_senha"; // Sua senha do banco de dados
$dbname = "seu_banco_de_dados"; // O nome do seu banco de dados

// Cria a conexão
$pdo = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Dados a serem inseridos (substitua com os dados que você quer adicionar)
$nome = "Exemplo de Nome";
$email = "exemplo@email.com";

// Prepara e executa a declaração SQL
$sql = "INSERT INTO sua_tabela (nome, email) VALUES ('$nome', '$email')";

if ($conn->query($sql) === TRUE) {
    echo "Novo registro criado com sucesso!";
} else {
    echo "Erro: " . $sql . "<br>" . $conn->error;
}

// Fecha a conexão
$pdo->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

</body>

</html>