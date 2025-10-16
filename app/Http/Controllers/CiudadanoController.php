<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ciudadano;

class CiudadanoController extends Controller{
    public function FindOne(Request $request, $cedula = null){
        $cedula = $cedula ?? $request->input('cedula');
        if (! $cedula) {
            return response()->json(['ok' => false, 'message' => 'Cédula requerida'], 422);
        }

        $ciudadano = Ciudadano::where('cedula', $cedula)->first();

        if ($ciudadano) {
            return response()->json(['ok' => true, 'data' => $ciudadano]);
        }

        return response()->json(['ok' => false, 'message' => 'Cédula no encontrada'], 404);
    }

    public function CreateCiudadano(Request $request){
        $data = $request->validate([
            'cedula' => 'required|string',
            'primer_nombre' => 'required|string|max:255',
            'segundo_nombre' => 'nullable|string|max:255',
            'primer_apellido' => 'required|string|max:255',
            'segundo_apellido' => 'required|nullable|string|max:255',
            'fecha_nacimiento' => 'required|nullable|date',
            'sexo' => 'required|nullable|string|max:1',
            'nacionalidad' => 'required|string|max:50',
        ]);
        $ciudadano = Ciudadano::create($data);
        return response()->json(['ok' => true, 'data' => $ciudadano]);
    }
}
