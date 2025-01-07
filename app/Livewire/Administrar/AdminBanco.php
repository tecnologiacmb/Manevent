<?php

namespace App\Livewire\Administrar;

use App\Models\banco;
use Livewire\Component;
use Livewire\WithPagination;



class AdminBanco extends Component
{
    use WithPagination;


    public $nameBanco, $post_edit_id;
    public $open = false;
    public $open_edit = false;
    protected $listeners = ['delete'];
    public $post_create = [
        'nombre' => null,
        'codigo' => null,
        'estado' => null,
    ];

    public $post_update = [
        'nombre' => "",
        'codigo' => "",
        'estado' =>  "",
    ];

    public function mount()
    {
        $this->nameBanco = banco::all();
    }
    public function crear()
    {
        $this->open = true;
    }
    public function edit($edit_id)
    {
        $this->open_edit = true;
        $this->post_edit_id = $edit_id;
        $post = banco::find($edit_id);

        $this->post_update["nombre"] = $post->nombre;
        $this->post_update["codigo"] = $post->codigo;
        $this->post_update["estado"] = $post->estado;
    }
    public function seve()
    {
        $this->validate();

        $posts = banco::create([
            'nombre' => $this->post_create['nombre'],
            'codigo' => $this->post_create['codigo'],
            'estado' => $this->post_create['estado'],

        ]);
        $this->reset(['post_create']);
        $this->dispatch('alert');
        $this->open = false;
    }

    public function update()
    {
        $posts = banco::find($this->post_edit_id);
        $posts->update([
            'nombre' => $this->post_update['nombre'],
            'codigo' => $this->post_update['codigo'],
            'estado' => $this->post_update['estado'],

        ]);
        $this->reset(['post_update', 'post_edit_id', 'open_edit']);
        $this->dispatch('alert_update');
    }
    public function confirm_delete($delete_id)
    {
    $this->dispatch('alert_delete',$delete_id);

    }
    public function delete($delete_id)
    {
        $post = banco::find($delete_id);
        $post->delete();

    }

    public function rules():array{

        $rules["post_create.nombre"] = 'required|string|max:25|regex:/^[a-zA-Z\s]+$/';
        $rules["post_create.codigo"] = 'required|string|max:8|regex:/^[0-9]+$/';
        $rules["post_create.estado"] = 'required';
        return $rules;
    }
    public function messages():array
    {

        $messages["post_create.nombre.required"] = __('El campo nombre es obligatorio.');
        $messages["post_create.nombre.string"] = __('El campo nombre debe ser una cadena de texto .');
        $messages["post_create.nombre.max"] = __('El campo nombre no debe ser mayor a 25 letras.');
        $messages["post_create.nombre.max"] = __('El campo nombre solo acepta letras.');
        $messages["post_create.codigo.required"] = __('El campo codigo es obligatorio.');
        $messages["post_create.codigo.string"] = __('El campo codigo debe ser una cadena de texto .');
        $messages["post_create.codigo.max"] = __('El campo codigo no debe ser mayor a 8 digitos.');
        $messages["post_create.codigo.regex"] = __('El campo codigo solo acepta numeros.');
        $messages["post_create.estado.required"] = __('El campo estado es obligatorio.');
        return $messages;
    }


    public function render()
    {
        $nameBanco = banco::orderBy('id', 'desc')->paginate(8);

        return view('livewire.administrar.admin-banco', [
            'posts' => $nameBanco

        ]);
    }
}
