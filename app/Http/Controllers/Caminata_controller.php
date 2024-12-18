<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\grupo;
use App\Models\evento;
use App\Models\dolar;
use Carbon\Carbon;



class Caminata_controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            return view('caminata',);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function create(Request $request, $id)
    {

        try {
            $grupo = grupo::findOrFail($id);

            return view('caminata-inscripcion', ['grupo' => $grupo, 'id' => $id,]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
    public function calculo($num)
    {
        $total = 0;
        $ultimoDolar =dolar::latest()->first();

        $total = $num * $ultimoDolar->precio;

        return $total;
    }
}
