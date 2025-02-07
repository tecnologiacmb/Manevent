<?php

namespace App\Livewire;

use Livewire\Component;

class VistaInscripcion extends Component
{
    public $post_edit_id;
    public $post_update = [
        'nombre' => "",
        'apellido' => "",
        'cedula' => "",
        'telefono' => "",
        'correo' => "",
        'direccion' => "",
        'ciudad_id' => null,
        'estado_id' => null,
        'fecha_nacimiento' => "",
        'ciudades' => [],
    ];
    public $participantes = null;
    public $estados;
    public $ciudad;
    protected $listeners = ['delete'];

    public function render()
    {
        return view('livewire.vista-inscripcion');
    }
}
