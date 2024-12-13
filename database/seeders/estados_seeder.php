<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\estado;
use Carbon\Carbon;
class estados_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estado = [
            ['estado' => "Amazonas", 'iso_3166-2' => 'VE-X'],
            ['estado' => "Anzoátegui", 'iso_3166-2' => 'VE-B'],
            ['estado' => "Apure", 'iso_3166-2' => 'VE-C'],
            ['estado' => "Aragua", 'iso_3166-2' =>'VE-D'],
            ['estado' => "Barinas", 'iso_3166-2' =>'VE-E'],
            ['estado' => "Bolívar", 'iso_3166-2' => 'VE-F'],
            ['estado' => "Carabobo", 'iso_3166-2' => 'VE-G'],
            ['estado' => "Cojedes", 'iso_3166-2' => 'VE-H'],
            ['estado' => "Delta Amacuro", 'iso_3166-2' => 'VE-Y'],
            ['estado' => "Falcón", 'iso_3166-2' => 'VE-I'],
            ['estado' => "Guárico", 'iso_3166-2' => 'VE-J'],
            ['estado' => "Lara", 'iso_3166-2' => 'VE-K'],
            ['estado' => "Mérida", 'iso_3166-2' => 'VE-L'],
            ['estado' => "Miranda", 'iso_3166-2' => 'VE-M'],
            ['estado' => "Monagas", 'iso_3166-2' => 'VE-N'],
            ['estado' => "Nueva Esparta", 'iso_3166-2' => 'VE-O'],
            ['estado' => "Portuguesa", 'iso_3166-2' => 'VE-P'],
            ['estado' => "Sucre", 'iso_3166-2' => 'VE-R'],
            ['estado' => "Táchira", 'iso_3166-2' => 'VE-S'],
            ['estado' => "Trujillo", 'iso_3166-2' => 'VE-T'],
            ['estado' => "La Guaira", 'iso_3166-2' => 'VE-W'],
            ['estado' => "Yaracuy", 'iso_3166-2' => 'VE-U'],
            ['estado' => "Zulia", 'iso_3166-2' => 'VE-V'],
            ['estado' => "Distrito Capital (Caracas)", 'iso_3166-2' => 'VE-A'],
            ['estado' => "Dependencias Federales", 'iso_3166-2' => 'VE-Z'],

        ];
        $now = Carbon::now();
        estado::insert($estado);
        estado::whereNotNull('estado')->update(['created_at' => $now, 'updated_at' => $now]);
    }
}
