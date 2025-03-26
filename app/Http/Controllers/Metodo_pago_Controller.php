<?php

namespace App\Http\Controllers;

use App\Models\metodo_pago;
use Illuminate\Http\Request;

class Metodo_pago_Controller extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('super-admin', metodo_pago::class);

        try {
            return view('metodo-pago',);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
