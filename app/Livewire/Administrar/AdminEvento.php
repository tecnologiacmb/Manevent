<?php

namespace App\Livewire\Administrar;
use App\Models\recorrido;
use App\Models\evento;

use Livewire\Component;

class AdminEvento extends Component
{

    public $recorrido;
    public $open=false;
    public $evento;
    public $post_create=[

        'name',
        'inicio',
        'finalizacion',
        'lugar',
        'fecha_evento',
        'status',

    ];

    public function mount(){

        $this->evento = evento::all();
        $this->recorrido = recorrido::all();

    }

    public function agg(){

        $this->open = true;
    }

    public function seve(){
        $post=evento::create([

            'name' => $this->post_create['name'],
            'inicio' => $this->post_create['inicio'],
            'finalizacion' => $this->post_create['finalizacion'],
            'lugar' => $this->post_create['lugar'],
            'fecha_evento' => $this->post_create['fecha_evento'],
            'status' => $this->post_create['status'],

        ]);
        $this->reset(['post_create']);
        $this->evento = evento::all();
    }

    public function render(){

        return view('livewire.administrar.admin-evento');
    }
}
