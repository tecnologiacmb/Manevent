<?php

namespace Database\Seeders;

use App\Models\genero;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class genero_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genero = [
            ["genero" => "Hombre", "estado" => 1],
            ["genero" => "Mujer", "estado" => 1],


        ];

        $now = Carbon::now();
        genero::insert($genero);
        genero::whereNotNull('estado')->update(['created_at' => $now, 'updated_at' => $now]);
    }
}
