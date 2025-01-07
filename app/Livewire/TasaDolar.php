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
        'precio' => "",
    ];
    public function save()
    {
        $post = dolar::create([

            'precio' => $this->post_create['precio'],

        ]);
        $this->reset(['post_create']);
    }

    public function edit($edit_id)
    {
        $this->open_edit = true;
        $this->post_edit_id = $edit_id;
        $post = dolar::find($edit_id);

        $this->post_update["precio"] = $post->precio;
    }

    public function update()
    {
        $posts = dolar::find($this->post_edit_id);
        $posts->update([
            'precio' => $this->post_update['precio'],

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
        $post = dolar::find($delete_id);
        $post->delete();

    }
    public function mount()
    {
        $this->dolars = dolar::all();
    }

    public function render()
    {
        $dolars = dolar::orderBy('created_at', 'desc')->paginate(5);

        return view('livewire.tasa-dolar', [
            'posts' => $dolars
        ]);
    }
}
