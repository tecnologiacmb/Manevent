<?php

namespace App\Livewire;

use App\Models\ciudad;
use App\Models\estado;
use App\Models\participante;
use Livewire\Component;
use Livewire\WithPagination;

class ListaUsuarios extends Component
{
    use WithPagination;
    public $estados;
    public $ciudad;

    public function mount()
    {
        $this->estados = estado::all();
        $this->ciudad = ciudad::all();
    }

    public function render()
    {
        $participantes = participante::select('participantes.*', 'estados.estado as estado_nombre', 'ciudads.ciudad as ciudad_nombre')
            ->join('ciudads', 'participantes.ciudad_id', '=', 'ciudads.id')
            ->join('estados', 'ciudads.estado_id', '=', 'estados.id')
            ->orderBy('participantes.id', 'desc')
            ->paginate(6);

        return view('livewire.lista-usuarios', ['user' => $participantes]);
    }
}
