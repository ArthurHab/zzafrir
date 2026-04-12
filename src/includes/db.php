<?php

$host = 'mysql';
$db   = 'barbearia';
$user = 'barbearia';
$pass = 'barbearia';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro no banco: " . $e->getMessage());
}