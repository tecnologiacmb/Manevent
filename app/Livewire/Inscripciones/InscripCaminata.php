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

        $this->grupos = grupo::where('estado', true)->get();
        $this->dolars = dolar::all();
        $this->recorrido = recorrido::all();
    }
    public function calculo($num)
    {
        $total = 0;
        if ($this->dolars->last() == true) {
            $ultimoDolar = $this->dolars->last();

            $total = $num * $ultimoDolar->precio;

            return $total;
        } else {

            return $total="sin valor";
        }
    }

    public function render()
    {
        return view('livewire.Inscripciones.inscrip-caminata');
    }
}
