<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    {{-- Topbar --}}
    <x-topbar />

    {{-- Contenido Principal del Dashboard --}}
    <div class="container mx-auto mt-8 p-6 bg-white rounded-lg shadow-md flex flex-col items-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-4 text-center">Bienvenido al Dashboard</h1>
        <p class="text-gray-600 text-center">Este es tu panel de control. Aquí podrás ver la información importante de tu aplicación.</p>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 justify-items-center">
            {{-- Ejemplo de Tarjeta de Información --}}
            <div class="bg-blue-500 text-white p-6 rounded-lg shadow-md text-center">
                <h3 class="text-xl font-semibold mb-2">Total Usuarios</h3>
                <p class="text-3xl font-bold">0</p>
            </div>

            <div class="bg-blue-500 text-white p-6 rounded-lg shadow-md text-center">
                <h3 class="text-xl font-semibold mb-2">Mensajes Nuevos</h3>
                <p class="text-3xl font-bold">0</p>
            </div>

            <div class="bg-blue-500 text-white p-6 rounded-lg shadow-md text-center">
                <h3 class="text-xl font-semibold mb-2">Tareas Pendientes</h3>
                <p class="text-3xl font-bold">0</p>
            </div>
        </div>
    </div>

</body>
</html>