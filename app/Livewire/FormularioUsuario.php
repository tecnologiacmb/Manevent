<?php

namespace App\Livewire;

use App\Models\ciudad;
use App\Models\estado;
use App\Models\participante;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FormularioUsuario extends Component
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

    public function mount($id = null)
    {
        if (!is_null($id)) {
            $this->estados = estado::all();


            $this->post_edit_id = $id;
            $post = participante::find($this->post_edit_id);
            $this->post_update["nombre"] = $post->nombre;
            $this->post_update["apellido"] = $post->apellido;
            $this->post_update["cedula"] = $post->cedula;
            $this->post_update["telefono"] = $post->telefono;
            $this->post_update["correo"] = $post->correo;
            $this->post_update["direccion"] = $post->direccion;
            $this->post_update["fecha_nacimiento"] = $post->fecha_nacimiento;

            $ciudad = ciudad::find($post->ciudad_id);
            if ($ciudad) {
                $this->post_update["estado_id"] = $ciudad->estado_id;
                $this->post_update['ciudades'] = ciudad::where('estado_id', $ciudad->estado_id)->get();
                $this->post_update["ciudad_id"] = $ciudad->id;
            }
        }
    }
    public function updatedPostUpdate($value, $name)
    {
        $parts = explode('.', $name);
        $field = $parts[0];
        if ($field === 'estado_id') {
            $this->post_update['ciudades'] = ciudad::where('estado_id', $value)->get();
            $this->post_update['ciudad_id'] = null;
        }
    }
    public function update()
    {
        $posts = participante::find($this->post_edit_id);
        $posts->update([
            'cedula' => $this->post_update['cedula'],
            'nombre' => $this->post_update['nombre'],
            'apellido' => $this->post_update['apellido'],
            'correo' => $this->post_update['correo'],
            'direccion' => $this->post_update['direccion'],
            'telefono' => $this->post_update['telefono'],
            'fecha_nacimiento' => $this->post_update['fecha_nacimiento'],
            'ciudad_id' => $this->post_update['ciudad_id'],
        ]);
        $this->dispatch('alert_update');
    }
    public function confirm_delete($delete_id)
    {
        $this->dispatch('alert_delete', $delete_id);
    }
    public function delete($delete_id)
    {
        $post = participante::find($delete_id);
        $post->delete();
    }
    public function render()
    {
        return view('livewire.formulario-usuario');
    }
}
