<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: /login");
    exit;
}

require_once '../src/controllers/servicos_controller.php';
$page = 'servicos';

function h($valor) {
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Serviços - Zzafrir Sistema</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-100 flex h-screen overflow-hidden">

    <?php include '../src/includes/layout/sidebar.php'; ?>

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden"
         x-data="{
            modalNovo: false,
            editando: false,
            servicoId: '',
            servicoNome: '',
            servicoPreco: '',
            servicoDuracao: '',

            novoServico() {
                this.editando = false;
                this.servicoId = '';
                this.servicoNome = '';
                this.servicoPreco = '';
                this.servicoDuracao = '';
                this.modalNovo = true;
            },

            editarServico(servico) {
                this.editando = true;
                this.servicoId = servico.id;
                this.servicoNome = servico.nome;
                this.servicoPreco = servico.preco;
                this.servicoDuracao = servico.duracao_minutos;
                this.modalNovo = true;
            }
         }">

        <?php include '../src/includes/layout/navbar.php'; ?>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4 lg:p-8">

            <!-- CABEÇALHO -->

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">

                <div>
                    <h1 class="text-2xl font-bold text-gray-800">
                        Gestão de Serviços
                    </h1>

                    <p class="text-sm text-gray-500">
                        Cadastre e gerencie seus serviços
                    </p>
                </div>

                <button
                    @click="novoServico()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold shadow-md flex items-center gap-2">

                    + Novo Serviço

                </button>

            </div>

            <!-- MENSAGENS -->

            <?php if (isset($_GET['sucesso'])): ?>
                <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
                    Serviço cadastrado com sucesso!
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['editado'])): ?>
                <div class="bg-blue-100 text-blue-700 p-3 rounded-lg mb-4">
                    Serviço atualizado com sucesso!
                </div>
            <?php endif; ?>

            <?php if (($_GET['erro'] ?? '') === 'dados_invalidos'): ?>
                <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
                    Verifique os dados informados. Nome, preço e duração são obrigatórios.
                </div>
            <?php endif; ?>

            <!-- BUSCA E FILTROS -->

            <div class="bg-white p-4 rounded-xl shadow-sm mb-6">

                <form method="GET" class="flex flex-col md:flex-row gap-4">

                    <input
                        type="text"
                        name="search"
                        value="<?= h($busca) ?>"
                        placeholder="Buscar serviço..."
                        class="flex-1 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">

                    <select
                        name="status"
                        onchange="this.form.submit()"
                        class="border rounded-lg px-4 py-2">

                        <option value="todos" <?= $filtroStatus === 'todos' ? 'selected' : '' ?>>
                            Todos
                        </option>

                        <option value="ativos" <?= $filtroStatus === 'ativos' ? 'selected' : '' ?>>
                            Ativos
                        </option>

                        <option value="inativos" <?= $filtroStatus === 'inativos' ? 'selected' : '' ?>>
                            Inativos
                        </option>

                    </select>

                    <button
                        type="submit"
                        class="bg-gray-800 hover:bg-gray-900 text-white px-5 py-2 rounded-lg">

                        Buscar

                    </button>

                </form>

            </div>

            <!-- TABELA -->

            <div class="bg-white rounded-xl shadow-sm overflow-x-auto border">

                <table class="w-full text-left">

                    <thead class="bg-gray-50 text-gray-600 text-xs uppercase">

                        <tr>
                            <th class="px-6 py-4">Serviço</th>
                            <th class="px-6 py-4">Preço</th>
                            <th class="px-6 py-4">Duração</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Ações</th>
                        </tr>

                    </thead>

                    <tbody class="divide-y text-gray-700">

                        <?php if (empty($servicos)): ?>

                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                    Nenhum serviço encontrado.
                                </td>
                            </tr>

                        <?php endif; ?>

                        <?php foreach ($servicos as $servico): ?>

                            <tr class="<?= !$servico['ativo'] ? 'bg-gray-50 opacity-60' : 'hover:bg-gray-50' ?>">

                                <!-- NOME -->

                                <td class="px-6 py-4 font-medium">
                                    <?= h($servico['nome']) ?>
                                </td>

                                <!-- PREÇO -->

                                <td class="px-6 py-4 text-sm font-semibold text-gray-700">
                                    R$ <?= number_format((float)$servico['preco'], 2, ',', '.') ?>
                                </td>

                                <!-- DURAÇÃO -->

                                <td class="px-6 py-4 text-sm text-gray-500">

                                    <?php
                                    $minutos = (int)$servico['duracao_minutos'];
                                    $horas = intdiv($minutos, 60);
                                    $resto = $minutos % 60;

                                    if ($horas > 0 && $resto > 0) {
                                        echo $horas . 'h ' . $resto . 'min';
                                    } elseif ($horas > 0) {
                                        echo $horas . 'h';
                                    } else {
                                        echo $resto . ' min';
                                    }
                                    ?>

                                </td>

                                <!-- STATUS -->

                                <td class="px-6 py-4">

                                    <?php if ($servico['ativo']): ?>

                                        <span class="text-green-600 font-semibold">
                                            Ativo
                                        </span>

                                    <?php else: ?>

                                        <span class="text-red-500 font-semibold">
                                            Inativo
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <!-- AÇÕES -->

                                <td class="px-6 py-4 text-center whitespace-nowrap">

                                    <button
                                        type="button"
                                        @click='editarServico(<?= h(json_encode([
                                            'id' => $servico['id'],
                                            'nome' => $servico['nome'],
                                            'preco' => $servico['preco'],
                                            'duracao_minutos' => $servico['duracao_minutos']
                                        ], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP)) ?>)'
                                        class="text-blue-600 hover:text-blue-800 mr-3 font-semibold text-sm">

                                        Editar

                                    </button>

                                    <form method="POST" class="inline">

                                        <input type="hidden" name="acao" value="toggle_status">

                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?= (int)$servico['id'] ?>">

                                        <input
                                            type="hidden"
                                            name="status"
                                            value="<?= $servico['ativo'] ? 0 : 1 ?>">

                                        <button
                                            type="submit"
                                            class="<?= $servico['ativo'] ? 'text-red-500 hover:text-red-700' : 'text-green-600 hover:text-green-800' ?> font-semibold text-sm">

                                            <?= $servico['ativo'] ? 'Inativar' : 'Ativar' ?>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <!-- MODAL NOVO / EDITAR -->

            <div
                x-show="modalNovo"
                x-cloak
                x-transition.opacity
                @keydown.escape.window="modalNovo = false"
                @click.self="modalNovo = false"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">

                <div class="bg-white rounded-xl p-6 w-full max-w-lg shadow-2xl">

                    <h3
                        class="text-lg font-bold mb-5 text-gray-800"
                        x-text="editando ? 'Editar Serviço' : 'Novo Serviço'">
                    </h3>

                    <form method="POST">

                        <input
                            type="hidden"
                            name="acao"
                            :value="editando ? 'editar' : 'cadastrar'">

                        <input
                            type="hidden"
                            name="id"
                            :value="servicoId">

                        <!-- NOME -->

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nome do serviço
                        </label>

                        <input
                            type="text"
                            name="nome"
                            x-model="servicoNome"
                            maxlength="100"
                            placeholder="Ex: Corte de cabelo"
                            class="w-full border rounded-lg px-3 py-2 mb-4 focus:ring-2 focus:ring-blue-500 outline-none"
                            required>

                        <!-- PREÇO -->

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Preço (R$)
                        </label>

                        <input
                            type="number"
                            name="preco"
                            x-model="servicoPreco"
                            min="0"
                            max="99999999.99"
                            step="0.01"
                            placeholder="Ex: 50.00"
                            class="w-full border rounded-lg px-3 py-2 mb-4 focus:ring-2 focus:ring-blue-500 outline-none"
                            required>

                        <!-- DURAÇÃO -->

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Duração (minutos)
                        </label>

                        <input
                            type="number"
                            name="duracao_minutos"
                            x-model="servicoDuracao"
                            min="1"
                            step="1"
                            placeholder="Ex: 60"
                            class="w-full border rounded-lg px-3 py-2 mb-5 focus:ring-2 focus:ring-blue-500 outline-none"
                            required>

                        <!-- BOTÕES -->

                        <div class="flex justify-end gap-3">

                            <button
                                type="button"
                                @click="modalNovo = false"
                                class="px-4 py-2 text-gray-600 hover:text-gray-900">

                                Cancelar

                            </button>

                            <button
                                type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold">

                                Salvar

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </main>

    </div>

    <script src="assets/js/sidebar.js"></script>

</body>
</html>
