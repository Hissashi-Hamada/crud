<?php

include './config.php'; // deve conter session_start()

// Limpa a variável $_SESSION
$_SESSION = [];

// Se quiser, remove o cookie de sessão (muito recomendado)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destroi a sessão
session_destroy();

// Redireciona
header("Location: $front/login.php");
exit; // importante para garantir que o script pare aqui
