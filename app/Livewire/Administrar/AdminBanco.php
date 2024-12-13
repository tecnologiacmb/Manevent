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
        'name' =>null,
        'codigo' => null,
        'status' => false,

    ];

    public function agg()
    {
        $this->open = true;
    }
    public function seve()
    {

        $posts = banco::create([
            'name' => $this->postCreate['name'],
            'codigo' => $this->postCreate['codigo'],
            'status' => $this->postCreate['status'],

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
        $nameBanco = banco::orderBy('name', 'desc')->paginate(5);

        return view('livewire.administrar.admin-banco', [
            'posts' => $nameBanco

        ]);
    }
}
