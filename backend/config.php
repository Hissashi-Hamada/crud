<?php
$hostname = "localhost";
$bancodedados = "crud";
$usuario = "root";
$senha = "";


try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$bancodedados;charset=utf8", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $erro) {
    die("Erro na conexão: " . $erro->getMessage());
}

    $front = '../../crud/frontend';
    $back = '../../crud/backend';

// Caminho absoluto até a pasta /crud
// $basePath = dirname(__DIR__); // Sobe um nível a partir de /backend -> chega em /crud

// $basePath = __DIR__ . '/..'; // /crud
// $baseUrl = '/crud'; // ou deixe vazio '' se estiver na raiz do servidor
// $front = $basePath . $baseUrl . '/frontend';
// $back = $basePath . '/backend';
// $public = $basePath . '/public';

// Se quiser usar URLs, você pode definir também:
?>