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

?>