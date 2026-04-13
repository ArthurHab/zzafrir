<?php
require_once __DIR__ . '/../includes/db.php';

// sessão já vem do public, mas garantimos segurança
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🔒 Proteção
if (!isset($_SESSION['user'])) {
    header("Location: /login");
    exit;
}

// 📌 ID do usuário logado
$usuario_id = $_SESSION['user']['id'];


// ==============================
// 📋 LISTAGEM + FILTROS
// ==============================

// busca
$busca = $_GET['search'] ?? '';

// filtro status
$filtroStatus = $_GET['status'] ?? 'todos';

// base da query
$sql = "SELECT * FROM clientes WHERE usuario_id = ?";
$params = [$usuario_id];

// busca por nome/celular
if (!empty($busca)) {
    $sql .= " AND (nome LIKE ? OR celular LIKE ?)";
    $params[] = "%$busca%";
    $params[] = "%$busca%";
}

// filtro por status
if ($filtroStatus === 'ativos') {
    $sql .= " AND ativo = 1";
} elseif ($filtroStatus === 'inativos') {
    $sql .= " AND ativo = 0";
}

// ordenação
$sql .= " ORDER BY ativo DESC, nome ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);


// ==============================
// ⚙️ AÇÕES (POST)
// ==============================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $acao = $_POST['acao'] ?? '';

    // ==========================
    // ➕ CADASTRAR
    // ==========================
    if ($acao === 'cadastrar') {
        $nome = trim($_POST['nome']);
        $celular = trim($_POST['celular']);

        if (!empty($nome)) {
            $sql = "INSERT INTO clientes (usuario_id, nome, celular) 
                    VALUES (?, ?, ?)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$usuario_id, $nome, $celular]);
        }

        header("Location: /clientes.php?sucesso=1");
        exit;
    }

    // ==========================
    // ✏️ EDITAR
    // ==========================
    if ($acao === 'editar') {
        $id = $_POST['id'];
        $nome = trim($_POST['nome']);
        $celular = trim($_POST['celular']);

        if (!empty($id) && !empty($nome)) {
            $sql = "UPDATE clientes 
                    SET nome = ?, celular = ? 
                    WHERE id = ? AND usuario_id = ?";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $celular, $id, $usuario_id]);
        }

        header("Location: /clientes.php?editado=1");
        exit;
    }

    // ==========================
    // 🔄 ATIVAR / INATIVAR
    // ==========================
    if ($acao === 'toggle_status') {
        $id = $_POST['id'];
        $status = $_POST['status']; // 1 ou 0

        if (!empty($id)) {
            $sql = "UPDATE clientes 
                    SET ativo = ? 
                    WHERE id = ? AND usuario_id = ?";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$status, $id, $usuario_id]);
        }

        header("Location: /clientes.php");
        exit;
    }
}