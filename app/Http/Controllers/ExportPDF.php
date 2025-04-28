<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Models\inscripcion;
use App\Models\participante;
use App\Models\dolar;
use App\Models\evento;
use App\Models\grupo;
use App\Models\metodo_pago;
use App\Models\recorrido;
use DateTime;
use App\Exports\ReporteExcel;
use App\Exports\ReporteGlobalExcel;

use Illuminate\Support\Facades\DB;

class ExportPDF extends Controller
{
    public $detalles = null;
    public $bolivares;
    public $dolar;
    public $total;
    public $value = '';

    public $eventoId;
    public $dateFrom;
    public $dateTo;

    public function index(Request $request)
    {
        $this->authorize('super-admin', inscripcion::class);

        try {
            return view('reportes/reporte_fondo',);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function reportPDF(Request $request, $dateFrom = '', $dateTo = '', $eventoId = '')
    {
        $dateFrom = $request->input('dateFrom', $dateFrom);
        $dateTo = $request->input('dateTo', $dateTo);
        $eventoId = $request->input('eventoId', $eventoId);
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->eventoId = $eventoId;

        $adjustedEndDate = date('Y-m-d', strtotime($dateTo . ' +1 day'));
        $detalles = inscripcion::select(
            'inscripcions.nomenclatura',
            'inscripcions.id as id',
            'inscripcions.monto_a_pagar_bs as monto_a_pagar_bs',
            'inscripcions.datos as datos',
            'inscripcions.participante_id as participante_id',
            'inscripcions.recorrido_id as recorrido_id',
            'inscripcions.grupo_id as grupo_id',
            'dolars.precio as dolar',
            'inscripcions.created_at as created_at',
            'participantes.cedula as cedula',
            'recorridos.nombre as recorrido',
            'grupos.cantidad as cantidad',
            'grupos.precio as precio',
            'eventos.nombre as evento',
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
            ->orderBy('inscripcions.nomenclatura', 'desc')
            ->get();

        if ($detalles->isEmpty()) {
            $detalles = [];
        }

        if (!empty($dateFrom) && !empty($dateTo)) {
            $dateFromFormatted = (new DateTime($dateFrom))->format('d/m/Y');
            $dateToFormatted = (new DateTime($dateTo))->format('d/m/Y');
            $pdf = Pdf::loadView('reportes.ReporteFondoPDF', compact('detalles', 'dateFromFormatted', 'dateToFormatted', 'eventoId'));
            return $pdf->stream('invoice.pdf');
        } else {
            $pdf = Pdf::loadView('reportes.ReporteFondoPDF', compact('detalles', 'eventoId'));
            return $pdf->stream('invoice.pdf');
        }
    }

    public function reportExcel(Request $request, $dateFrom = '', $dateTo = '', $eventoId = '')
    {
        $dateFrom = $request->input('dateFrom', $dateFrom);
        $dateTo = $request->input('dateTo', $dateTo);
        $eventoId = $request->input('eventoId', $eventoId);


        return Excel::download(new ReporteExcel($dateFrom, $dateTo, $eventoId), 'reporte.xlsx');
    }
    public function reportGlobalExcel(Request $request, $dateFrom = '', $dateTo = '', $eventoId = '')
    {
        $dateFrom = $request->input('dateFrom', $dateFrom);
        $dateTo = $request->input('dateTo', $dateTo);
        $eventoId = $request->input('eventoId', $eventoId);

        return Excel::download(new ReporteGlobalExcel($dateFrom, $dateTo, $eventoId), 'reporte.xlsx');
    }

    public function reportGlobalPDF(Request $request, $dateFrom = '', $dateTo = '', $eventoId = '')
    {
        // Ensure date format is correct
        $dateFrom = $request->input('dateFrom', $dateFrom);
        $dateTo = $request->input('dateTo', $dateTo);
        $eventoId = $request->input('eventoId', $eventoId);
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->eventoId = $eventoId;

        $adjustedEndDate = date('Y-m-d', strtotime($dateTo . ' +1 day'));
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
            ->orderBy('inscripcions.nomenclatura', 'desc')
            ->get();

        // Load PDF view
        if (!empty($dateFrom) && !empty($dateTo)) {
            $dateFromFormatted = (new DateTime($dateFrom))->format('d/m/Y');
            $dateToFormatted = (new DateTime($dateTo))->format('d/m/Y');
            $pdf = Pdf::loadView('reportes.ReporteGlobalPDF', compact('detalles', 'dateFromFormatted', 'dateToFormatted', 'eventoId'));
            return $pdf->stream('invoice.pdf'); // Change to download('invoice.pdf') if needed
        } else {
            $pdf = Pdf::loadView('reportes.ReporteGlobalPDF', compact('detalles', 'eventoId'));
            return $pdf->stream('invoice.pdf');
        }
    }
}
