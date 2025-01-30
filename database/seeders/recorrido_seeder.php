<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\recorrido;
use Carbon\Carbon;

class recorrido_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $recorrido = [
            ["nombre" => "Caminata", "estado" => 1],
            ["nombre" => "Carrera", "estado" => 1],
            ["nombre" => "Mixto", "estado" => 1],


        ];

        $now = Carbon::now();
        recorrido::insert($recorrido);
        recorrido::whereNotNull('estado')->update(['created_at' => $now, 'updated_at' => $now]);
    }
}
