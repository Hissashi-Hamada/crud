<?php

    $hostname = "localhost";
    $bancodedados = "crud";
    $usuario = "root";
    $senha = "";

    $mysqli = new mysqli($hostname, $usuario, $senha, $bancodedados);
    if($mysqli->connect_errno) {
        echo "Falha ao conectar: (" . $mysqli->connect_errno .") " . $mysqli->connect_errno;
}

    try {
    $pdo = new PDO("mysql:host=localhost;crud=$crud", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $erro) {
    die("Erro na conexão: " . $erro->getMessage());
}

    $front = '../../crud/frontend';
    $back = '../../crud/backend';
?>