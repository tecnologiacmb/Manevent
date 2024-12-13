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
            ["name" => "100% BANCO, BANCO UNIVERSAL C.A.", "codigo" => "0156", "status" => 1],
            ["name" => "BANCAMIGA BANCO UNIVERSAL", "codigo" => "0172", "status" => 1],
            ["name" => "BANCO ACTIVO, C.A.", "codigo" => "0171", "status" => 1],
            ["name" => "BANCO AGRICOLA DE VENEZUELA C.A.", "codigo" => "0166", "status" => 1],
            ["name" => "BANCO BICENTENARIO BANCO UNIVERSAL C.A.", "codigo" => "0175", "status" => 1],
            ["name" => "BANCO CARONI, C.A. BANCO UNIVERSAL", "codigo" => "0128", "status" => 1],
            ["name" => "BANCO DE LA FUERZA ARMADA NACIONAL BOLIVARIANA", "codigo" => "0177", "status" => 1],
            ["name" => "BANCO DE VENEZUELA S.A. BANCO UNIVERSAL", "codigo" => "0102", "status" => 1],
            ["name" => "BANCO DEL CARIBE S.A.C.A.", "codigo" => "0114", "status" => 1],
            ["name" => "BANCO DEL TESORO", "codigo" => "0163", "status" => 1],
            ["name" => "BANCO EXTERIOR, C.A.", "codigo" => "0115", "status" => 1],
            ["name" => "BANCO NACIONAL DE CREDITO, C.A.", "codigo" => "0191", "status" => 1],
            ["name" => "BANCO OCCIDENTAL DE DESCUENTO S.A.C.A.", "codigo" => "0116", "status" => 1],
            ["name" => "BANCO PLAZA", "codigo" => "0138", "status" => 1],
            ["name" => "BANCO PROVINCIAL S.A. BANCO UNIVERSAL", "codigo" => "0108", "status" => 1],
            ["name" => "BANCO SOFITASA", "codigo" => "0137", "status" => 1],
            ["name" => "BANCRECER S.A. BANCO MICROFINANCIERO", "codigo" => "0168", "status" => 1],
            ["name" => "BANESCO BANCO UNIVERSAL", "codigo" => "0134", "status" => 1],
            ["name" => "BANPLUS BANCO UNIVERSAL, C.A.", "codigo" => "0174", "status" => 1],
            ["name" => "DEL SUR BANCO UNIVERSAL, C.A.", "codigo" => "0157", "status" => 1],
            ["name" => "FONDO COMUN, C.A. BANCO UNIVERSAL", "codigo" => "0151", "status" => 1],
            ["name" => "MERCANTIL BANCO UNIVERSAL", "codigo" => "0105", "status" => 1],
            ["name" => "MIBANCO BANCO DE DESARROLLO", "codigo" => "0169", "status" => 1],
            ["name" => "VENEZOLANO DE CREDITO, S.A. BANCO UNIVERSAL", "codigo" => "0104", "status" => 1],
            ["name" => "Efectivo", "codigo" => "0001", "status" => 1],
            ["name" => "Pago Mixto", "codigo" => "0002", "status" => 1],
        ];

        $now = Carbon::now();
        banco::insert($banco);
        banco::whereNotNull('name')->update(['created_at' => $now, 'updated_at' => $now]);
    }
}
