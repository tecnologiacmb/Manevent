<?php

namespace App\Livewire\Administrar;

use App\Models\banco;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class AdminBanco extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $nameBanco, $post_edit_id;
    public $open = false;
    public $blob;

    public $open_edit = false;
    public $query;
    public $logoUrl;
    protected $listeners = ['delete'];

    public $post_create = [
        'nombre' => null,
        'codigo' => null,
        'logo' => "",
        'estado' => null,
    ];

    public $post_update = [
        'nombre' => "",
        'codigo' => "",
        'logo' => "",
        'estado' => "",
    ];

    public function mount() {}

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
        // $this->post_update["logo"] = $post->logo; // Remove this line

        // Convert binary data to Data URL
        if ($post->logo) {
            $this->logoUrl = 'data:image/png;base64,' . base64_encode($this->post_update["logo"]); // Assuming PNG, adjust if needed
        } else {
            $this->logoUrl = null;
        }
    }

    public function update()
    {

        $post = banco::find($this->post_edit_id);
        if ($this->post_update['logo']) {
            $this->blob = file_get_contents($this->post_update['logo']->getRealPath());
            if ($post) {
                $post->update([
                    'nombre' => $this->post_update['nombre'],
                    'codigo' => $this->post_update['codigo'],
                    'estado' => $this->post_update['estado'],
                    'logo' => $this->blob,
                ]);

                $this->reset(['post_edit_id', 'open_edit','blob','post_update']);
                $this->dispatch('alert_update');
            }
        }
    }

    public function save()
    {
        $this->validate(); // Asegúrate de validar antes de guardar

        if ($this->post_create['logo']) {
            $blob = file_get_contents($this->post_create['logo']->getRealPath());
            banco::create([
                'nombre' => $this->post_create['nombre'],
                'codigo' => $this->post_create['codigo'],
                'estado' => $this->post_create['estado'],
                'logo' => $blob,
            ]);
            $this->reset(['post_create']);
            $this->dispatch('alert');
            $this->open = false;
        }
    }

    public function confirm_delete($delete_id)
    {
        $this->dispatch('alert_delete', $delete_id);
    }

    public function delete($delete_id)
    {
        $post = banco::find($delete_id);
        if ($post) {
            $post->delete();
        } else {
            session()->flash('message', 'El banco no existe.');
        }
    }

    public function rules(): array
    {
        return [
            "post_create.nombre" => 'required|string|max:25|regex:/^[a-zA-Z\s]+$/',
            "post_create.codigo" => 'required|string|max:8|regex:/^[0-9]+$/',
            "post_create.estado" => 'required',
            "post_create.logo" => 'image|max:1024',
        ];
    }

    public function messages(): array
    {
        return [
            "post_create.nombre.required" => __('El campo nombre es obligatorio.'),
            "post_create.nombre.string" => __('El campo nombre debe ser una cadena de texto.'),
            "post_create.nombre.max" => __('El campo nombre no debe ser mayor a 25 letras.'),
            "post_create.nombre.regex" => __('El campo nombre solo acepta letras.'),
            "post_create.codigo.required" => __('El campo codigo es obligatorio.'),
            "post_create.codigo.string" => __('El campo codigo debe ser una cadena de texto.'),
            "post_create.codigo.max" => __('El campo codigo no debe ser mayor a 8 digitos.'),
            "post_create.codigo.regex" => __('El campo codigo solo acepta numeros.'),
            "post_create.estado.required" => __('El campo estado es obligatorio.'),
            "post_create.logo.image" => __('El campo logo debe ser una imagen.'),
        ];
    }

    public function render()
    {
        $banco =  banco::select('bancos.*')
            ->where(function ($query) {
                $query->orWhere('bancos.nombre', 'like', '%' . $this->query . '%')
                    ->orWhere('bancos.codigo', 'like', '%' . $this->query . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('livewire.administrar.admin-banco', [
            'posts' => $banco
        ]);
    }
}
