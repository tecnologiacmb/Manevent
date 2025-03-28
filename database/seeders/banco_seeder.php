<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\banco;

class banco_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banco = [
            ["nombre" => "Efectivo", "codigo" => "0001", "estado" => 1],
            ["nombre" => "Pago Mixto", "codigo" => "0002", "estado" => 1],
            ["nombre" => "100% BANCO, BANCO UNIVERSAL C.A.", "codigo" => "0156", "estado" => 1],
            ["nombre" => "BANCAMIGA BANCO UNIVERSAL", "codigo" => "0172", "estado" => 1],
            ["nombre" => "BANCO ACTIVO, C.A.", "codigo" => "0171", "estado" => 1],
            ["nombre" => "BANCO AGRICOLA DE VENEZUELA C.A.", "codigo" => "0166", "estado" => 1],
            ["nombre" => "BANCO BICENTENARIO BANCO UNIVERSAL C.A.", "codigo" => "0175", "estado" => 1],
            ["nombre" => "BANCO CARONI, C.A. BANCO UNIVERSAL", "codigo" => "0128", "estado" => 1],
            ["nombre" => "BANCO DE LA FUERZA ARMADA NACIONAL BOLIVARIANA", "codigo" => "0177", "estado" => 1],
            ["nombre" => "BANCO DE VENEZUELA S.A. BANCO UNIVERSAL", "codigo" => "0102", "estado" => 1],
            ["nombre" => "BANCO DEL CARIBE S.A.C.A.", "codigo" => "0114", "estado" => 1],
            ["nombre" => "BANCO DEL TESORO", "codigo" => "0163", "estado" => 1],
            ["nombre" => "BANCO EXTERIOR, C.A.", "codigo" => "0115", "estado" => 1],
            ["nombre" => "BANCO NACIONAL DE CREDITO, C.A.", "codigo" => "0191", "estado" => 1],
            ["nombre" => "BANCO OCCIDENTAL DE DESCUENTO S.A.C.A.", "codigo" => "0116", "estado" => 1],
            ["nombre" => "BANCO PLAZA", "codigo" => "0138", "estado" => 1],
            ["nombre" => "BANCO PROVINCIAL S.A. BANCO UNIVERSAL", "codigo" => "0108", "estado" => 1],
            ["nombre" => "BANCO SOFITASA", "codigo" => "0137", "estado" => 1],
            ["nombre" => "BANCRECER S.A. BANCO MICROFINANCIERO", "codigo" => "0168", "estado" => 1],
            ["nombre" => "BANESCO BANCO UNIVERSAL", "codigo" => "0134", "estado" => 1],
            ["nombre" => "BANPLUS BANCO UNIVERSAL, C.A.", "codigo" => "0174", "estado" => 1],
            ["nombre" => "DEL SUR BANCO UNIVERSAL, C.A.", "codigo" => "0157", "estado" => 1],
            ["nombre" => "FONDO COMUN, C.A. BANCO UNIVERSAL", "codigo" => "0151", "estado" => 1],
            ["nombre" => "MERCANTIL BANCO UNIVERSAL", "codigo" => "0105", "estado" => 1],
            ["nombre" => "MIBANCO BANCO DE DESARROLLO", "codigo" => "0169", "estado" => 1],
            ["nombre" => "VENEZOLANO DE CREDITO, S.A. BANCO UNIVERSAL", "codigo" => "0104", "estado" => 1],

        ];

        $now = Carbon::now();
        banco::insert($banco);
        banco::whereNotNull('nombre')->update(['created_at' => $now, 'updated_at' => $now]);
    }
}
