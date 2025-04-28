<?php

namespace App\Livewire\Reportes;

use App\Models\evento;
use App\Models\inscripcion;
use App\Models\dolar;
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

    public $GenerarReporte = '';
    public $value = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $valor = '';
    public $eventos;
    public $eventoId;
    public $totalMontoPagado;
    public $dolars;


    public function mount()
    {
        $this->eventos = evento::all();
        $this->calcularTotalMontoPagado();

        $this->dolars = dolar::select('id', 'precio')->whereDate('created_at', Carbon::today())->latest()->first();
        if (!$this->dolars) {
            $this->dolars = dolar::latest()->first();
        }
    }
    public function generateDetailedReport()
    {
        $this->valor = '';

        if (!empty($this->dateFrom) && !empty($this->dateTo) && !empty($this->eventoId)) {

            $pdfLink = route('reportes.ReporteFondoPDF.detalle', ['dateFrom' => $this->dateFrom, 'dateTo' => $this->dateTo,  'eventoId' => $this->eventoId]);
            // Limpiar el buscador
            $this->dateFrom = '';
            $this->dateTo = '';
            $this->eventoId = '';
        } else if (!empty($this->dateFrom) && !empty($this->dateTo)) {
            $pdfLink = route('reportes.ReporteFondoPDF.detalle', ['dateFrom' => $this->dateFrom, 'dateTo' => $this->dateTo]);
            // Limpiar el buscador
            $this->dateFrom = '';
            $this->dateTo = '';
        } else if (!empty($this->eventoId)) {
            $pdfLink = route('reportes.ReporteFondoPDF.detalle', ['eventoId' => $this->eventoId]);
            // Limpiar el buscador
            $this->eventoId = '';
        } else {

            $pdfLink = route('reportes.ReporteFondoPDF.detalle');
        }
        // Usar 'session()->flash' para almacenar el enlace PDF temporalmente (si es necesario)
        session()->flash('pdf_link', $pdfLink);

        // Puedes redirigir a la ruta del PDF o hacer algún otro proceso aquí
        return redirect()->to($pdfLink);
    }
    public function generateReportGlobal()
    {
        $this->valor = '';

        // Lógica para generar el PDF. Por ejemplo, puedes redirigir a la ruta:
        if (!empty($this->dateFrom) && !empty($this->dateTo) && !empty($this->eventoId)) {

            $pdfLink = route('reportes.ReporteGlobalPDF.reporte_global', ['dateFrom' => $this->dateFrom, 'dateTo' => $this->dateTo, 'eventoId' => $this->eventoId]);
            $this->eventoId = '';
            $this->dateFrom = '';
            $this->dateTo = '';
        } else if (!empty($this->dateFrom) && !empty($this->dateTo)) {
            $pdfLink = route('reportes.ReporteGlobalPDF.reporte_global', ['dateFrom' => $this->dateFrom, 'dateTo' => $this->dateTo]);
            $this->dateFrom = '';
            $this->dateTo = '';
        } else if (!empty($this->eventoId)) {

            $pdfLink = route('reportes.ReporteGlobalPDF.reporte_global', ['eventoId' => $this->eventoId]);
            $this->eventoId = '';
        } else {
            $pdfLink = route('reportes.ReporteGlobalPDF.reporte_global');
        }
        // Usar 'session()->flash' para almacenar el enlace PDF temporalmente (si es necesario)
        session()->flash('pdf_link', $pdfLink);

        // Puedes redirigir a la ruta del PDF o hacer algún otro proceso aquí
        return redirect()->to($pdfLink);
    }

    public function generateDetailedReportExcel()
    {
        if (!empty($this->dateFrom) && !empty($this->dateTo) && !empty($this->eventoId)) {
            $excelLink = route('reportes.ReporteExcel.Excel', ['dateFrom' => $this->dateFrom, 'dateTo' => $this->dateTo, 'eventoId' => $this->eventoId]);
            session()->flash('excel_link', $excelLink);


            // Puedes redirigir a la ruta del Excel o hacer algún otro proceso aquí
            return redirect()->to($excelLink);
        } else if (!empty($this->dateFrom) && !empty($this->dateTo)) {
            $excelLink = route('reportes.ReporteExcel.Excel', ['dateFrom' => $this->dateFrom, 'dateTo' => $this->dateTo]);
            session()->flash('excel_link', $excelLink);


            return redirect()->to($excelLink);
        } else if (!empty($this->eventoId)) {
            $excelLink = route('reportes.ReporteExcel.Excel', ['eventoId' => $this->eventoId]);
            session()->flash('excel_link', $excelLink);
            // Puedes redirigir a la ruta del Excel o hacer algún otro proceso aquí

            return redirect()->to($excelLink);
        } else {
            $excelLink = route('reportes.ReporteExcel.Excel');
            session()->flash('excel_link', $excelLink);
            return redirect()->to($excelLink);
        }
    }
    public function generateGlobalReportExcel()
    {
        if (!empty($this->dateFrom) && !empty($this->dateTo) && !empty($this->eventoId)) {
            $excelLink = route('reportes.ReporteGlobalExcel.ExcelGlobal', ['dateFrom' => $this->dateFrom, 'dateTo' => $this->dateTo, 'eventoId' => $this->eventoId]);
            session()->flash('excel_link', $excelLink);

            // Puedes redirigir a la ruta del Excel o hacer algún otro proceso aquí
            return redirect()->to($excelLink);
        } else if (!empty($this->dateFrom) && !empty($this->dateTo)) {
            $excelLink = route('reportes.ReporteGlobalExcel.ExcelGlobal', ['dateFrom' => $this->dateFrom, 'dateTo' => $this->dateTo]);
            session()->flash('excel_link', $excelLink);


            return redirect()->to($excelLink);
        } else if (!empty($this->eventoId)) {
            $excelLink = route('reportes.ReporteGlobalExcel.ExcelGlobal', ['eventoId' => $this->eventoId]);
            session()->flash('excel_link', $excelLink);
            // Puedes redirigir a la ruta del Excel o hacer algún otro proceso aquí

            return redirect()->to($excelLink);
        } else {
            $excelLink = route('reportes.ReporteGlobalExcel.ExcelGlobal');
            session()->flash('excel_link', $excelLink);
            return redirect()->to($excelLink);
        }
    }

    public function updateReporte($valor)
    {

        if ($valor == "reporteDetallado") {
            $this->GenerarReporte = "reporteDetallado";
        } else if ($valor == "reporteGlobal") {
            $this->GenerarReporte = "reporteGlobal";
        } else {
            $this->GenerarReporte = '';
        }
    }
    public function calcularTotalMontoPagado()
    {
        $adjustedEndDate = date('Y-m-d', strtotime($this->dateTo . ' +1 day'));

        $this->totalMontoPagado = inscripcion::select(DB::raw('count(inscripcions.nomenclatura) as cantidad'),
            'inscripcions.nomenclatura',
        DB::raw('MIN(inscripcions.monto_a_pagar_bs) as monto_a_pagar_bs'),
        )->join('eventos', 'inscripcions.evento_id', '=', 'eventos.id')->when($this->eventoId, function ($query) { // Add this when clause
            $query->where('inscripcions.evento_id', $this->eventoId);
        })->when($this->dateFrom && $this->dateTo, function ($value) use ($adjustedEndDate) {
            $value->whereBetween('inscripcions.created_at', [$this->dateFrom, $adjustedEndDate]);
        })->groupBy('inscripcions.nomenclatura')->get()->sum('monto_a_pagar_bs');
    }
    public function calculo($totalMontoPagado)
    {
        if (isset($this->dolars)) {
            $ultimoDolar = $this->dolars->latest()->first();
            if (isset($ultimoDolar)) {
                $this->total = $totalMontoPagado / $ultimoDolar->precio;
                return $this->total;
            }
        } else {
            $this->total = 0;
            return $this->total;
        }
    }

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
    public function abrir($nomenclatura = '')
    {
        $this->open = true;
        $this->valor_nomenclatura = $nomenclatura;
        $this->detalles = inscripcion::select(
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
            'grupos.precio as precio'
        )
            ->join('dolars', 'inscripcions.dolar_id', '=', 'dolars.id')
            ->join('participantes', 'inscripcions.participante_id', '=', 'participantes.id')
            ->join('recorridos', 'inscripcions.recorrido_id', '=', 'recorridos.id')
            ->join('grupos', 'inscripcions.grupo_id', '=', 'grupos.id')
            ->when($this->valor_nomenclatura, function ($query) {
                $query->where('inscripcions.nomenclatura', '=', $this->valor_nomenclatura);
            })
            ->get();

        if ($this->detalles->isEmpty()) {
            $this->detalles = [];
        }
    }
    public function render()
    {
        $this->mount();
        $adjustedEndDate = date('Y-m-d', strtotime($this->dateTo . ' +1 day'));

        $reporte = inscripcion::select(
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
            DB::raw('MAX(dolars.precio) as dolar')

        )
            ->join('participantes', 'inscripcions.participante_id', '=', 'participantes.id')
            ->join('recorridos', 'inscripcions.recorrido_id', '=', 'recorridos.id')
            ->join('grupos', 'inscripcions.grupo_id', '=', 'grupos.id')
            ->join('dolars', 'inscripcions.dolar_id', '=', 'dolars.id')
            ->where(function ($value) {
                $value->where('inscripcions.nomenclatura', 'like', '%' . $this->value . '%');
            })
            ->when($this->dateFrom && $this->dateTo, function ($value) use ($adjustedEndDate) {
                $value->whereBetween('inscripcions.created_at', [$this->dateFrom, $adjustedEndDate]);
            })->when($this->eventoId, function ($query) { // Add this when clause
                $query->where('inscripcions.evento_id', $this->eventoId);
            })
            ->groupBy('inscripcions.nomenclatura')
            // Cambia a nomenclatura
            ->paginate(4);

        return view('livewire.reportes.reporte-fondo', [
            'reporte' => $reporte,

        ]);
    }
}
