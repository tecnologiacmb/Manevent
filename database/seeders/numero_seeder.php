<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\numero;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class numero_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $numero = [];
        for ($i = 1; $i <= 1000; $i++) {
            $numero[] = ["numero" => $i, "estado" => 1, "disponible" => 1];
        }


        $now = Carbon::now();
        numero::insert($numero);
        numero::whereNotNull('estado')->update(['created_at' => $now, 'updated_at' => $now]);
    }
}
