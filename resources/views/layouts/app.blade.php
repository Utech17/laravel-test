<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- El título puede cambiar en cada página --}}
    <title>@yield('title', 'Mi Aplicación')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <header class="bg-white shadow">
      <nav class="bg-blue-500 text-white p-6 rounded-lg shadow-md p-4 shadow-lg">
          <div class="container mx-auto flex justify-between items-center">
              <a href="{{ url('/dashboard') }}" class="text-white text-2xl font-bold">Mi Dashboard</a>

              <div class="flex items-center space-x-4">
                  @auth
                      <span class="text-white text-lg hidden sm:block">
                          Hola, {{ Auth::user()->name }}!
                      </span>
                      <form action="{{ url('logout') }}" method="POST" class="inline">
                          @csrf
                          <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                              Cerrar Sesión
                          </button>
                      </form>
                  @endauth
              </div>
          </div>
      </nav>
    </header>

    <main class="container mx-auto p-4 my-8">
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