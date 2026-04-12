<?php

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: /login");
    exit;
}

?>

<h1>Bem-vindo, <?= $_SESSION['user']['name'] ?></h1>

<a href="/logout">Sair</a>