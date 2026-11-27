<?php
require_once __DIR__ . '/../includes/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ==============================
// PROTEÇÃO
// ==============================

if (!isset($_SESSION['user'])) {
    header("Location: /login");
    exit;
}

$usuario_id = $_SESSION['user']['id'];

// ==============================
// AÇÕES (POST)
// ==============================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $acao = $_POST['acao'] ?? '';

    // ==========================
    // CADASTRAR SERVIÇO
    // ==========================

    if ($acao === 'cadastrar') {

        $nome = trim($_POST['nome'] ?? '');
        $preco = str_replace(',', '.', trim($_POST['preco'] ?? ''));
        $duracao = filter_var(
            $_POST['duracao_minutos'] ?? null,
            FILTER_VALIDATE_INT
        );

        if (
            $nome !== '' &&
            mb_strlen($nome) <= 100 &&
            is_numeric($preco) &&
            (float)$preco >= 0 &&
            (float)$preco <= 99999999.99 &&
            $duracao !== false &&
            $duracao !== null &&
            $duracao > 0
        ) {

            $sql = "INSERT INTO servicos
                    (usuario_id, nome, preco, duracao_minutos)
                    VALUES (?, ?, ?, ?)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $usuario_id,
                $nome,
                $preco,
                $duracao
            ]);

            header("Location: /servicos.php?sucesso=1");
            exit;
        }

        header("Location: /servicos.php?erro=dados_invalidos");
        exit;
    }

    // ==========================
    // EDITAR SERVIÇO
    // ==========================

    if ($acao === 'editar') {

        $id = filter_var(
            $_POST['id'] ?? null,
            FILTER_VALIDATE_INT
        );

        $nome = trim($_POST['nome'] ?? '');
        $preco = str_replace(',', '.', trim($_POST['preco'] ?? ''));
        $duracao = filter_var(
            $_POST['duracao_minutos'] ?? null,
            FILTER_VALIDATE_INT
        );

        if (
            $id !== false &&
            $id !== null &&
            $id > 0 &&
            $nome !== '' &&
            mb_strlen($nome) <= 100 &&
            is_numeric($preco) &&
            (float)$preco >= 0 &&
            (float)$preco <= 99999999.99 &&
            $duracao !== false &&
            $duracao !== null &&
            $duracao > 0
        ) {

            $sql = "UPDATE servicos
                    SET nome = ?,
                        preco = ?,
                        duracao_minutos = ?
                    WHERE id = ?
                    AND usuario_id = ?";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                $nome,
                $preco,
                $duracao,
                $id,
                $usuario_id
            ]);

            header("Location: /servicos.php?editado=1");
            exit;
        }

        header("Location: /servicos.php?erro=dados_invalidos");
        exit;
    }

    // ==========================
    // ATIVAR / INATIVAR
    // ==========================

    if ($acao === 'toggle_status') {

        $id = filter_var(
            $_POST['id'] ?? null,
            FILTER_VALIDATE_INT
        );

        $status = $_POST['status'] ?? '';

        if (
            $id !== false &&
            $id !== null &&
            $id > 0 &&
            in_array($status, ['0', '1'], true)
        ) {

            $sql = "UPDATE servicos
                    SET ativo = ?
                    WHERE id = ?
                    AND usuario_id = ?";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                (int)$status,
                $id,
                $usuario_id
            ]);
        }

        header("Location: /servicos.php");
        exit;
    }

    // Ação desconhecida
    header("Location: /servicos.php");
    exit;
}

// ==============================
// LISTAGEM + FILTROS
// ==============================

$busca = trim($_GET['search'] ?? '');
$filtroStatus = $_GET['status'] ?? 'todos';

if (!in_array($filtroStatus, ['todos', 'ativos', 'inativos'], true)) {
    $filtroStatus = 'todos';
}

$sql = "SELECT *
        FROM servicos
        WHERE usuario_id = ?";

$params = [$usuario_id];

// Busca por nome
if ($busca !== '') {

    $sql .= " AND nome LIKE ?";

    $params[] = "%{$busca}%";
}

// Filtro de status
if ($filtroStatus === 'ativos') {

    $sql .= " AND ativo = 1";

} elseif ($filtroStatus === 'inativos') {

    $sql .= " AND ativo = 0";
}

// Ordenação
$sql .= " ORDER BY ativo DESC, nome ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$servicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
