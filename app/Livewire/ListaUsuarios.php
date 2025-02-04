<?php

namespace App\Livewire;

use App\Models\ciudad;
use App\Models\estado;
use App\Models\participante;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use PhpParser\Builder\Function_;

class ListaUsuarios extends Component
{
    public $participantes = null;
    public $estados;
    public $ciudad;



    public function mount()
    {
        $this->estados = estado::all();
        $this->ciudad = ciudad::all();

        $this->participantes = participante::select('participantes.*', 'estados.estado as estado_nombre', 'ciudads.estado_id as estado_id', 'ciudads.ciudad as ciudad_nombre')->join('ciudads', 'participantes.ciudad_id', '=', 'ciudads.id')->join('estados', 'ciudads.estado_id', '=', 'estados.id')->get();
    }

    /*  public function update()
    {
        $posts = participante::find($this->post_edit_id);
        $posts->update([
            'nombre' => $this->post_update['nombre'],
            'codigo' => $this->post_update['codigo'],
            'estado' => $this->post_update['estado'],

        ]);
        $this->reset(['post_update', 'post_edit_id', 'open_edit']);
        $this->dispatch('alert_update');
    } */

    public function render()
    {
        return view('livewire.lista-usuarios');
    }
}
