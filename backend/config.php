<?php
$hostname = "localhost";
$bancodedados = "crud";
$usuario = "root";
$senha = "";

<<<<<<< HEAD
try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$bancodedados;charset=utf8", $usuario, $senha);
=======
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
>>>>>>> 33f4298045ee762402d378a01914f94853a66504
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $erro) {
    die("Erro na conexão: " . $erro->getMessage());
}

    $front = '../../crud/frontend';
    $back = '../../crud/backend';
?>