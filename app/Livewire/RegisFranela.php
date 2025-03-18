<?php

namespace App\Livewire;

use App\Models\evento;
use App\Models\prenda;
use Livewire\Component;
use App\Models\prenda_category;
use App\Models\prenda_talla;

class RegisFranela extends Component
{
    public $tallas= null;
    public $categorias= null;
    public $prendas = null;
    public $open = false;
    public $evento = null;

    public $create_prenda = [
        'evento_id',
        'prenda_category_id',
        'prenda_talla_id',
        'cantidad',
        'restadas',
        'sexo',
        'estado',
    ];

    public function mount()
    {
        $this->tallas = prenda_talla::all();
        $this->categorias = prenda_category::all();

        $this->prendas = prenda::select('prendas.*', 'prenda_tallas.id as prenda_talla_id', 'prenda_tallas.talla as prenda_talla', 'prenda_categories.id as prenda_categories_id', 'prenda_categories.nombre as prenda_categories_nombre')->join('prenda_tallas', 'prendas.prenda_talla_id', '=', 'prenda_tallas.id')->join('prenda_categories', 'prendas.prenda_category_id', '=', 'prenda_categories.id')->where('prendas.estado', true)->get();

        $this->evento = evento::select('id', 'nombre', 'fecha_evento')->where('estado', true)->orderBy('id', 'desc')->first();

        if (!is_null($this->evento)) {
            $this->create_prenda = [
                'evento_id' => $this->evento->id,
                'prenda_category_id' => null,
                'prenda_talla_id' => null,
                'cantidad' => null,
                'restadas' => null,
                'sexo' => null,
                'estado' => null,
            ];
        } else {
            $this->create_prenda = [
                'evento_id' => null,
                'prenda_category_id' => null,
                'prenda_talla_id' => null,
                'cantidad' => null,
                'sexo' => null,
                'estado' => null,
            ];
        }
    }
    public function crear()
    {
        $this->open = true;
    }
    public function select_sexo($value)
    {
        if ($value == 'Femenino') {
            $this->create_prenda['sexo'] = 'Femenino';
        } else if ($value == 'Masculino') {
            $this->create_prenda['sexo'] = 'Masculino';
        } else {
            $this->create_prenda['sexo']='';
        }
    }

    public function seve()
    {
        $prenda = prenda::create([
            'evento_id' => $this->create_prenda['evento_id'],
            'prenda_category_id' => $this->create_prenda['prenda_category_id'],
            'prenda_talla_id' => $this->create_prenda['prenda_talla_id'],
            'cantidad' => $this->create_prenda['cantidad'],
            'sexo' => $this->create_prenda['sexo'],
            'estado' => $this->create_prenda['estado'],
        ]);
        $this->create_prenda = [];

        $this->dispatch('alert');
    }
    public function render()
    {

        return view('livewire.regis-franela');
    }
}
