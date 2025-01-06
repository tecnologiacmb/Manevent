<?php

namespace App\Livewire\Administrar;

use App\Models\dolar;
use App\Models\grupo;
use App\Models\recorrido;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
class AdminGrupo extends Component
{
    use WithPagination;
    public $grupos;
    public $dolars;
    public $recorridos;

    public $open = false;

    public $postCreate = [
        'recorrido_id' => "",
        'nombre' => "",
        'precio' => null,
        'cantidad' => "",
        'estado' => false,

    ];
    public function mount()
    {

        $this->grupos = grupo::all();
        $this->dolars = dolar::select('id', 'precio')->whereDate('created_at', Carbon::today())->latest()->first();
        if (!$this->dolars) {
            $this->dolars = dolar::latest()->first();
        }
        $this->postCreate['dolar_id'] = $this->dolars ? $this->dolars->id : null;
        $this->recorridos = recorrido::all();
    }

    public function agg()
    {
        $this->open = true;
    }

    public function calculo($num){
        $total = 0;
        $ultimoDolar = $this->dolars;

        $total = $num * $ultimoDolar->precio;

        return $total;
    }
    public function seve()
    {

        $posts = grupo::create([
            'recorrido_id' => $this->postCreate['recorrido_id'],
            'nombre' => $this->postCreate['nombre'],
            'precio' => $this->postCreate['precio'],
            'cantidad' => $this->postCreate['cantidad'],
            'estado' => $this->postCreate['estado'],

        ]);




        $this->reset(['postCreate']);
        $this->dispatch('alert');
        $this->open = false;
    }

    public function render()
    {
        $grupos = grupo::orderBy('id', 'desc')->paginate(5);
        return view('livewire.administrar.admin-grupo', [
            'posts' => $grupos
        ]);
    }
}
