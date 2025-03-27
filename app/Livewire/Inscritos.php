<?php

namespace App\Livewire;

use App\Models\inscripcion;
use App\Models\prenda;
use Livewire\Component;

class Inscritos extends Component
{
    public $inscripcions;

    public function mount()
    {

    }
    public function render()
    {
        $inscripcions = inscripcion::select('inscripcions.*', 'grupos.precio as precio', 'participantes.cedula as cedula', 'recorridos.nombre as nombre_recorrido', 'mesas.nombre as mesa_nombre')->join('participantes', 'participantes.id', '=', 'inscripcions.participante_id')->join('grupos', 'grupos.id', '=', 'inscripcions.grupo_id')->join('recorridos', 'recorridos.id', '=', 'inscripcions.recorrido_id')->join('mesas', 'mesas.id', '=', 'inscripcions.mesa_id')->orderBy('inscripcions.id', 'desc')
        ->paginate(6);
        return view('livewire.inscritos',['inscripciones'=>$inscripcions]);
    }
}
