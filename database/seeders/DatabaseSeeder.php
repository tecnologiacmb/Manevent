<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\recorrido;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call(estados_seeder::class);
        $this->call(ciudades_seeder::class);
        $this->call(numero_seeder::class);
        $this->call(tipo_pago_seeder::class);
        $this->call(recorrido_seeder::class);
        $this->call(banco_seeder::class);
    }
}
