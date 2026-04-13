<?php

session_start();
require_once __DIR__ . '/../includes/db.php';

// pega dados do form
$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

// validação básica
if (!$nome || !$email || !$senha) {
    header("Location: /register?error=1");
    exit;
}

// verifica se email já existe
$stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->fetch()) {
    header("Location: /register?error=2");
    exit;
}

// cria senha segura
$hash = password_hash($senha, PASSWORD_DEFAULT);

// insere no banco
$stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
$stmt->execute([$nome, $email, $hash]);

// cria sessão (auto login)
$_SESSION['user'] = [
    'id' => $pdo->lastInsertId(),
    'nome' => $nome,
    'email' => $email
];

// redireciona
header("Location: /dashboard");
exit;