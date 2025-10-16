<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- El título puede cambiar en cada página --}}
    <title>@yield('title', 'Login')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <main class="bg-gray-100 flex items-center justify-center min-h-screen">
        @yield('content')
    </main>
{{-- 
    <footer class="bg-gray-800 text-white text-center p-4">
        <p>&copy; {{ date('Y') }} Mi Empresa</p>
    </footer> --}}

    {{-- Un stack para scripts específicos de cada página (opcional) --}}
    @stack('scripts')
</body>
</html>