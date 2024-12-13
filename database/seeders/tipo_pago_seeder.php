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
                ["name" => "Efectivo Bs", "status" => 1],
                ["name" => "Efectivo $", "status" => 1],
                ["name" => "Zelle", "status" => 1],
                ["name" => "Pago Movil", "status" => 1],
                ["name" => "Transferencia", "status" => 1],
                ["name" => "Punto", "status" => 1],
                ["name" => "PAGO MIXTO", "status" => 1],
                ["name" => "EFECTIVO", "status" => 1],
            ];

        $now = Carbon::now();
        tipo_pago::insert($tipo_pago);
        tipo_pago::whereNotNull('status')->update(['created_at' => $now, 'updated_at' => $now]);
    }
}
