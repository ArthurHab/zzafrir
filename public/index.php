<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="/tailwind.css" rel="stylesheet">
  <title>Teste Tailwind</title>
</head>

<body class="bg-gray-100">

<!-- HEADER -->
<header class="bg-blue-600 text-white p-6 flex justify-between items-center">
  <h1 class="text-2xl font-bold">Teste Tailwind</h1>

  <nav class="space-x-4">
    <a href="#" class="hover:underline">Home</a>
    <a href="#" class="hover:text-yellow-300">Sobre</a>
    <a href="#" class="hover:opacity-70">Contato</a>
  </nav>
</header>

<!-- HERO RESPONSIVO -->
<section class="p-10 text-center">
  <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-800">
    Responsividade Teste
  </h2>

  <p class="mt-4 text-gray-600 text-sm sm:text-base md:text-lg">
    Essa frase muda de tamanho conforme a tela.
  </p>

  <button class="mt-6 bg-green-500 hover:bg-green-700 text-white px-6 py-3 rounded-lg">
    Hover Teste
  </button>
</section>

<!-- GRID TESTE -->
<section class="p-6">
  <h2 class="text-xl font-bold mb-4">Grid Teste</h2>

  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">

    <div class="bg-white p-6 rounded shadow hover:shadow-xl transition">
      Card 1
    </div>

    <div class="bg-white p-6 rounded shadow hover:scale-105 transition transform">
      Card 2
    </div>

    <div class="bg-white p-6 rounded shadow border-l-4 border-blue-500">
      Card 3
    </div>

  </div>
</section>

<!-- FORM TESTE (FOCUS) -->
<section class="p-6">
  <h2 class="text-xl font-bold mb-4">Focus Teste</h2>

  <form class="space-y-4 max-w-md">

    <input
      type="text"
      placeholder="Nome"
      class="w-full p-3 border rounded focus:outline-none focus:ring-4 focus:ring-blue-300"
    />

    <input
      type="email"
      placeholder="Email"
      class="w-full p-3 border rounded focus:outline-none focus:border-green-500 focus:ring-2"
    />

    <button class="w-full bg-blue-600 text-white p-3 rounded hover:bg-blue-800">
      Enviar
    </button>

  </form>
</section>

<!-- BREAKPOINT TEST -->
<section class="p-10">
  <div class="p-10 text-white text-center 
              bg-red-500 sm:bg-yellow-500 md:bg-blue-500 lg:bg-green-500 xl:bg-purple-500">

    Breakpoints Teste
    <p class="text-sm mt-2">
      Red → Yellow → Blue → Green → Purple
    </p>

  </div>
</section>

<div class="text-red-500 sm:text-blue-500 md:text-green-500 lg:text-purple-500 text-3xl">
  TESTE BREAKPOINT
</div>

<!-- FLEX TEST -->
<section class="p-6">
  <div class="flex flex-col md:flex-row gap-4">

    <div class="flex-1 bg-white p-6 shadow rounded">
      Flex 1
    </div>

    <div class="flex-1 bg-white p-6 shadow rounded">
      Flex 2
    </div>

    <div class="flex-1 bg-white p-6 shadow rounded">
      Flex 3
    </div>

  </div>
</section>

<!-- FOOTER -->
<footer class="text-center p-6 text-gray-500">
  Tailwind Test Page
</footer>

</body>
</html>