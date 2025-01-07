<?php

namespace App\Livewire\Administrar;


use App\Models\evento;

use Livewire\Component;


class AdminEvento extends Component
{
    public $recorrido;
    public $open = false;
    public $open_edit = false;
    public $evento, $post_edit_id;
    public $post_create = [
        'nombre',
        'fecha_inicio',
        'fecha_finalizacion',
        'lugar_evento',
        'fecha_evento',
        'estado',
    ];
    public $post_update = [
        'nombre' => "",
        'fecha_inicio' => "",
        'fecha_finalizacion' => "",
        'lugar_evento' => "",
        'fecha_evento' => "",
        'estado' => "",
    ];
    protected $listeners = ['delete'];

    public function crear()
    {
        $this->open = true;
    }

    public function seve()
    {
        $this->validate();
        $post = evento::create([

            'nombre' => $this->post_create['nombre'],
            'fecha_inicio' => $this->post_create['fecha_inicio'],
            'fecha_finalizacion' => $this->post_create['fecha_finalizacion'],
            'lugar_evento' => $this->post_create['lugar_evento'],
            'fecha_evento' => $this->post_create['fecha_evento'],
            'estado' => $this->post_create['estado'],

        ]);
        $this->reset(['post_create']);
        $this->dispatch('alert');
        $this->open = false;
    }
    public function edit($edit_id)
    {
        $this->open_edit = true;
        $this->post_edit_id = $edit_id;
        $post = evento::find($edit_id);

        $this->post_update["nombre"] = $post->nombre;
        $this->post_update["fecha_inicio"] = $post->fecha_inicio;
        $this->post_update["fecha_finalizacion"] = $post->fecha_finalizacion;
        $this->post_update["lugar_evento"] = $post->lugar_evento;
        $this->post_update["fecha_evento"] = $post->fecha_evento;
        $this->post_update["estado"] = $post->estado;
    }
    public function update()
    {
        $posts = evento::find($this->post_edit_id);
        $posts->update([
            'nombre' => $this->post_update['nombre'],
            'fecha_inicio' => $this->post_update['fecha_inicio'],
            'fecha_finalizacion' => $this->post_update['fecha_finalizacion'],
            'lugar_evento' => $this->post_update['lugar_evento'],
            'fecha_evento' => $this->post_update['fecha_evento'],
            'estado' => $this->post_update['estado'],

        ]);
        $this->reset(['post_update', 'post_edit_id', 'open_edit']);
        $this->dispatch('alert_update');
    }
    public function confirm_delete($delete_id)
    {
        $this->dispatch('alert_delete', $delete_id);
    }
    public function delete($delete_id)
    {
        $post = evento::find($delete_id);
        $post->delete();
    }
    public function mount()
    {

        $this->evento = evento::all();

    }

    public function rules():array{

        $rules["post_create.nombre"] = 'required|string|max:49|regex:/^[a-zA-Z\s]+$/';
        $rules["post_create.fecha_inicio"] = 'required|date';
        $rules["post_create.fecha_finalizacion"] = 'required|date';
        $rules["post_create.lugar_evento"] = 'required|string|max:59|regex:/^[a-zA-Z\s]+$/';
        $rules["post_create.fecha_evento"] = 'required|date';
        $rules["post_create.estado"] = 'required';

        return $rules;
    }
    public function messages():array
    {
        $messages["post_create.nombre.required"] = __('El campo nombre es obligatorio.');
        $messages["post_create.nombre.string"] = __('El campo nombre debe ser una cadena de texto .');
        $messages["post_create.nombre.max"] = __('El campo nombre no debe ser mayor a 49 letras.');
        $messages["post_create.nombre.regex"] = __('El campo nombre solo acepta letras.');
        $messages["post_create.fecha_inicio.required"] = __('El campo fecha de inicio es obligatorio.');
        $messages["post_create.fecha_inicio.date"] = __('El campo fecha de inicio debe tener el formato correcto.');
        $messages["post_create.fecha_finalizacion.required"] = __('El campo fecha de finalización es obligatorio.');
        $messages["post_create.fecha_finalizacion.date"] = __('El campo fecha de finalización debe tener el formato correcto.');
        $messages["post_create.lugar_evento.required"] = __('El campo lugar del evento es obligatorio.');
        $messages["post_create.lugar_evento.string"] = __('El campo lugar del evento debe ser una cadena de texto .');
        $messages["post_create.lugar_evento.max"] = __('El campo lugar del evento no debe ser mayor a 59 letras.');
        $messages["post_create.lugar_evento.regex"] = __('El campo lugar del evento solo acepta letras.');
        $messages["post_create.fecha_evento.required"] = __('El campo fecha del evento es obligatorio.');
        $messages["post_create.fecha_evento.date"] = __('El campo fecha del evento debe tener el formato correcto.');
        $messages["post_create.estado.required"] = __('Este campo es obligatorio.');
        return $messages;
    }
    public function render()
    {
        $evento=evento::orderBy('id', 'desc')->paginate(8);
        return view('livewire.administrar.admin-evento', [
            'posts' => $evento

        ]);
    }
}
