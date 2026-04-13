<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {

    case '/':
    case '/login':
        require __DIR__ . '/login.php';
        break;

    case '/dashboard':
        require __DIR__ . '/dashboard.php';
        break;

    case '/clientes':
        require __DIR__ . '/clientes.php';
        break;


    case '/register':
        require __DIR__ . '/register.php';
        break;

    case '/login_action':
        require __DIR__ . '/../src/controllers/login_action.php';
        break;

    case '/register_action':
        require __DIR__ . '/../src/controllers/register_action.php';
        break;

    case '/logout':
        require __DIR__ . '/logout.php';
        break;

    default:
        http_response_code(404);
        echo "Página não encontrada";
}