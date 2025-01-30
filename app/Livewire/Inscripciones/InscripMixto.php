<?php

namespace App\Livewire\Inscripciones;

use App\Models\grupo;
use Livewire\Component;
use App\models\dolar;
use App\models\recorrido;
use Livewire\WithPagination;


class InscripMixto extends Component
{
    use WithPagination;
    public $grupos;
    public $dolars;
    public $open=false;
    public $recorridos;
    public $cantidad_carrera;
    public $cantidad_caminata;


    public function mount()
    {

        $this->grupos = grupo::where('estado', true)->get();
        $this->dolars = dolar::all();
        $this->recorridos = recorrido::select('recorridos.*' )->whereBetween('id',[1,2])->first();
        $this->cantidad_carrera;
        $this->cantidad_caminata;
    }
    public function crear()
    {
        $this->open = true;
    }
    public function calculo($num)
    {
        $total = 0;
        if ($this->dolars->last() == true) {
            $ultimoDolar = $this->dolars->last();

            $total = $num * $ultimoDolar->precio;

            return $total;
        } else {

            return $total;
        }
    }
    public function render()
    {
        return view('livewire.inscripciones.inscrip-mixto');
    }
}
