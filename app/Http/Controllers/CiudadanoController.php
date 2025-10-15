<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ciudadano;

class CuidadanoController extends Controller
{
    public function FindOne(Request $request, $cedula = null) // acepta GET /lookup-id/{cedula} o POST con body { cedula }
    {
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
}