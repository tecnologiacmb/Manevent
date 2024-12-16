<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\categoriaHabilitada;
use Carbon\Carbon;

class categoria_habilitada_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoriaHabilitada = [
            ['nombre' => "Juvenil", 'edad_min' => 15, 'edad_max' => 19],
            ['nombre' => "Libre", 'edad_min' => 20, 'edad_max' => 29],
            ['nombre' => "Sub-Master A", 'edad_min' => 30, 'edad_max' => 34],
            ['nombre' => "Sub-Master B", 'edad_min' => 35, 'edad_max' => 39],
            ['nombre' => "Master A", 'edad_min' => 40, 'edad_max' => 44],
            ['nombre' => "Master B", 'edad_min' => 45, 'edad_max' => 49],
            ['nombre' => "Master C", 'edad_min' => 50, 'edad_max' => 54],
            ['nombre' => "Master D", 'edad_min' => 55, 'edad_max' => 59],
            ['nombre' => "Master E", 'edad_min' => 60, 'edad_max' => 64],
            ['nombre' => "Master F", 'edad_min' => 65, 'edad_max' => 69],
            ['nombre' => "Master G", 'edad_min' => 70, 'edad_max' => 90],


        ];

        $now = Carbon::now();
        categoriaHabilitada::insert($categoriaHabilitada);
        categoriaHabilitada::whereNotNull('edad_min')->update(['created_at' => $now, 'updated_at' => $now]);
    }
}
