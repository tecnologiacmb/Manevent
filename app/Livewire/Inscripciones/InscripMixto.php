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
    public $open = false;
    public $recorridos;
    public $id;
    public $cantidad_carrera='';
    public $cantidad_caminata='';


    public function mount()
    {

        $this->grupos = grupo::where('estado', true)->get();
        $this->dolars = dolar::all();
        $this->recorridos = recorrido::select('recorridos.*')->whereBetween('id', [1, 2])->first();

    }
    public function crear($value)
    {
        $this->id = $value;
        $this->open = true;
    }
    public function enlace()
    {

        // Generar la URL para la vista en lugar del PDF
        /* $viewLink = route('mixto/inscripcion/{id}/{cantidad_carrera}/{cantidad_caminata}', ['id' => $this->id, 'cantidad_carrera' => $this->cantidad_carrera, 'cantidad_caminata' => $this->cantidad_caminata]); */

        $viewLink = route('mixto/inscripcion/{id}/{cantidad_carrera}/{cantidad_caminata}', ['id' => $this->id, 'cantidad_carrera' => $this->cantidad_carrera, 'cantidad_caminata' => $this->cantidad_caminata]);

        $this->cantidad_carrera='';
        $this->cantidad_caminata='';

        // Almacenar el enlace en la sesión, si es necesario
        session()->flash('view_link', $viewLink);

        // Redirigir a la vista en lugar del PDF
        return redirect()->to($viewLink);
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
        $this->cantidad_carrera='';
        $this->cantidad_caminata='';
        return view('livewire.inscripciones.inscrip-mixto');
    }
}
