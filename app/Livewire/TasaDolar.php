<?php

namespace App\Livewire;

use App\models\dolar;
use Livewire\Component;
use Livewire\WithPagination;

class TasaDolar extends Component
{
    use WithPagination;
    public $dolars;


    public $postCreate = [

        'valor' => null,

    ];
    public function save()
    {
        $post = dolar::create([

            'valor' => $this->postCreate['valor'],

        ]);


        $this->reset(['postCreate']);
    }
    public function mount()
    {
        $this->dolars = dolar::all();
    }

    public function render()
    {
        $dolars = dolar::orderBy('created_at', 'desc')->paginate(5);

        return view('livewire.tasa-dolar', [
            'posts' => $dolars
        ]);
    }
}
