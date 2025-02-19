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

    public function create(Request $request, $id)
    {

        try {
            $inscripcion = inscripcion::findOrFail($id);

            return view('vista_inscripcion', ['incripcion' => $inscripcion, 'id' => $id,]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
