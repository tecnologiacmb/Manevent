<?php

namespace App\Livewire;

use App\models\dolar;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\SoftDeletes;

class TasaDolar extends Component
{
    use WithPagination;
    public $dolars;
    public $open_edit = false;
    public $post_edit_id;
    protected $listeners = ['delete'];
    public $post_create = [
        'precio' => null,
    ];
    public $post_update = [
        'precio' => null,
    ];
    public $registrar = false;
    public $actualizar = false;

    public function mount()
    {
        $this->dolars = dolar::all();
    }
    public function edit($edit_id)
    {
        $this->open_edit = true;
        $this->post_edit_id = $edit_id;
        $post = dolar::find($edit_id);
        $this->post_update["precio"] = $post->precio;
    }
    public function save()
    {
        $this->validate();
        $post = dolar::create([
            'precio' => $this->post_create['precio'],
        ]);
        $this->reset(['post_create']);
    }
    public function update()
    {
        $this->validate();

        $posts = dolar::find($this->post_edit_id);
        $posts->update([
            'precio' => $this->post_update['precio'],
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
        $post = dolar::find($delete_id);
        $post->delete();
    }
    public function rules(): array
    {
        if ($this->registrar == true) {
            $this->actualizar = false;
            return [
                "post_create.precio" => 'required|numeric',
            ];
        } else if ($this->actualizar == true) {
            $this->registrar = false;
            return [
                "post_update.precio" => 'required|numeric',
            ];
        } else {
            return [];
        }
    }
    public function messages(): array
    {
        if ($this->registrar == true) {
            $this->actualizar = false;
            return [
                "post_create.precio.required" => __('El campo precio es obligatorio.'),
                "post_create.precio.numeric" => __('El campo precio debe ser un numero.'),
            ];
        } else if ($this->actualizar == true) {
            $this->registrar = false;
            return [
                "post_update.precio.required" => __('El campo precio es obligatorio.'),
                "post_update.precio.numeric" => __('El campo precio debe ser un numero.'),
            ];
        } else {
            return [];
        }
    }
    public function validar_registro()
    {
        $this->registrar = true;
        $this->actualizar = false;
    }
    public function validar_actualizacion()
    {
        $this->actualizar = true;
        $this->registrar = false;
    }
    public function render()
    {
        $dolars = dolar::orderBy('created_at', 'desc')->paginate(5);

        return view('livewire.tasa-dolar', [
            'posts' => $dolars
        ]);
    }
}
