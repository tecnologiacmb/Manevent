<?php

namespace App\Livewire\Administrar;

use App\Models\banco;
use Livewire\Component;
use Livewire\WithPagination;


class AdminBanco extends Component
{
    use WithPagination;

    public $nameBanco;
    public $open = false;
    public $postCreate = [
        'nombre' => null,
        'codigo' => null,
        'estado' => false,

    ];

    public function agg()
    {
        $this->open = true;
    }
    public function seve()
    {

        $posts = banco::create([
            'nombre' => $this->postCreate['nombre'],
            'codigo' => $this->postCreate['codigo'],
            'estado' => $this->postCreate['estado'],

        ]);

        $this->reset(['postCreate']);
        $this->nameBanco = banco::all();
    }

    public function mount()
    {
        $this->nameBanco = banco::all();
    }
    public function render()
    {
        $nameBanco = banco::orderBy('nombre', 'desc')->paginate(9);

        return view('livewire.administrar.admin-banco', [
            'posts' => $nameBanco

        ]);
    }
}
