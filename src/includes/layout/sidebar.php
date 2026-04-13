<div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

<aside id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-[#0A2540] text-white flex flex-col transform -translate-x-full lg:translate-x-0 lg:static transition-transform duration-300 ease-in-out z-50">
    <div class="p-6 flex flex-col items-center border-b border-blue-900">
        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg mb-3">
             <span class="text-blue-600 font-bold text-2xl italic">Z</span>
        </div>
        <h1 class="text-xl font-bold tracking-tight italic">ZZAFRIR</h1>
        <span class="text-[10px] text-blue-300 uppercase tracking-[0.2em]">SISTEMA</span>
    </div>

    <nav class="flex-1 mt-6 px-4 space-y-2 overflow-y-auto">
        <?php
        $menuItems = [
            ['id' => 'dashboard', 'label' => 'Dashboard', 'icon' => '🏠', 'link' => 'dashboard.php'],
            ['id' => 'clientes', 'label' => 'Clientes', 'icon' => '👥', 'link' => 'clientes.php'],
            ['id' => 'servicos', 'label' => 'Serviços', 'icon' => '✂️', 'link' => '#'],
            ['id' => 'agendamentos', 'label' => 'Agendamentos', 'icon' => '📅', 'link' => '#'],
        ];

        foreach ($menuItems as $item): 
            $isActive = (isset($page) && $page == $item['id']);
        ?>
            <a href="<?= $item['link'] ?>" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all <?= $isActive ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-400 hover:bg-blue-900 hover:text-white' ?>">
                <span><?= $item['icon'] ?></span>
                <span class="font-medium"><?= $item['label'] ?></span>
            </a>
        <?php endforeach; ?>
    </nav>

    <div class="p-4 border-t border-blue-900">
        <a href="/logout.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-400 hover:bg-red-500/10 hover:text-red-400 transition-all group">
            <span class="group-hover:scale-110 transition-transform">🚪</span>
            <span class="font-medium">Sair do Sistema</span>
        </a>
    </div>

    <button id="closeSidebar" class="lg:hidden p-4 text-blue-300 text-sm border-t border-blue-900">
        ✕ Fechar Menu
    </button>
</aside>