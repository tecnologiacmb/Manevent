<?php

namespace App\Http\Controllers;

use App\Models\inscripcion;
use Illuminate\Http\Request;

class Inscrippcion_Controller extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('ver-admin', inscripcion::class);

        try {
            return view('incripcion',);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
