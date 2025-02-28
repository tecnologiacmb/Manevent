<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\tipo_pago;
use Carbon\Carbon;

class tipo_pago_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $tipo_pago = [
            ["nombre" => "Efectivo", "estado" => 1],
            ["nombre" => "Zelle", "estado" => 1],
            ["nombre" => "Pago Movil", "estado" => 1],
            ["nombre" => "Transferencia", "estado" => 1],
            ["nombre" => "Punto", "estado" => 1],
        ];

        $now = Carbon::now();
        tipo_pago::insert($tipo_pago);
        tipo_pago::whereNotNull('estado')->update(['created_at' => $now, 'updated_at' => $now]);
    }
}
