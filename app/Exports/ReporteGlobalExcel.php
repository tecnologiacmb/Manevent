<?php

namespace App\Exports;

use App\Models\inscripcion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

use Illuminate\Contracts\View\View;
use DateTime;


class ReporteGlobalExcel implements FromView
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
            DB::raw('count(inscripcions.nomenclatura) as cantidad'),
            'inscripcions.nomenclatura',
            DB::raw('MIN(inscripcions.id) as id'),
            DB::raw('MIN(inscripcions.monto_a_pagar_bs) as monto_a_pagar_bs'),
            DB::raw('MIN(inscripcions.datos) as datos'),
            DB::raw('MAX(inscripcions.participante_id) as participante_id'),
            DB::raw('MAX(inscripcions.recorrido_id) as recorrido_id'),
            DB::raw('MAX(inscripcions.grupo_id) as grupo_id'),
            DB::raw('MIN(inscripcions.created_at) as created_at'),
            DB::raw('MAX(participantes.cedula) as cedula'),
            DB::raw('MAX(recorridos.nombre) as recorrido'),
            DB::raw('MAX(grupos.precio) as precio'),
            DB::raw('MAX(dolars.precio) as dolar'),
            DB::raw('MIN(eventos.nombre) as evento'),
        )
            ->join('eventos', 'inscripcions.evento_id', '=', 'eventos.id')
            ->join('participantes', 'inscripcions.participante_id', '=', 'participantes.id')
            ->join('recorridos', 'inscripcions.recorrido_id', '=', 'recorridos.id')
            ->join('grupos', 'inscripcions.grupo_id', '=', 'grupos.id')
            ->join('dolars', 'inscripcions.dolar_id', '=', 'dolars.id')
            ->when($this->dateFrom && $this->dateTo, function ($value) use ($adjustedEndDate) {
                $value->whereBetween('inscripcions.created_at', [$this->dateFrom, $adjustedEndDate]);
            })->when($this->eventoId, function ($query) { // Add this when clause
                $query->where('inscripcions.evento_id', $this->eventoId);
            })
            ->groupBy('inscripcions.nomenclatura')

            ->get();
        if ($detalles->isEmpty()) {
            $detalles = [];
        }
        if (!empty($dateFrom) && !empty($dateTo)) {
            $dateFromFormatted = (new DateTime($dateFrom))->format('d/m/Y');
            $dateToFormatted = (new DateTime($dateTo))->format('d/m/Y');
            return view('reportes.ReporteGlobalExcel', compact('detalles', 'dateFromFormatted', 'dateToFormatted', 'eventoId'));
        } else {
            return view('reportes.ReporteGlobalExcel', compact('detalles', 'eventoId'));
        }

        # code...

    }
}
