<?php

namespace App\Livewire\Administrar;

use App\Models\recorrido;
use App\Models\evento;

use Livewire\Component;

class AdminEvento extends Component
{

    public $recorrido;
    public $open = false;
    public $evento;
    public $post_create = [

        'nombre',
        'fecha_inicio',
        'fecha_finalizacion',
        'lugar_evento',
        'fecha_evento',
        'estado',

    ];

    public function mount()
    {

        $this->evento = evento::all();
        $this->recorrido = recorrido::all();
    }

    public function agg()
    {

        $this->open = true;
    }

    public function seve()
    {
        $post = evento::create([

            'nombre' => $this->post_create['nombre'],
            'fecha_inicio' => $this->post_create['fecha_inicio'],
            'fecha_finalizacion' => $this->post_create['fecha_finalizacion'],
            'lugar_evento' => $this->post_create['lugar_evento'],
            'fecha_evento' => $this->post_create['fecha_evento'],
            'estado' => $this->post_create['estado'],

        ]);
        $this->reset(['post_create']);
        $this->dispatch('alert');
        $this->open = false;
    }

    public function render()
    {

        return view('livewire.administrar.admin-evento');
    }
}
