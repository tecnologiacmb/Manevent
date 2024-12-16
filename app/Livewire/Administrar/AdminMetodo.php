<?php

namespace App\Livewire\Administrar;

use Livewire\Component;
use App\Models\metodo_pago;
use App\Models\banco;
use App\Models\tipo_pago;
use Livewire\WithPagination;

class AdminMetodo extends Component
{
    use WithPagination;

    public $nameMetodo;
    public $banco;
    public $tipo_pago;
    public $metodo = null;

    public $open = false;
    public $postCreate = [
        'tipo_pago_id' => "",
        'banco_id' => "",
        'n°_cuenta' => null,
        'cedula' => null,
        'telefono' => null,
        'propietario' => null,
        'ABA' => null,
        'SWIT' => null,
        'correo' => null,
        'estado' => false,
    ];

    public function mount()
    {
        $this->nameMetodo = metodo_pago::all();
        $this->banco = banco::all();
        $this->tipo_pago = tipo_pago::all();
    }


    public function changeEvent($value)

    {

        $this->metodo = $value;
    }
    public function agg()
    {
        $this->open = true;
    }

    public function seve()
    {
        $post = metodo_pago::create([
            'tipo_pago_id' => $this->postCreate['tipo_pago_id'],
            'banco_id' => $this->postCreate['banco_id'],
            'n°_cuenta' => $this->postCreate['n°_cuenta'],
            'cedula' => $this->postCreate['cedula'],
            'telefono' => $this->postCreate['telefono'],
            'propietario' => $this->postCreate['propietario'],
            'ABA' => $this->postCreate['ABA'],
            'SWIT' => $this->postCreate['SWIT'],
            'correo' => $this->postCreate['correo'],
            'estado' => $this->postCreate['estado'],
        ]);

        $this->reset(['postCreate']);
        $this->nameMetodo = metodo_pago::all();
    }

    public function render()
    {
        $nameMetodo = metodo_pago::orderBy('created_at', 'desc')->paginate(5);
        return view('livewire.administrar.admin-metodo', [
            'posts' => $nameMetodo
        ]);
    }
}
