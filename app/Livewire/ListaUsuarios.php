<?php

namespace App\Livewire;

use App\Models\ciudad;
use App\Models\estado;
use App\Models\participante;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ListaUsuarios extends Component
{
    use WithPagination;
    public $estados;
    public $ciudad;
    public $query = '';
    public $selectedDate = '';

    public $startDate;
    public $endDate;
    public $genero;

    public function mount()
    {
        $this->estados = estado::all();
        $this->ciudad = ciudad::all();
    }
    public function limpiar()
    {
        $this->genero = '';
        $this->startDate = '';
        $this->endDate = '';
    }

    public function render()
    {
        $adjustedEndDate = date('Y-m-d', strtotime($this->endDate . ' +1 day'));

        $participantes = participante::select('participantes.*', 'estados.estado as estado_nombre', 'ciudads.ciudad as ciudad_nombre', 'generos.genero as genero')
            ->join('ciudads', 'participantes.ciudad_id', '=', 'ciudads.id')
            ->join('estados', 'ciudads.estado_id', '=', 'estados.id')
            ->join('generos', 'participantes.genero_id', '=', 'generos.id')
            ->where(function ($query) {
                $query->where('participantes.nombre', 'like', '%' . $this->query . '%')
                    ->orWhere('participantes.apellido', 'like', '%' . $this->query . '%')
                    ->orWhere('cedula', 'like', '%' . $this->query . '%')
                    ->orWhere('estados.estado', 'like', '%' . $this->query . '%') // Especificar la tabla para evitar ambigüedad
                    ->orWhere('ciudads.ciudad', 'like', '%' . $this->query . '%');
            })
            ->when($this->startDate && $this->endDate, function ($query) use ($adjustedEndDate) {
                $query->whereBetween('participantes.created_at', [$this->startDate, $adjustedEndDate])
                    ->orWhereBetween('participantes.fecha_nacimiento', [$this->startDate, $adjustedEndDate]);
            })
            ->when($this->genero, function ($query) {
                $query->where('generos.id', $this->genero); // Especificar tabla para el género
            })
            ->orderBy('participantes.id', 'desc')
            ->paginate(6);

        return view('livewire.lista-usuarios', ['user' => $participantes]);
    }
}
