<?php

namespace App\Livewire\Reportes;

use App\Models\inscripcion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReporteFondo extends Component
{
    public $open = false;
    public $detalles = null;
    public $bolivares;
    public $dolar;
    public $total;
    public $valor_nomenclatura;



    public function calcular($value_Bs)
    {
        $this->bolivares = $value_Bs;
        // Acceder al primer elemento de la colección
        try {
            $resultado = $this->bolivares / ($this->detalles->first()->dolar);
            $resultado_formateado = number_format($resultado, 3); // Limita a 3 decimales
            return $resultado_formateado;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public function calcular_Bs($value_USD)
    {
        $this->dolar = $value_USD;
        // Acceder al primer elemento de la colección
        try {
            $resultado = $this->dolar * ($this->detalles->first()->dolar);
            $resultado_formateado = number_format($resultado, 3); // Limita a 3 decimales
            return $resultado_formateado;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public function sumatoria_total($valo1, $valo2)
    {
        try {
            $suma = $valo1 + $valo2;
            return $suma;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public function abrir($nomenclatura)
    {
        $this->open = true;
        $this->valor_nomenclatura = $nomenclatura;
        $this->detalles = inscripcion::select(
            'inscripcions.nomenclatura',
            'inscripcions.id as id',
            'inscripcions.monto_pagado_bs as monto_pagado_bs',
            'inscripcions.datos as datos',
            'inscripcions.participante_id as participante_id',
            'inscripcions.recorrido_id as recorrido_id',
            'inscripcions.grupo_id as grupo_id',
            'dolars.precio as dolar',
            'inscripcions.created_at as created_at',
            'participantes.cedula as cedula',
            'recorridos.nombre as recorrido',
            'grupos.cantidad as cantidad',
            'grupos.precio as precio'
        )
            ->join('dolars', 'inscripcions.dolar_id', '=', 'dolars.id')
            ->join('participantes', 'inscripcions.participante_id', '=', 'participantes.id')
            ->join('recorridos', 'inscripcions.recorrido_id', '=', 'recorridos.id')
            ->join('grupos', 'inscripcions.grupo_id', '=', 'grupos.id')
            ->where('inscripcions.nomenclatura', $nomenclatura)->get();
        if ($this->detalles->isEmpty()) {
            $this->detalles = [];
        }
    }



    public function render()
    {
        $reporte = inscripcion::select(
            DB::raw('count(inscripcions.nomenclatura) as cantidad'),
            'inscripcions.nomenclatura',
            DB::raw('MIN(inscripcions.id) as id'),
            DB::raw('MIN(inscripcions.monto_pagado_bs) as monto_pagado_bs'),
            DB::raw('MIN(inscripcions.datos) as datos'),
            DB::raw('MAX(inscripcions.participante_id) as participante_id'),
            DB::raw('MAX(inscripcions.recorrido_id) as recorrido_id'),
            DB::raw('MAX(inscripcions.grupo_id) as grupo_id'),
            DB::raw('MIN(inscripcions.created_at) as created_at'),
            DB::raw('MAX(participantes.cedula) as cedula'),
            DB::raw('MAX(recorridos.nombre) as recorrido'),
            DB::raw('MAX(grupos.precio) as precio')
        )
            ->join('participantes', 'inscripcions.participante_id', '=', 'participantes.id')
            ->join('recorridos', 'inscripcions.recorrido_id', '=', 'recorridos.id')
            ->join('grupos', 'inscripcions.grupo_id', '=', 'grupos.id')
            ->groupBy('inscripcions.nomenclatura')
            ->orderBy('inscripcions.nomenclatura', 'desc') // Cambia a nomenclatura
            ->paginate(4);

        return view('livewire.reportes.reporte-fondo', [
            'reporte' => $reporte,

        ]);
    }
}
