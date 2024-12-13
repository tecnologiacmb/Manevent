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
                ["name" => "Caminata", "status" => 1],
                ["name" => "Carrera", "status" => 1],

            ];

        $now = Carbon::now();
        recorrido::insert($recorrido);
        recorrido::whereNotNull('status')->update(['created_at' => $now, 'updated_at' => $now]);
    }
}
