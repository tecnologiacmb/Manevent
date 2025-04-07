<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\inscripcion;
use App\Models\participante;
use App\Models\dolar;
use App\Models\evento;
use App\Models\grupo;
use App\Models\metodo_pago;
use App\Models\recorrido;


class ExportPDF extends Controller
{
    public function reportPDF($inscripcion, $dateFrom = null, $dateTo = null)
    {
        $from = Carbon::parse($dateFrom)->format('Y-m-d') . ' 00:00:00';
        $to = Carbon::parse($dateTo)->format('Y-m-d') . ' 23:59:59';
        $inscripcion = inscripcion::select(
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
            ->whereBetween('inscripcions.created_at', [$from, $to])->get();
        if ($inscripcion->isEmpty()) {
            $inscripcion = [];
        }
        /* $pdf = Pdf::loadView('pdf.reporte', compact('inscripcion', 'dateFrom', 'dateTo')); */
    }
}
