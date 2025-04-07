<?php

namespace App\Livewire\Administrar;

use App\Models\categoriaHabilitada;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminCategoria extends Component
{
    use WithPagination;

    public $categoria;
    public $query;
    public $post_edit_id;
    public $open;
    protected $listeners = ['delete'];
    public $open_edit = false;
    public $post_create = [
        'nombre' => "",
        'edad_min' => "",
        'edad_max' => "",
    ];
    public $post_update = [
        'nombre' => "",
        'edad_min' => "",
        'edad_max' =>  "",
    ];

    public function edit($edit_id)
    {
        $this->open_edit = true;
        $this->post_edit_id = $edit_id;
        $post = categoriaHabilitada::find($edit_id);

        $this->post_update["nombre"] = $post->nombre;
        $this->post_update["edad_min"] = $post->edad_min;
        $this->post_update["edad_max"] = $post->edad_max;
    }
    public function mount()
    {
        $this->categoria = categoriaHabilitada::all();
    }

    public function crear()
    {
        $this->open = true;
    }
    public function save()
    {
        $this->validate();
        $post = categoriaHabilitada::create([
            'nombre' => $this->post_create['nombre'],
            'edad_min' => $this->post_create['edad_min'],
            'edad_max' => $this->post_create['edad_max'],

        ]);
        $this->reset(['post_create']);
        $this->dispatch('alert');
        $this->open = false;
    }
    public function update()
    {
        $posts = categoriaHabilitada::find($this->post_edit_id);
        $posts->update([
            'nombre' => $this->post_update['nombre'],
            'edad_min' => $this->post_update['edad_min'],
            'edad_max' => $this->post_update['edad_max'],

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
        $post = categoriaHabilitada::find($delete_id);
        $post->delete();
    }

    public function rules():array{

        $rules["post_create.nombre"] = 'required|string|max:25|regex:/^[a-zA-Z\s]+$/';
        $rules["post_create.edad_min"] = 'required|string|max:2|regex:/^[0-9]+$/';
        $rules["post_create.edad_max"] = 'required|string|max:2|regex:/^[0-9]+$/';
        return $rules;
    }
    public function messages():array
    {

        $messages["post_create.nombre.required"] = __('El campo nombre es obligatorio.');
        $messages["post_create.nombre.string"] = __('El campo nombre debe ser una cadena de texto .');
        $messages["post_create.nombre.max"] = __('El campo nombre no debe ser mayor a 25 letras.');
        $messages["post_create.nombre.regex"] = __('El campo nombre solo acepta letras.');
        $messages["post_create.edad_min.required"] = __('El campo edad minima es obligatorio.');
        $messages["post_create.edad_min.string"] = __('El campo edad minima debe ser una cadena de texto .');
        $messages["post_create.edad_min.max"] = __('El campo edad minima no debe ser mayor a 2 digitos.');
        $messages["post_create.edad_min.regex"] = __('El campo edad minima solo acepta numeros.');
        $messages["post_create.edad_max.required"] = __('El campo edad maxima es obligatorio.');
        $messages["post_create.edad_max.string"] = __('El campo edad maxima debe ser una cadena de texto .');
        $messages["post_create.edad_max.max"] = __('El campo edad maxima no debe ser mayor a 2 digitos.');
        $messages["post_create.edad_max.regex"] = __('El campo edad maxima solo acepta numeros.');

        return $messages;
    }
    public function render()
    {
        $categoria =  categoriaHabilitada::select('categoria_habilitadas.*')
        ->where(function ($query) {
            $query->orWhere('categoria_habilitadas.nombre', 'like', '%' . $this->query . '%');
        })
        ->orderBy('created_at', 'desc')->paginate(6);
        return view('livewire.administrar.admin-categoria', [
            'posts' => $categoria
        ]);
    }
}
