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
    public $actualizar = false;
    public $registrar = false;

    public $post_create = [
        'nombre' => null,
        'edad_min' => null,
        'edad_max' => null,
    ];
    public $post_update = [
        'nombre' => null,
        'edad_min' => null,
        'edad_max' =>  null,
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
        $this->validate();
        $post = categoriaHabilitada::find($this->post_edit_id);

        if ($post) {
            $post->update([
                'nombre' => $this->post_update['nombre'],
                'edad_min' => $this->post_update['edad_min'],
                'edad_max' => $this->post_update['edad_max'],

            ]);
            $this->reset(['post_update', 'post_edit_id', 'open_edit']);
            $this->dispatch('alert_update');
        }
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
    public function validar1()
    {
        $this->registrar = true;
        $this->actualizar = false;
    }
    public function validar2()
    {
        $this->actualizar = true;
        $this->registrar = false;
    }
    public function rules(): array
    {
        if ($this->registrar) {
            return [
                "post_create.nombre" => 'required|string|max:25',
                "post_create.edad_min" => 'required|integer|between:0,99',
                "post_create.edad_max" => 'required|integer|between:0,99',
            ];
        } elseif ($this->actualizar) {
            return [
                "post_update.nombre" => 'required|string|max:25',
                "post_update.edad_min" => 'required|integer|between:0,99',
                "post_update.edad_max" => 'required|integer|between:0,99',
            ];
        }

        return [];
    }

    public function messages(): array
    {
        if ($this->registrar) {
            return [
                "post_create.nombre.required" => __('El campo nombre es obligatorio.'),
                "post_create.nombre.string" => __('El campo nombre debe ser una cadena de texto.'),
                "post_create.nombre.max" => __('El campo nombre no debe ser mayor a 25 letras.'),
                "post_create.edad_min.required" => __('El campo edad mínima es obligatorio.'),
                "post_create.edad_min.integer" => __('El campo edad mínima debe ser un número.'),
                "post_create.edad_min.between" => __('La edad mínima debe estar entre 0 y 99.'),
                "post_create.edad_max.required" => __('El campo edad máxima es obligatorio.'),
                "post_create.edad_max.integer" => __('El campo edad máxima debe ser un número.'),
                "post_create.edad_max.between" => __('La edad máxima debe estar entre 0 y 99.'),
            ];
        } elseif ($this->actualizar) {
            return [
                "post_update.nombre.required" => __('El campo nombre es obligatorio.'),
                "post_update.nombre.string" => __('El campo nombre debe ser una cadena de texto.'),
                "post_update.nombre.max" => __('El campo nombre no debe ser mayor a 25 letras.'),
                "post_update.edad_min.required" => __('El campo edad mínima es obligatorio.'),
                "post_update.edad_min.integer" => __('El campo edad mínima debe ser un número.'),
                "post_update.edad_min.between" => __('La edad mínima debe estar entre 0 y 99.'),
                "post_update.edad_max.required" => __('El campo edad máxima es obligatorio.'),
                "post_update.edad_max.integer" => __('El campo edad máxima debe ser un número.'),
                "post_update.edad_max.between" => __('La edad máxima debe estar entre 0 y 99.'),
            ];
        }

        return [];
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
