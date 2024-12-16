<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\mesa;

class mesa_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mesa = [
            ['nombre' => "Mesa N°-1", 'estado' => true],
            ['nombre' => "Mesa N°-2", 'estado' => true],
            ['nombre' => "Mesa N°-3", 'estado' => true],
            ['nombre' => "Mesa N°-4", 'estado' => true],
            ['nombre' => "Mesa N°-5", 'estado' => true],
            ['nombre' => "Mesa N°-6", 'estado' => true],
            ['nombre' => "Mesa N°-7", 'estado' => true],
        ];

        $now = Carbon::now();
        mesa::insert($mesa);
        mesa::whereNotNull('estado')->update(['created_at' => $now, 'updated_at' => $now]);
    }
}
