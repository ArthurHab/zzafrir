<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: /login");
    exit;
}

require_once '../src/controllers/cliente_controller.php';
$page = 'clientes';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Zzafrir Sistema</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-gray-100 flex h-screen overflow-hidden">

    <?php include '../src/includes/layout/sidebar.php'; ?>

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden" 
         x-data="{ 
            modalNovo: false, 
            modalDelete: false, 
            editando: false,
            clienteId: '',
            clienteNome: '',
            clienteCelular: '',
            clienteStatus: '1'
         }">
        
        <?php include '../src/includes/layout/navbar.php'; ?>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4 lg:p-8">

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Gestão de Clientes</h1>
                    <p class="text-sm text-gray-500">Visualize e gerencie os clientes</p>
                </div>

                <button @click="editando = false; modalNovo = true; clienteNome=''; clienteCelular=''; clienteId=''" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold shadow-md flex items-center gap-2">
                    + Novo Cliente
                </button>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm mb-6 flex gap-4">
                <form method="GET" class="flex-1">
                    <input type="text" name="search"
                        value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                        placeholder="Buscar cliente..."
                        class="w-full border rounded-lg px-4 py-2">
                </form>

                <form method="GET">
                    <select name="status" onchange="this.form.submit()"
                        class="border rounded-lg px-4 py-2">
                        <option value="todos">Todos</option>
                        <option value="ativos" <?= ($_GET['status'] ?? '') === 'ativos' ? 'selected' : '' ?>>Ativos</option>
                        <option value="inativos" <?= ($_GET['status'] ?? '') === 'inativos' ? 'selected' : '' ?>>Inativos</option>
                    </select>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-sm overflow-hidden border">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
                        <tr>
                            <th class="px-6 py-4">Cliente</th>
                            <th class="px-6 py-4">Contato</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y text-gray-700">
                        <?php if (empty($clientes)): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-400">Nenhum cliente encontrado.</td>
                        </tr>
                        <?php endif; ?>

                        <?php foreach ($clientes as $cliente): ?>
                        <tr class="<?= !$cliente['ativo'] ? 'bg-gray-50 opacity-60' : 'hover:bg-gray-50' ?>">
                            <td class="px-6 py-4 font-medium"><?= htmlspecialchars($cliente['nome']) ?></td>
                            <td class="px-6 py-4 text-sm text-gray-500"><?= htmlspecialchars($cliente['celular']) ?></td>
                            <td class="px-6 py-4">
                                <?php if ($cliente['ativo']): ?>
                                    <span class="text-green-600 font-semibold">Ativo</span>
                                <?php else: ?>
                                    <span class="text-red-500 font-semibold">Inativo</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button @click="editando = true; clienteId = '<?= $cliente['id'] ?>'; clienteNome = '<?= addslashes(htmlspecialchars($cliente['nome'])) ?>'; clienteCelular = '<?= htmlspecialchars($cliente['celular']) ?>'; modalNovo = true;" 
                                        class="text-blue-600 hover:text-blue-800 mr-3 font-semibold text-sm">Editar</button>

                                <form method="POST" class="inline">
                                    <input type="hidden" name="acao" value="toggle_status">
                                    <input type="hidden" name="id" value="<?= $cliente['id'] ?>">
                                    <input type="hidden" name="status" value="<?= $cliente['ativo'] ? 0 : 1 ?>">
                                    <button type="submit" class="<?= $cliente['ativo'] ? 'text-red-500 hover:text-red-700' : 'text-green-600 hover:text-green-800' ?> font-semibold text-sm">
                                        <?= $cliente['ativo'] ? 'Inativar' : 'Ativar' ?>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div x-show="modalNovo" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                <div class="bg-white rounded-xl p-6 w-full max-w-lg shadow-2xl">
                    <h3 class="text-lg font-bold mb-4" x-text="editando ? 'Editar Cliente' : 'Novo Cliente'"></h3>
                    <form method="POST">
                        <input type="hidden" name="acao" :value="editando ? 'editar' : 'cadastrar'">
                        <input type="hidden" name="id" :value="clienteId">
                        <input type="text" name="nome" x-model="clienteNome" placeholder="Nome" class="w-full border rounded-lg px-3 py-2 mb-3" required>
                        <input type="text" name="celular" x-model="clienteCelular" placeholder="Celular" class="w-full border rounded-lg px-3 py-2 mb-3">
                        <div class="flex justify-end gap-3">
                            <button type="button" @click="modalNovo=false" class="px-4 py-2 text-gray-600">Cancelar</button>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
    </div>

    <script src="assets/js/sidebar.js"></script>
</body>
</html>