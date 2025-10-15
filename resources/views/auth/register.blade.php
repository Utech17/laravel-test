@extends('layouts.auth')

@section('title', 'Registro')

@section('content')

<div class="bg-white p-8 rounded-lg shadow-md ">
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

    <form id="multi-step-form" method="POST" action="{{ route('register') }}">
        @csrf
        {{-- Si hubo lookup, enviar el id del ciudadano para asociarlo al perfil; la nacionalidad es solo de display --}}
        @if(old('ciudadano_id') || (isset($lookup) && $lookup))
            <input type="hidden" name="ciudadano_id" value="{{ old('ciudadano_id', isset($lookup) && $lookup ? $lookup->id : '') }}" />
        @endif

        {{-- Descripciones de cada step (solo una visible a la vez) --}}
        <div class="flex justify-center mb-6">
            <p class="step-desc text-gray-600 text-sm text-center mx-3" data-step-desc="0">DATOS PERSONALES</p>
            <p class="step-desc text-gray-600 text-sm text-center mx-3" data-step-desc="1" style="display:none">DIRECCIÓN DE DOMICILIO</p>
            <p class="step-desc text-gray-600 text-sm text-center mx-3" data-step-desc="2" style="display:none">CREDENCIALES Y DATOS ADICIONALES</p>
        </div>

        {{-- Step: DATOS PERSONALES --}}
        <div data-step="0">
            <div class="mb-4 grid gap-4 items-center">
                <div class="flex flex-col ">
                    <label for="cedula" class="block text-gray-700 text-sm font-bold mb-2 text-center w-full">Cédula *</label>
                    <div class="flex justify-center w-full">
                        <div class="w-full max-w-md flex">
                            <input type="text" id="cedula" name="cedula" value="{{ old('cedula', request('cedula')) }}" required class="shadow-sm appearance-none border rounded-l-lg w-full py-2 px-3 text-gray-700" {{ isset($lookup) && $lookup ? 'readonly' : '' }} />
                            @if(!(isset($lookup) && $lookup))
                                <button id="cedula-lookup-btn" type="submit" formmethod="get" formnovalidate class="bg-blue-500 text-white px-4 rounded-r-lg">Buscar</button>
                            @else
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div id="cedula-lookup-status" class="text-sm text-gray-600 mb-4">
                @if($errors->has('cedula'))
                    <span class="text-red-600">{{ $errors->first('cedula') }}</span>
                @endif
                @if(isset($lookup_not_found) && $lookup_not_found)
                    <span class="text-yellow-600">Cédula no encontrada.</span>
                @endif
                @if(isset($lookup_already_registered) && $lookup_already_registered)
                    <span class="text-red-600">Este número de cédula ya está registrado en otro perfil. Si crees que es un error, contacta al soporte.</span>
                @endif
            </div>

            {{-- Reset lookup button cuando hubo una búsqueda (para limpiar y volver a intentar) --}}
            @if(request()->filled('cedula') || (isset($lookup) && $lookup) || (isset($lookup_already_registered) && $lookup_already_registered))
                <div class="flex justify-center mb-4">
                    <a href="{{ route('register') }}" class="text-sm text-gray-500 underline">Reset</a>
                </div>
            @endif

            <div id="personal-fields" style="display:{{ isset($lookup) && $lookup ? 'block' : 'none' }}">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="nacionalidad_display" class="block text-gray-700 text-sm font-bold mb-2">Nacionalidad</label>
                        <input type="text" id="nacionalidad_display" value="{{ old('nacionalidad', isset($lookup) && $lookup ? $lookup->nacionalidad : '') }}" disabled class="bg-gray-100 shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700" />
                    </div>
                    <div>
                        <label for="primer_nombre" class="block text-gray-700 text-sm font-bold mb-2">Primer Nombre *</label>
                        <input type="text" id="primer_nombre" name="primer_nombre" value="{{ old('primer_nombre', isset($lookup) && $lookup ? $lookup->primer_nombre : '') }}" class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700" {{ isset($lookup) && $lookup ? 'readonly' : '' }} />
                    </div>
                    <div>
                        <label for="segundo_nombre" class="block text-gray-700 text-sm font-bold mb-2">Segundo Nombre</label>
                        <input type="text" id="segundo_nombre" name="segundo_nombre" value="{{ old('segundo_nombre', isset($lookup) && $lookup ? $lookup->segundo_nombre : '') }}" class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700" {{ isset($lookup) && $lookup ? 'readonly' : '' }} />
                    </div>
                    <div>
                        <label for="primer_apellido" class="block text-gray-700 text-sm font-bold mb-2">Primer Apellido *</label>
                        <input type="text" id="primer_apellido" name="primer_apellido" value="{{ old('primer_apellido', isset($lookup) && $lookup ? $lookup->primer_apellido : '') }}" class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700" {{ isset($lookup) && $lookup ? 'readonly' : '' }} />
                    </div>
                    <div>
                        <label for="segundo_apellido" class="block text-gray-700 text-sm font-bold mb-2">Segundo Apellido</label>
                        <input type="text" id="segundo_apellido" name="segundo_apellido" value="{{ old('segundo_apellido', isset($lookup) && $lookup ? $lookup->segundo_apellido : '') }}" class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700" {{ isset($lookup) && $lookup ? 'readonly' : '' }} />
                    </div>
                    <div>
                        <label for="fecha_nacimiento" class="block text-gray-700 text-sm font-bold mb-2">Fecha Nacimiento</label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', isset($lookup) && $lookup ? $lookup->fecha_nacimiento : '') }}" class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700" {{ isset($lookup) && $lookup ? 'readonly' : '' }} />
                    </div>
                    <div>
                        <label for="sexo" class="block text-gray-700 text-sm font-bold mb-2">Sexo</label>
                        <input type="text" id="sexo" name="sexo" value="{{ old('sexo', isset($lookup) && $lookup ? $lookup->sexo : '') }}" class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700" {{ isset($lookup) && $lookup ? 'readonly' : '' }} />
                    </div>
                </div>
            </div>

            <div class="flex justify-between mt-4">
                <button data-prev class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg" style="display:none">Atrás</button>
                <button data-next class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">Siguiente</button>
            </div>
        </div>

        {{-- Step: Dirección de Domicilio --}}
        <div data-step="1" style="display:none">
            <div class="flex justify-center mb-4">
                <div class="w-full max-w-2xl">
                    <div class="grid grid-cols-1 gap-4 mb-4">
                <div>
                    <label for="state" class="block text-gray-700 text-sm font-bold mb-2">Estado *</label>
                    <select id="state" name="state_id" data-old="{{ old('state_id') }}" class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700">
                        <option value="">Cargando estados...</option>
                    </select>
                </div>
                <div>
                    <label for="municipality" class="block text-gray-700 text-sm font-bold mb-2">Municipio *</label>
                    <select id="municipality" name="municipality_id" data-old="{{ old('municipality_id') }}" disabled class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700">
                        <option value="">Seleccione estado primero</option>
                    </select>
                </div>
                <div>
                    <label for="parish" class="block text-gray-700 text-sm font-bold mb-2">Parroquia *</label>
                    <select id="parish" name="parish_id" data-old="{{ old('parish_id') }}" disabled class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700">
                        <option value="">Seleccione municipio primero</option>
                    </select>
                </div>
                <div>
                    <label for="commune" class="block text-gray-700 text-sm font-bold mb-2">Comuna *</label>
                    <select id="commune" name="commune_id" data-old="{{ old('commune_id') }}" disabled class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700">
                        <option value="">Seleccione parroquia primero</option>
                    </select>
                    <div id="address-error" class="text-sm text-red-600 mt-2" style="display:none"></div>
                </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="urbanizacion" class="block text-gray-700 text-sm font-bold mb-2">Urbanización *</label>
                    <input type="text" id="urbanizacion" name="urbanizacion" class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700" />
                </div>
                <div>
                    <label for="calle" class="block text-gray-700 text-sm font-bold mb-2">Calle o Avenida *</label>
                    <input type="text" id="calle" name="calle" class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700" />
                </div>
                <div>
                    <label for="numero_casa" class="block text-gray-700 text-sm font-bold mb-2">Número Casa/Apartamento *</label>
                    <input type="text" id="numero_casa" name="numero_casa" class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700" />
                </div>
                <div>
                    <label for="otro" class="block text-gray-700 text-sm font-bold mb-2">Otros</label>
                    <input type="text" id="otro" name="otro" class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700" />
                </div>
            </div>

            <div class="flex justify-between">
                <button data-prev class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg">Atrás</button>
                <button data-next class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">Siguiente</button>
            </div>
        </div>

        {{-- Step: Credenciales y Datos Adicionales --}}
        <div data-step="2" style="display:none">
            <div class="flex justify-center mb-4">
                <div class="w-full max-w-2xl">
                    <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="estado_civil" class="block text-gray-700 text-sm font-bold mb-2">Estado Civil *</label>
                    <select id="estado_civil" name="estado_civil" class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700">
                        <option value="">-- Seleccione --</option>
                        <option value="soltero">Soltero(a)</option>
                        <option value="casado">Casado(a)</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                <div>
                    <label for="ocupacion" class="block text-gray-700 text-sm font-bold mb-2">Ocupación o Profesión *</label>
                    <select id="ocupacion" name="ocupacion" class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700">
                        <option value="">-- Seleccione --</option>
                        <option value="estudiante">Estudiante</option>
                        <option value="empleado">Empleado</option>
                        <option value="independiente">Independiente</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4 items-end">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Número Celular *</label>
                    <div class="flex">
                        <select id="phone_code" name="prefix" class="shadow-sm appearance-none border rounded-l-lg py-2 px-3 text-gray-700">
                            <option value="">Prefijo</option>
                            <option value="412">412 (Digitel)</option>
                            <option value="414">414 (Movistar)</option>
                            <option value="424">424 (Movistar)</option>
                            <option value="416">416 (Movilnet)</option>
                            <option value="426">426 (Movilnet)</option>
                        </select>
                        <input type="text" id="phone_number" name="phone_number" required placeholder="Número Celular" class="shadow-sm appearance-none border rounded-r-lg w-full py-2 px-3 text-gray-700" />
                    </div>
                </div> 
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Contraseña *</label>
                    <input type="password" id="password" name="password" required class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700" />
                </div>
                <div>
                    <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirmar Contraseña *</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700" />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Correo Electrónico *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700" />
                </div>
                <div>
                    <label for="email_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirmar Correo *</label>
                    <input type="email" id="email_confirmation" name="email_confirmation" required class="shadow-sm appearance-none border rounded-lg w-full py-2 px-3 text-gray-700" />
                </div>
                
            </div>

            <div class="flex justify-between">
                <button data-prev class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg">Atrás</button>
                <button data-next class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">Registrar</button>
            </div>
        </div>
    </form>
    
</div>

<div id="have-account" class="mt-8 flex justify-center" style="display:none">
    <p class="text-center text-sm text-gray-600">¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Iniciar sesión</a></p>
</div>
@endsection
