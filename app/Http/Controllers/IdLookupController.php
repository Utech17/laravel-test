<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IdLookupController extends Controller
{
    /**
     * Lookup personal data by cedula (demo stub).
     * Replace with real API integration as needed.
     */
    public function lookup(Request $request)
    {
        $request->validate([
            'cedula' => 'required|string'
        ]);

        $cedula = $request->input('cedula');

        // Demo stub: return example data for any numeric cedula
        if (preg_match('/^\d+$/', $cedula) && strlen($cedula) >= 6) {
            // Example data — adapt to the actual API structure
            $data = [
                'nacionalidad' => 'V',
                'cedula' => $cedula,
                'primer_nombre' => 'Miguel',
                'segundo_nombre' => 'Angel',
                'primer_apellido' => 'Gutierrez',
                'segundo_apellido' => 'Suarez',
                'fecha_nacimiento' => '2005-05-17',
                'sexo' => 'M',
            ];

            return response()->json(['ok' => true, 'data' => $data]);
        }

        return response()->json(['ok' => false, 'message' => 'Cédula no encontrada o inválida'], 422);
    }
}
