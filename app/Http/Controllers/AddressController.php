<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Municipality;
use App\Models\Parish;

class AddressController extends Controller
{
    public function states()
    {
        return response()->json(['ok' => true, 'data' => State::orderBy('name')->get()]);
    }

    public function municipalities(Request $request)
    {
        $data = Municipality::where('state_id', $request->state_id)->orderBy('name')->get();
        return response()->json(['ok' => true, 'data' => $data]);
    }

    public function parishes(Request $request)
    {
        $data = Parish::where('municipality_id', $request->municipality_id)->orderBy('name')->get();
        return response()->json(['ok' => true, 'data' => $data]);
    }

    public function communes(Request $request)
    {
        $parish = Parish::find($request->parish_id);
        $data = $parish ? $parish->communes()->orderBy('name')->get() : [];
        return response()->json(['ok' => true, 'data' => $data]);
    }
}
