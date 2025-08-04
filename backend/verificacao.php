<?php

session_start();

    if ($_SESSION['id'] == null) {
    header('Location: frontend/login.php');
}