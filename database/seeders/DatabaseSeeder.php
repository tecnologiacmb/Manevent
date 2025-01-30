<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\categoriaHabilitada;
use App\Models\recorrido;
use App\Models\User;

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
        $this->call(mesa_seeder::class);
        $this->call(categoria_habilitada_seeder::class);
        $this->call(User_seeder::class);

    }
}
