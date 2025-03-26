<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class Registro_Usuario extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('super-admin', User::class);

        try {
            return view('registro_usuario',);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

}
