<?php

namespace App\Http\Controllers;

use App\Models\user;
use Illuminate\Http\Request;

class Register_controller extends Controller
{
    public function index(Request $request)
    {

        try {
            return view('auth/register',);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
