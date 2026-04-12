<?php

session_start();

if (isset($_SESSION['user'])) {
    header("Location: /dashboard");
    exit;
}

?>

<form method="POST" action="/login_action">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Senha" required>
    <button type="submit">Entrar</button>
</form>

<?php if(isset($_GET['error'])): ?>
    <p>Email ou senha inválidos</p>
<?php endif; ?>