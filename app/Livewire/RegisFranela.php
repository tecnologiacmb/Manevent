<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\prenda_category;
use App\Models\prenda_talla;

class RegisFranela extends Component
{
    public $create_categoria = [
        'nombre',
        'estado',
    ];
    public $create_talla = [
        'talla',
        'estado',
    ];

    public $talla;
    public $categoria;

    public function mount() {
        $this->talla=prenda_talla::all();
        $this->categoria=prenda_category::all();
    }

    public function render()
    {
        return view('livewire.regis-franela');
    }
}
