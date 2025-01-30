<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\grupo;
use App\Models\evento;
use App\Models\dolar;
use Carbon\Carbon;



class Mixto_controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            return view('Mixto',);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function create(Request $request, $id, $cantidad_carrera, $cantidad_caminata)
    {
        $resultado = $cantidad_carrera + $cantidad_caminata;
        try {
            $grupo = grupo::findOrFail($id);
            if ($resultado == $grupo->cantidad) {
                return view('mixto-inscripcion', ['grupo' => $grupo, 'id' => $id ,'cantidad_carrera' =>  $cantidad_carrera, 'cantidad_caminata' => $cantidad_caminata]);
            }
            else{
                return view('dashboard');
            }
        } catch (\Throwable $th) {

            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
    public function calculo($num)
    {
        $total = 0;
        $ultimoDolar = dolar::latest()->first();

        $total = $num * $ultimoDolar->precio;

        return $total;
    }
}
