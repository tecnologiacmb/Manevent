<?php

namespace App\Http\Controllers;

use App\Models\participante;
use Illuminate\Http\Request;

class Usuarios_Controller extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('ver-usuarios', participante::class);

        try {
            return view('vista_usuarios',);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
