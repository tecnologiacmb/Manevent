<?php

namespace App\Livewire\Inscripciones;
use App\models\dolar;
use App\models\grupo;
use App\models\recorrido;

use Livewire\Component;
use Livewire\WithPagination;
class InscripCaminata extends Component
{
    use WithPagination;
    public $grupos;
    public $dolars;
    public $recorrido;
    public function mount()
    {

        $this->grupos = grupo::where('status',true)->get();
        $this->dolars = dolar::all();
        $this->recorrido = recorrido::all();

    }
    public function calculo($num){
        $total = 0;
        $ultimoDolar = $this->dolars->last();

        $total = $num * $ultimoDolar->valor;

        return $total;
    }

    public function render()
    {
        return view('livewire.Inscripciones.inscrip-caminata');

    }
}
