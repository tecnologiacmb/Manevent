<?php

namespace App\Livewire;

use App\Models\ciudad;
use App\Models\estado;
use App\Models\evento;
use App\Models\participante;
use App\Models\categoriaHabilitada;
use App\Models\inscripcion;
use Livewire\Component;
use Carbon\Carbon;

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
    public $post_update_categoria = [
        'categoria_habilitada_id' => null,
    ];
    public $participantes = null;
    public $estados;
    public $ciudad;
    public $categoria_habilitada;
    public $evento;
    public $fecha_evento;

    protected $listeners = ['delete'];

    public function mount($id = null)
    {
        if (!is_null($id)) {
            $this->estados = estado::all();
            $this->evento = evento::select('id', 'nombre', 'fecha_evento')->where('estado', true)->orderBy('id', 'desc')->first();
            $this->categoria_habilitada = categoriaHabilitada::all();
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

    public function subtractYears()
    {
        $this->fecha_evento = Carbon::parse($this->evento->fecha_evento)->subYears(15)->format('Y-m-d');
    }

    public function edad($fecha_nacimiento)
    {
        $fecha_nacimiento = Carbon::parse($fecha_nacimiento)->format('Y-m-d');
        $ahora = Carbon::parse($this->evento->fecha_evento)->format('Y-m-d');
        $edad = Carbon::parse($ahora)->diffInYears(Carbon::parse($fecha_nacimiento));
        foreach ($this->categoria_habilitada as $categoria_habilitadas) {
            if ($edad >= $categoria_habilitadas->edad_min && $edad <= $categoria_habilitadas->edad_max) {
                return $categoria_habilitadas->id;
            }
        }
        return null;
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
        $this->post_update['fecha_nacimiento'] = Carbon::parse($this->post_update['fecha_nacimiento'])->format('Y-m-d');
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
        $categoria_id = $this->edad($posts->fecha_nacimiento);
        $this->post_update_categoria['categoria_habilitada_id'] = $categoria_id;
        $inscripcion = inscripcion::where('participante_id', $posts->id)->first();
        $inscripcion->update([
            'categoria_habilitada_id' => $this->post_update_categoria['categoria_habilitada_id']
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
