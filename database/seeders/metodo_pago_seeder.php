<?php

namespace Database\Seeders;

use App\Models\metodo_pago;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class metodo_pago_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $this->metodo_pagos();
    }
    public function metodo_pagos(){
        $metodo_pago = [
            ["tipo_pago_id" => 6,"banco_id"=>2,"estado" => 1],

        ];
        $now = Carbon::now();
        metodo_pago::insert($metodo_pago);
        metodo_pago::whereNotNull('estado')->update(['created_at' => $now, 'updated_at' => $now]);
    }
}
