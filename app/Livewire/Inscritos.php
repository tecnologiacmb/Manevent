<?php

namespace App\Livewire;

use App\Models\evento;
use App\Models\inscripcion;
use Livewire\Component;
use Livewire\WithPagination;

class Inscritos extends Component
{
    use WithPagination;

    public $inscripcions;
    public $estados;
    public $ciudad;
    public $query;
    public $startDate;
    public $endDate;
    public $eventos;
    public $eventoId;
    public $cantidad_inscripcion;


    public function mount()
    {
        $this->eventos = evento::all();
    }
    public function limpiar()
    {
        $this->startDate = '';
        $this->endDate = '';
        $this->query = '';
    }
    // Add this line

    public function calcularInscripcion()
    {
        $this->cantidad_inscripcion = inscripcion::join('eventos', 'inscripcions.evento_id', '=', 'eventos.id')->when($this->eventoId, function ($query) { // Add this when clause
            $query->where('inscripcions.evento_id', $this->eventoId);
        })->count('inscripcions.id');
    }
    public function render()
    {
        $this->calcularInscripcion();

        $adjustedEndDate = date('Y-m-d', strtotime($this->endDate . ' +1 day'));

        $inscripcions = inscripcion::select(
            'inscripcions.*',
            'grupos.precio as precio',
            'participantes.cedula as cedula',
            'recorridos.nombre as nombre_recorrido',
            'mesas.nombre as mesa_nombre',
            'numeros.numero as numero_competidor' // Include the number in the select
        )
            ->join('participantes', 'participantes.id', '=', 'inscripcions.participante_id')
            ->join('grupos', 'grupos.id', '=', 'inscripcions.grupo_id')
            ->join('recorridos', 'recorridos.id', '=', 'inscripcions.recorrido_id')
            ->join('mesas', 'mesas.id', '=', 'inscripcions.mesa_id')
            ->join('numeros', 'inscripcions.numero_id', '=', 'numeros.id')
            ->join('eventos', 'inscripcions.evento_id', '=', 'eventos.id')
            ->where(function ($query) {
                $query->orWhere('participantes.cedula', 'like', '%' . $this->query . '%')
                    ->orWhere('inscripcions.nomenclatura', 'like', '%' . $this->query . '%')
                    ->orWhere('inscripcions.ip', 'like', '%' . $this->query . '%')
                    ->orWhere('mesas.nombre', 'like', '%' . $this->query . '%')
                    ->orWhere('recorridos.nombre', 'like', '%' . $this->query . '%');
            })
            ->when($this->startDate && $this->endDate, function ($query) use ($adjustedEndDate) {
                $query->whereBetween('inscripcions.created_at', [$this->startDate, $adjustedEndDate]);
            })
            ->when($this->eventoId, function ($query) { // Add this when clause
                $query->where('inscripcions.evento_id', $this->eventoId);
            })
            ->orderBy('inscripcions.id', 'desc')
            ->paginate(6);



        return view('livewire.inscritos', ['inscripciones' => $inscripcions,]);
    }
}
