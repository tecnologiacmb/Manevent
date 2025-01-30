<?php

namespace App\Http\Controllers;

use App\Models\banco;
use Illuminate\Http\Request;

class Banco_Controller extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('ver-admin', banco::class);

        try {
            return view('banco',);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

}
