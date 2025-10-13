<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    {{-- Esta línea es crucial para que Vite cargue los estilos de Tailwind --}}
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Crea tu cuenta</h2>

    {{-- Bloque para mostrar errores de validación --}}
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
            <strong class="font-bold">¡Error!</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li class="list-disc ml-4">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="multi-step-form" method="POST" action="{{ url('register') }}">
        @csrf

        {{-- Steps navigation (clickable) --}}
        <div class="flex justify-between mb-6">
            <a href="#" data-step-nav class="text-sm">DATOS PERSONALES</a>
            <a href="#" data-step-nav class="text-sm">DIRECCIÓN DE DOMICILIO</a>
            <a href="#" data-step-nav class="text-sm">Credenciales</a>
        </div>

        {{-- Step: Personal (ask only cedula first, then fill personal fields) --}}
        <div data-step="0">
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label for="nacionalidad" class="block text-gray-700 text-sm font-bold mb-2">Nacionalidad</label>
                    <input type="text" id="nacionalidad" name="nacionalidad" readonly class="bg-gray-100 shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700" />
                </div>
                <div>
                    <label for="cedula" class="block text-gray-700 text-sm font-bold mb-2">Cédula *</label>
                    <div class="flex">
                        <input type="text" id="cedula" name="cedula" required class="shadow-sm appearance-none border rounded-l-lg w-full py-2 px-3 text-gray-700" />
                        <button id="cedula-lookup-btn" class="bg-blue-500 text-white px-4 rounded-r-lg">Buscar</button>
                    </div>
                </div>
            </div>

            <div id="cedula-lookup-status" class="text-sm text-gray-600 mb-4"></div>

            <div id="personal-fields" style="display:none">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="primer_nombre" class="block text-gray-700 text-sm font-bold mb-2">Primer Nombre *</label>
                        <input type="text" id="primer_nombre" name="primer_nombre" class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700" />
                    </div>
                    <div>
                        <label for="segundo_nombre" class="block text-gray-700 text-sm font-bold mb-2">Segundo Nombre</label>
                        <input type="text" id="segundo_nombre" name="segundo_nombre" class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700" />
                    </div>
                    <div>
                        <label for="primer_apellido" class="block text-gray-700 text-sm font-bold mb-2">Primer Apellido *</label>
                        <input type="text" id="primer_apellido" name="primer_apellido" class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700" />
                    </div>
                    <div>
                        <label for="segundo_apellido" class="block text-gray-700 text-sm font-bold mb-2">Segundo Apellido</label>
                        <input type="text" id="segundo_apellido" name="segundo_apellido" class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700" />
                    </div>
                    <div>
                        <label for="fecha_nacimiento" class="block text-gray-700 text-sm font-bold mb-2">Fecha Nacimiento</label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700" />
                    </div>
                    <div>
                        <label for="sexo" class="block text-gray-700 text-sm font-bold mb-2">Sexo</label>
                        <input type="text" id="sexo" name="sexo" class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700" />
                    </div>
                </div>
            </div>

            <div class="flex justify-between mt-4">
                <button data-prev class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg" style="display:none">Atrás</button>
                <button data-next class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">Siguiente</button>
            </div>
        </div>

        {{-- Step: Cuenta --}}
        <div data-step="1" style="display:none">
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Correo Electrónico:</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Contraseña:</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirmar Contraseña:</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div class="flex justify-between">
                <button data-prev class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg">Atrás</button>
                <button data-next class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">Siguiente</button>
            </div>
        </div>

        {{-- Step: Social --}}
        <div data-step="2" style="display:none">
            <div class="mb-4">
                <label for="facebook" class="block text-gray-700 text-sm font-bold mb-2">Facebook:</label>
                <input
                    type="text"
                    id="facebook"
                    name="facebook"
                    value="{{ old('facebook') }}"
                    class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div class="mb-6">
                <label for="twitter" class="block text-gray-700 text-sm font-bold mb-2">Twitter:</label>
                <input
                    type="text"
                    id="twitter"
                    name="twitter"
                    value="{{ old('twitter') }}"
                    class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div class="flex justify-between">
                <button data-prev class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg">Atrás</button>
                <button data-next class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">Registrar</button>
            </div>
        </div>
    </form>

    <p class="text-center text-sm text-gray-600 mt-4">¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Iniciar sesión</a></p>
</div>

</body>
</html>
