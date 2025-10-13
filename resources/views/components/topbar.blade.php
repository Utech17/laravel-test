{{-- Topbar component --}}
<nav class="bg-blue-500 text-white p-6 rounded-lg shadow-md p-4 shadow-lg">
    <div class="container mx-auto flex justify-between items-center">
        <a href="{{ url('/dashboard') }}" class="text-white text-2xl font-bold">Mi Dashboard</a>

        <div class="flex items-center space-x-4">
            {{-- Muestra el nombre del usuario si está autenticado --}}
            @auth
                <span class="text-white text-lg hidden sm:block">
                    Hola, {{ Auth::user()->name }}!
                </span>
                {{-- Botón de Cerrar Sesión --}}
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
