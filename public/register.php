<?php
session_start();

// se já estiver logado, manda pro dashboard
if (isset($_SESSION['user'])) {
    header("Location: /dashboard");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
</head>
<body>

<h2>Criar conta</h2>

<form method="POST" action="/register_action">
    
    <input type="text" name="name" placeholder="Nome" required>
    <br><br>

    <input type="email" name="email" placeholder="Email" required>
    <br><br>

    <input type="password" name="password" placeholder="Senha" required>
    <br><br>

    <button type="submit">Cadastrar</button>

</form>

<br>

<a href="/login">Já tenho conta</a>

<?php if(isset($_GET['error'])): ?>

    <?php if($_GET['error'] == 1): ?>
        <p style="color:red;">Preencha todos os campos</p>
    <?php elseif($_GET['error'] == 2): ?>
        <p style="color:red;">Email já cadastrado</p>
    <?php endif; ?>

<?php endif; ?>

</body>
</html>