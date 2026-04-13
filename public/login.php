<?php
session_start();
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
    <title>Login - Zzafrir Sistema</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .bg-zzafrir { background-color: #0A2540; }
        .text-zzafrir-light { color: #0099FF; }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full shadow-lg border-4 border-blue-50 mb-4 overflow-hidden">
                <div class="relative w-full h-full flex items-center justify-center bg-zzafrir">
                    <span class="text-white font-bold text-3xl italic z-10">Z</span>
                    <div class="absolute bottom-0 w-full h-1/3 bg-blue-500 opacity-50 blur-sm"></div>
                </div>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">ZZAFRIR <span class="text-blue-600 italic">SISTEMA</span></h1>
            <p class="text-gray-500 text-sm mt-1">Gestão profissional para sua barbearia</p>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
            <form method="POST" action="/login_action" class="space-y-5">
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">E-mail corporativo</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                        </span>
                        <input type="email" name="email" placeholder="exemplo@zzafrir.com" required
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all placeholder:text-gray-300">
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label class="block text-sm font-semibold text-gray-700">Senha</label>
                        <a href="#" class="text-xs text-blue-600 hover:underline">Esqueceu?</a>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </span>
                        <input type="password" name="senha" placeholder="••••••••" required
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all placeholder:text-gray-300">
                    </div>
                </div>

                <?php if(isset($_GET['error'])): ?>
                    <div class="flex items-center gap-2 bg-red-50 text-red-600 p-3 rounded-lg text-sm border border-red-100 animate-pulse">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <span>E-mail ou senha incorretos.</span>
                    </div>
                <?php endif; ?>

                <button type="submit" 
                    class="w-full bg-zzafrir hover:bg-blue-900 text-white font-bold py-3 rounded-xl shadow-lg shadow-blue-900/20 transition-all active:scale-[0.98] flex items-center justify-center gap-2">
                    Entrar no Painel
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </button>
            </form>
        </div>

        <p class="text-center text-gray-400 text-xs mt-8">
            &copy; <?= date('Y') ?> Zzafrir Tecnologia. Todos os direitos reservados. <br>
            <span class="inline-block mt-2">✂️ 💈 🧼</span>
        </p>
    </div>

</body>
</html>