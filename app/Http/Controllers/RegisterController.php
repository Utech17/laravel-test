<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;
use App\Models\Ciudadano;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Muestra la vista del formulario de registro.
     */
    public function showRegistrationForm(\Illuminate\Http\Request $request)
    {
        // Si la petición viene con ?cedula=xxxx hacemos lookup y pasamos los datos a la vista
        $lookup = null;
        $notFound = false;
        $alreadyRegistered = false;
        if ($request->filled('cedula')) {
            $lookup = Ciudadano::where('cedula', $request->query('cedula'))->first();
            if (! $lookup) {
                $notFound = true;
            } else {
                // Si el ciudadano ya tiene un profile, no permitir continuar y mostrar mensaje
                if ($lookup->profile()->exists()) {
                    $alreadyRegistered = true;
                    // No pasar $lookup para que no se muestren campos editables
                    $lookup = null;
                }
            }
        }

        return view('auth.register')->with([
            'lookup' => $lookup,
            'lookup_not_found' => $notFound,
            'lookup_already_registered' => $alreadyRegistered,
        ]);
    }

    /**
     * Maneja la solicitud de registro.
     */
    public function register(Request $request)
    {
        // 1. Validar todos los datos del formulario de varios pasos
        $validatedData = $request->validate([
            // Paso 1: Datos Personales
            // Si el lookup se usó, viene ciudadano_id; nacionalidad ya no se requiere en el post
            'ciudadano_id' => 'nullable|exists:ciudadanos,id',
            'cedula' => 'required|string',
            'primer_nombre' => 'required|string|max:255',
            'segundo_nombre' => 'nullable|string|max:255',
            'primer_apellido' => 'required|string|max:255',
            'segundo_apellido' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'sexo' => 'nullable|string|max:1',

            // Paso 2: Dirección
            'commune_id' => 'nullable|exists:communes,id',
            'state_id' => 'nullable|exists:states,id',
            'municipality_id' => 'nullable|exists:municipalities,id',
            'parish_id' => 'nullable|exists:parishes,id',
            'urbanizacion' => 'required|string|max:255',
            'calle' => 'required|string|max:255',
            'numero_casa' => 'required|string|max:255',

            // Paso 3: Credenciales y otros
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'prefix' => ['required', 'string'],
            'phone_number' => 'required|string|max:20',
            'estado_civil' => 'required',
            'ocupacion' => 'required',
        ]);

        // 2. Usar una transacción para asegurar la integridad de los datos
        try {
            DB::beginTransaction();

            // Si el request incluye ciudadano_id (viene del lookup), usar ese registro
            $ciudadano = null;
            if (!empty($validatedData['ciudadano_id'])) {
                $ciudadano = Ciudadano::find($validatedData['ciudadano_id']);
                if ($ciudadano && $ciudadano->profile()->exists()) {
                    DB::rollBack();
                    return back()->withInput()->withErrors(['cedula' => 'La cédula ya está asociada a un perfil.']);
                }
            } else {
                $ciudadano = Ciudadano::where('cedula', $validatedData['cedula'])->first();
            }

            if ($ciudadano) {
                // actualizar datos básicos si vienen nuevos (pero respetar valores existentes si vienen vacíos)
                $ciudadano->fill([
                    'primer_nombre' => $validatedData['primer_nombre'] ?? $ciudadano->primer_nombre,
                    'segundo_nombre' => $validatedData['segundo_nombre'] ?? $ciudadano->segundo_nombre,
                    'primer_apellido' => $validatedData['primer_apellido'] ?? $ciudadano->primer_apellido,
                    'segundo_apellido' => $validatedData['segundo_apellido'] ?? $ciudadano->segundo_apellido,
                    'fecha_nacimiento' => $validatedData['fecha_nacimiento'] ?? $ciudadano->fecha_nacimiento,
                    'sexo' => $validatedData['sexo'] ?? $ciudadano->sexo,
                ]);
                $ciudadano->save();
            } else {
                $ciudadano = Ciudadano::create([
                    'cedula' => $validatedData['cedula'],
                    'primer_nombre' => $validatedData['primer_nombre'],
                    'segundo_nombre' => $validatedData['segundo_nombre'],
                    'primer_apellido' => $validatedData['primer_apellido'],
                    'segundo_apellido' => $validatedData['segundo_apellido'],
                    'fecha_nacimiento' => $validatedData['fecha_nacimiento'],
                    'sexo' => $validatedData['sexo'],
                ]);
            }

            // Crear la dirección
            $address = Address::create([
                'commune_id' => $validatedData['commune_id'] ?? null,
                'state_id' => $validatedData['state_id'] ?? null,
                'municipality_id' => $validatedData['municipality_id'] ?? null,
                'parish_id' => $validatedData['parish_id'] ?? null,
                'urbanizacion' => $validatedData['urbanizacion'],
                'calle' => $validatedData['calle'],
                'numero_casa' => $validatedData['numero_casa'],
            ]);
            
            // Crear el usuario
            $user = User::create([
                'name' => $validatedData['primer_nombre'] . ' ' . $validatedData['primer_apellido'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            // Crear el teléfono y asociarlo al usuario
            $phone = \App\Models\Phone::create([
                'user_id' => $user->id,
                'prefix' => $validatedData['prefix'],
                'number' => $validatedData['phone_number'],
            ]);

            // Resolver occupation y civil status: si el formulario envía ID lo usamos, si envía nombre lo buscamos/creamos
            $occupationId = null;
            if (!empty($validatedData['ocupacion'])) {
                if (is_numeric($validatedData['ocupacion'])) {
                    $occupationId = (int) $validatedData['ocupacion'];
                } else {
                    $occ = \App\Models\Occupation::firstOrCreate(['name' => $validatedData['ocupacion']]);
                    $occupationId = $occ->id;
                }
            }

            $civilStatusId = null;
            if (!empty($validatedData['estado_civil'])) {
                if (is_numeric($validatedData['estado_civil'])) {
                    $civilStatusId = (int) $validatedData['estado_civil'];
                } else {
                    $cs = \App\Models\CivilStatus::firstOrCreate(['name' => $validatedData['estado_civil']]);
                    $civilStatusId = $cs->id;
                }
            }

            // Crear el perfil para enlazar todo (asumiendo que tienes este modelo)
            // Aquí también podrías guardar el teléfono, estado civil, etc., en sus propias tablas si las tienes.
          Profile::create([
              'user_id' => $user->id,
              'occupation_id' => $occupationId,
              'civil_status_id' => $civilStatusId,
              'ciudadano_id' => $ciudadano->id,
              'address_id' => $address->id,
              'phone_id' => $phone->id,
          ]);

            DB::commit();

            // 3. Autenticar al nuevo usuario
            Auth::login($user);

            // 4. Redirigir al dashboard
            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            // Si algo sale mal, revertir todos los cambios en la BD
            DB::rollBack();
            
            // Registrar el error y redirigir con un mensaje
            \Log::error('Error en el registro: ' . $e->getMessage());
            $msg = app()->environment('local') ? ('Ocurrió un error durante el registro: ' . $e->getMessage()) : 'Ocurrió un error durante el registro. Por favor, inténtelo de nuevo.';
            return back()->withInput()->with('error', $msg);
        }
    }

    /**
     * Lookup cédula desde el formulario sin usar JS avanzado en el cliente.
     * Recibe 'cedula' por POST y devuelve JSON con datos del ciudadano si existe.
     */
    public function lookupCedula(Request $request)
    {
        $data = $request->validate(['cedula' => 'required|string']);
        $ciudadano = Ciudadano::where('cedula', $data['cedula'])->first();
        if ($ciudadano) {
            // si es petición AJAX retornar JSON
            if ($request->wantsJson()) {
                return response()->json(['ok' => true, 'data' => $ciudadano]);
            }
            // si es submit desde form, redirigir con los valores en old input para rellenar el form
            return redirect()->back()->withInput(array_merge($request->all(), [
                'nacionalidad' => $ciudadano->nacionalidad,
                'primer_nombre' => $ciudadano->primer_nombre,
                'segundo_nombre' => $ciudadano->segundo_nombre,
                'primer_apellido' => $ciudadano->primer_apellido,
                'segundo_apellido' => $ciudadano->segundo_apellido,
                'fecha_nacimiento' => $ciudadano->fecha_nacimiento,
                'sexo' => $ciudadano->sexo,
            ]));
        }

        if ($request->wantsJson()) {
            return response()->json(['ok' => false, 'message' => 'Cédula no encontrada'], 404);
        }

        return redirect()->back()->withInput()->withErrors(['cedula' => 'Cédula no encontrada']);
    }
}