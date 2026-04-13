<?php

session_start();
require_once __DIR__ . '/../includes/db.php';

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->execute([$email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($senha, $user['senha'])) {
    
    $_SESSION['user'] = [
        'id' => $user['id'],
        'nome' => $user['nome'],
        'email' => $user['email']
    ];

    header("Location: /dashboard");
    exit;

} else {
    header("Location: /login?error=1");
    exit;
}