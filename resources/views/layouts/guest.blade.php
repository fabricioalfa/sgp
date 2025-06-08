<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Iniciar sesión')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-image: url('{{ asset('images/fondologo.png') }}');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center px-6 py-12">

  <main class="w-full max-w-md bg-white/80 backdrop-blur-md p-8 rounded-2xl shadow-2xl border border-white/40 ml-auto mr-12">
    @yield('content')
  </main>
  

</body>
</html>
