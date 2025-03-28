<?php

namespace Database\Seeders;

use App\Models\prenda_category;
use App\Models\prenda_talla;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class prendas_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->prendas_tallas();
        $this->prendas_categoria();
    }

    public function prendas_tallas(){
        $tallas = [
            ["talla" => "---", "estado" => 1],
            ["talla" => "S", "estado" => 1],
            ["talla" => "M", "estado" => 1],
            ["talla" => "L", "estado" => 1],
            ["talla" => "XL", "estado" => 1],
        ];

        $now = Carbon::now();
        prenda_talla::insert($tallas);
        prenda_talla::whereNotNull('estado')->update(['created_at' => $now, 'updated_at' => $now]);
    }
    public function prendas_categoria(){
        $categoria = [
            ["nombre" => "Sin franela", "estado" => 1],
            ["nombre" => "Franela", "estado" => 1],
        ];

        $now = Carbon::now();
        prenda_category::insert($categoria);
        prenda_category::whereNotNull('estado')->update(['created_at' => $now, 'updated_at' => $now]);
    }
}
