<?php

namespace App\Exports;

use App\Models\inscripcion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

use Illuminate\Contracts\View\View;
use DateTime;


class ReporteExcel implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $dateFrom = '';
    public $dateTo = '';
    public $eventoId = '';

    public function __construct($dateFrom = '', $dateTo = '', $eventoId = '')
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->eventoId = $eventoId;
    }

    public function View(): View
    {
        $dateFrom = $this->dateFrom;
        $dateTo = $this->dateTo;
        $eventoId = $this->eventoId;
        $adjustedEndDate = date('Y-m-d', strtotime($dateTo . ' +1 day'));
        // Validate the input dates

        $detalles = inscripcion::select(
            'inscripcions.nomenclatura',
            'inscripcions.id as id',
            'inscripcions.monto_a_pagar_bs as monto_a_pagar_bs',
            'inscripcions.datos as datos',
            'inscripcions.participante_id as participante_id',
            'inscripcions.recorrido_id as recorrido_id',
            'inscripcions.grupo_id as grupo_id',
            'eventos.nombre as evento',
            'dolars.precio as dolar',
            'inscripcions.created_at as created_at',
            'participantes.cedula as cedula',
            'recorridos.nombre as recorrido',
            'grupos.cantidad as cantidad',
            'grupos.precio as precio'
        )
            ->join('eventos', 'inscripcions.evento_id', '=', 'eventos.id')
            ->join('dolars', 'inscripcions.dolar_id', '=', 'dolars.id')
            ->join('participantes', 'inscripcions.participante_id', '=', 'participantes.id')
            ->join('recorridos', 'inscripcions.recorrido_id', '=', 'recorridos.id')
            ->join('grupos', 'inscripcions.grupo_id', '=', 'grupos.id')
            ->when($this->dateFrom && $this->dateTo, function ($value) use ($adjustedEndDate) {
                $value->whereBetween('inscripcions.created_at', [$this->dateFrom, $adjustedEndDate]);
            })->when($this->eventoId, function ($query) { // Add this when clause
                $query->where('inscripcions.evento_id', $this->eventoId);
            })
            ->get();
        if ($detalles->isEmpty()) {
            $detalles = [];
        }
        if (!empty($dateFrom) && !empty($dateTo)) {
            $dateFromFormatted = (new DateTime($dateFrom))->format('d/m/Y');
            $dateToFormatted = (new DateTime($dateTo))->format('d/m/Y');
            return view('reportes.ReporteExcel', compact('detalles', 'dateFromFormatted', 'dateToFormatted', 'eventoId'));
        } else {
            return view('reportes.ReporteExcel', compact('detalles', 'eventoId'));
        }
    }
}
