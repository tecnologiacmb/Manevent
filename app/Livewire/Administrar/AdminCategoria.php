<?php

namespace App\Livewire\Administrar;

use App\Models\categoriaHabilitada;
use Livewire\Component;
use Livewire\WithPagination;

class AdminCategoria extends Component
{
    use WithPagination;
    public $categoria,$post_edit_id;
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
    $this->dispatch('alert_delete',$delete_id);

    }
    public function delete($delete_id)
    {
        $post = categoriaHabilitada::find($delete_id);
        $post->delete();

    }
    public function render()
    {
        $categoria = categoriaHabilitada::orderBy('created_at', 'desc')->paginate(5);

        return view('livewire.administrar.admin-categoria', [
            'posts' => $categoria
        ]);
    }
}
