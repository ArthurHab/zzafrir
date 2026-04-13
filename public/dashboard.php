<?php

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: /login");
    exit;
}

$page = 'dashboard';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zzafrir Sistema - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Inter', sans-serif; }
        body { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
    </style>
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden">

    <?php include '../src/includes/layout/sidebar.php'; ?>

    <div class="flex-1 flex flex-col overflow-hidden">
        
        <?php include '../src/includes/layout/navbar.php'; ?>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4 lg:p-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <?php
                $metrics = [
                    ['label' => 'Clientes Totais', 'value' => '128', 'color' => 'blue'],
                    ['label' => 'Agendamentos Hoje', 'value' => '12', 'color' => 'indigo'],
                    ['label' => 'Faturamento (Mês)', 'value' => 'R$ 4.250', 'color' => 'emerald'],
                    ['label' => 'Serviços Ativos', 'value' => '8', 'color' => 'sky'],
                ];

                foreach ($metrics as $m): ?>
                    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-600 hover:shadow-md transition-shadow">
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider"><?= $m['label'] ?></p>
                        <p class="text-2xl font-bold text-gray-800 mt-1"><?= $m['value'] ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-gray-800">Últimos Agendamentos</h2>
                    <button class="text-blue-600 hover:text-blue-800 text-sm font-semibold">Ver todos</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-semibold">
                            <tr>
                                <th class="px-6 py-4">Cliente</th>
                                <th class="px-6 py-4">Serviço</th>
                                <th class="px-6 py-4">Horário</th>
                                <th class="px-6 py-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            <?php 
                            $agendamentos = [
                                ['nome' => 'Marcos Silva', 'servico' => 'Corte Social', 'hora' => '14:30', 'status' => 'Confirmado'],
                                ['nome' => 'João Pereira', 'servico' => 'Barba Premium', 'hora' => '15:15', 'status' => 'Pendente'],
                                ['nome' => 'Ricardo Alves', 'servico' => 'Corte + Barba', 'hora' => '16:00', 'status' => 'Concluído'],
                            ];
                            foreach ($agendamentos as $ag): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium"><?= $ag['nome'] ?></td>
                                <td class="px-6 py-4"><?= $ag['servico'] ?></td>
                                <td class="px-6 py-4 font-mono"><?= $ag['hora'] ?></td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                        <?= $ag['status'] ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
<script src="assets/js/sidebar.js"></script>
</body>
</html>