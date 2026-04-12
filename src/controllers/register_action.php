<?php

session_start();
require_once __DIR__ . '/../includes/db.php';

// pega dados do form
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// validação básica
if (!$name || !$email || !$password) {
    header("Location: /register?error=1");
    exit;
}

// verifica se email já existe
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->fetch()) {
    header("Location: /register?error=2");
    exit;
}

// cria senha segura
$hash = password_hash($password, PASSWORD_DEFAULT);

// insere no banco
$stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->execute([$name, $email, $hash]);

// cria sessão (auto login)
$_SESSION['user'] = [
    'id' => $pdo->lastInsertId(),
    'name' => $name,
    'email' => $email
];

// redireciona
header("Location: /dashboard");
exit;