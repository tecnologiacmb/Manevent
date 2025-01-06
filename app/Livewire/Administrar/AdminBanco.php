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
    protected $listeners = ['delete'];

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


    public function mount()
    {
        $this->nameBanco = banco::all();
    }
    public function render()
    {
        $nameBanco = banco::orderBy('id', 'desc')->paginate(8);

        return view('livewire.administrar.admin-banco', [
            'posts' => $nameBanco

        ]);
    }
}
