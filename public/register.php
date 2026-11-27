<?php
session_start();

// se já estiver logado, manda pro dashboard
if (isset($_SESSION['user'])) {
    header("Location: /dashboard");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - Zzafrir Sistema</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .bg-zzafrir { background-color: #0A2540; }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-zzafrir rounded-full shadow-lg border-4 border-white mb-4">
                <span class="text-white font-bold text-2xl italic">Z</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Criar Conta</h1>
            <p class="text-gray-500 text-sm mt-1">Junte-se ao sistema de gestão Zzafrir</p>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
            <form method="POST" action="/register_action" class="space-y-4">
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nome Completo</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </span>
                        <input type="text" name="nome" placeholder="Seu nome" required
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-gray-300">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">E-mail</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </span>
                        <input type="email" name="email" placeholder="seu@email.com" required
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-gray-300">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Senha</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </span>
                        <input type="password" name="senha" placeholder="Crie uma senha forte" required
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-gray-300">
                    </div>
                </div>

                <?php if(isset($_GET['error'])): ?>
                    <div class="p-3 rounded-lg text-sm border flex items-center gap-2 bg-red-50 text-red-600 border-red-100">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <span>
                            <?= $_GET['error'] == 1 ? 'Preencha todos os campos obrigatórios.' : 'Este e-mail já está em uso.' ?>
                        </span>
                    </div>
                <?php endif; ?>

                <button type="submit" 
                    class="w-full bg-zzafrir hover:bg-blue-900 text-white font-bold py-3 rounded-xl shadow-lg transition-all active:scale-[0.98] mt-2">
                    Finalizar Cadastro
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">
                    Já tem uma conta? 
                    <a href="/login" class="text-blue-600 font-semibold hover:underline">Fazer login</a>
                </p>
            </div>
        </div>

        <p class="text-center text-gray-400 text-xs mt-8">
            &copy; <?= date('Y') ?> Zzafrir Tecnologia. <br>
            Ambiente Seguro e Criptografado 🔒
        </p>
    </div>

</body>
</html>