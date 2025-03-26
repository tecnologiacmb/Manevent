<?php

namespace App\Http\Controllers;

use App\Models\grupo;
use Illuminate\Http\Request;

class Grupo_Controller extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('super-admin', grupo::class);

        try {
            return view('grupo',);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
