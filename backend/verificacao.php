<?php

session_start();

    if ($_SESSION['id'] == null) {
    header('Location: login.php');
}