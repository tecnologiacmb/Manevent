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

        'name' => "",
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
        $post =categoriaHabilitada ::create([

            'name' => $this->postCreate['name'],
            'edad_min' => $this->postCreate['edad_min'],
            'edad_max' => $this->postCreate['edad_max'],

        ]);


        $this->reset(['postCreate']);

    }
    public function render()
    {
        $categoria = categoriaHabilitada::orderBy('created_at', 'desc')->paginate(5);

        return view('livewire.administrar.admin-categoria', [
            'posts' => $categoria
        ]);
    }
}
