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

// Caminho absoluto da raiz do CRUD
$basePath = realpath(__DIR__ . '/../../crud');

$front = $basePath . '/frontend';
$back = $basePath . '/backend';
$public = $basePath . '/public';
?>