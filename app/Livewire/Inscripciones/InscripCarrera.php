<?php

namespace App\Livewire\Inscripciones;
use App\Models\grupo;
use Livewire\Component;
use App\models\dolar;
use App\models\recorrido;
use Livewire\WithPagination;
class InscripCarrera extends Component
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
        return view('livewire.inscripciones.inscrip-carrera');
    }
}
