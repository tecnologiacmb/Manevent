<?php

namespace App\Livewire;

use App\Models\ciudad;
use App\Models\estado;
use App\Models\participante;
use Livewire\Component;

class ListaUsuarios extends Component
{
    public $participantes=null;
    public $estados;
    public $ciudad;
    public function mount() {
        $this->estados = estado::all();
        $this->ciudad = ciudad::all();

        $this->participantes=participante::select('participantes.*', 'estados.estado as estado_nombre','ciudads.ciudad as ciudad_nombre')->join('ciudads', 'participantes.ciudad_id', '=', 'ciudads.id')->join('estados', 'ciudads.estado_id', '=', 'estados.id')->get();

    }

    public function render()
    {
        return view('livewire.lista-usuarios');
    }
}
