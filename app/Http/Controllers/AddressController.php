<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddressController extends Controller
{
    // Return list of states
    public function states()
    {
        $states = [
            ['id' => 1, 'name' => 'Estado A'],
            ['id' => 2, 'name' => 'Estado B'],
        ];

        return response()->json(['ok' => true, 'data' => $states]);
    }

    // municipalities by state id
    public function municipalities(Request $request)
    {
        $stateId = intval($request->input('state_id'));

        $map = [
            1 => [
                ['id' => 10, 'name' => 'Municipio A1'],
                ['id' => 11, 'name' => 'Municipio A2'],
            ],
            2 => [
                ['id' => 20, 'name' => 'Municipio B1'],
                ['id' => 21, 'name' => 'Municipio B2'],
            ],
        ];

        $result = $map[$stateId] ?? [];
        return response()->json(['ok' => true, 'data' => $result]);
    }

    // parishes by municipality id
    public function parishes(Request $request)
    {
        $munId = intval($request->input('municipality_id'));

        $map = [
            10 => [
                ['id' => 100, 'name' => 'Parroquia A1-1'],
                ['id' => 101, 'name' => 'Parroquia A1-2'],
            ],
            11 => [
                ['id' => 110, 'name' => 'Parroquia A2-1'],
            ],
            20 => [
                ['id' => 200, 'name' => 'Parroquia B1-1'],
            ],
        ];

        $result = $map[$munId] ?? [];
        return response()->json(['ok' => true, 'data' => $result]);
    }

    // communes by parish id
    public function communes(Request $request)
    {
        $parishId = intval($request->input('parish_id'));

        $map = [
            100 => [
                ['id' => 1000, 'name' => 'Comuna 1'],
                ['id' => 1001, 'name' => 'Comuna 2'],
            ],
            101 => [
                ['id' => 1010, 'name' => 'Comuna X'],
            ],
        ];

        $result = $map[$parishId] ?? [];
        return response()->json(['ok' => true, 'data' => $result]);
    }
}
