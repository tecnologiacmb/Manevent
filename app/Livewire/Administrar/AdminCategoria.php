<?php

namespace App\Livewire\Administrar;

use App\Models\categoriaHabilitada;
use Livewire\Component;
use Livewire\WithPagination;

class AdminCategoria extends Component
{
    use WithPagination;
    public $categoria;
    public $open;

    public $postCreate = [

        'nombre' => "",
        'edad_min' => "",
        'edad_max' => "",

    ];

    public function mount()
    {
        $this->categoria = categoriaHabilitada::all();
    }

    public function agg()
    {
        $this->open = true;
    }
    public function save()
    {
        $post = categoriaHabilitada::create([

            'nombre' => $this->postCreate['nombre'],
            'edad_min' => $this->postCreate['edad_min'],
            'edad_max' => $this->postCreate['edad_max'],

        ]);


        $this->reset(['postCreate']);
        $this->dispatch('alert');
        $this->open = false;
    }
    public function render()
    {
        $categoria = categoriaHabilitada::orderBy('created_at', 'desc')->paginate(5);

        return view('livewire.administrar.admin-categoria', [
            'posts' => $categoria
        ]);
    }
}
