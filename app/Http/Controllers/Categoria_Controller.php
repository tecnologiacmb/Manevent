<?php

namespace App\Http\Controllers;

use App\Models\categoriaHabilitada;
use Illuminate\Http\Request;

class Categoria_Controller extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('ver-admin', categoriaHabilitada::class);

        try {
            return view('categoria',);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
