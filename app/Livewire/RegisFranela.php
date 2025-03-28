<?php

namespace App\Livewire;

use App\Models\evento;
use App\Models\grupo;
use App\Models\prenda;
use Livewire\Component;
use App\Models\prenda_category;
use App\Models\prenda_talla;
use Illuminate\Support\Facades\DB;

class RegisFranela extends Component
{
    public $tallas = null;
    public $categorias = null;
    public $prendas = null;
    public $open = false;
    public $open_update = false;
    public $evento = null;
    public $post_edit_id;
    public $create_prenda = [
        'evento_id' => null,
        'prenda_category_id' => null,
        'prenda_talla_id' => null,
        'cantidad' => null,
        'restadas' => null,
        'sexo' => null,
        'estado' => null,
    ];

    public function mount()
    {
        $this->tallas = prenda_talla::all();
        $this->categorias = prenda_category::all();
        /* $this->prendas = DB::table('prendas')->join('prenda_tallas', 'prendas.prenda_talla_id', '=', 'prenda_tallas.id')->join('prenda_categories', 'prendas.prenda_category_id', '=', 'prenda_categories.id')->select('prendas.*', 'prenda_tallas.talla as prenda_talla', 'prenda_categories.nombre as prenda_categories_nombre')->get(); */

        $this->evento = evento::select('id', 'nombre', 'fecha_evento')->where('estado', true)->orderBy('id', 'desc')->first();

        if (!is_null($this->evento)) {
            $this->create_prenda = [
                'evento_id' => $this->evento->id,
                'prenda_category_id' => null,
                'prenda_talla_id' => null,
                'cantidad' => null,
                'restadas' => null,
                'sexo' => null,
                'estado' => null,
            ];
        } else {
            $this->create_prenda = [
                'evento_id' => null,
                'prenda_category_id' => null,
                'prenda_talla_id' => null,
                'cantidad' => null,
                'sexo' => null,
                'estado' => null,
            ];
        }
    }
    public function crear()
    {
        $this->open = true;
    }


    public function select_sexo($value)
    {
        if ($value == 'Femenino') {
            $this->create_prenda['sexo'] = 'Femenino';
        } else if ($value == 'Masculino') {
            $this->create_prenda['sexo'] = 'Masculino';
        } else {
            $this->create_prenda['sexo'] = '';
        }
    }
    public function edit($edit_id)
    {

        $this->open_update = true;
        $this->post_edit_id = $edit_id;

        $post  = prenda::find($this->post_edit_id);
        $this->create_prenda["prenda_category_id"] = $post->prenda_category_id;
        $this->create_prenda["prenda_talla_id"] = $post->prenda_talla_id;
        $this->create_prenda["cantidad"] = $post->cantidad;
        $this->create_prenda["sexo"] = $post->sexo;
        $this->create_prenda["estado"] = $post->estado;
    }
    public function actualizar()
    {
        $posts = grupo::find($this->post_edit_id);
        $posts->update([
            'prenda_category_id' => $this->create_prenda['prenda_category_id'],
            'prenda_talla_id' => $this->create_prenda['prenda_talla_id'],
            'cantidad' => $this->create_prenda['cantidad'],
            'sexo' => $this->create_prenda['sexo'],
            'estado' => $this->create_prenda['estado'],
        ]);
        $this->reset(['create_prenda']);
        $this->dispatch('alert');
        $this->open_update = false;
    }
    public function seve()
    {
        $prenda = prenda::create([
            'evento_id' => $this->create_prenda['evento_id'],
            'prenda_category_id' => $this->create_prenda['prenda_category_id'],
            'prenda_talla_id' => $this->create_prenda['prenda_talla_id'],
            'cantidad' => $this->create_prenda['cantidad'],
            'sexo' => $this->create_prenda['sexo'],
            'estado' => $this->create_prenda['estado'],
        ]);
        $this->reset(['create_prenda']);
        $this->dispatch('alert');
        $this->open = false;
    }
    public function render()
    {
        $this->prendas = prenda::select('prendas.*', 'prenda_tallas.talla as prenda_talla', 'prenda_categories.nombre as prenda_categories_nombre')->join('prenda_tallas', 'prendas.prenda_talla_id', '=', 'prenda_tallas.id')->join('prenda_categories', 'prendas.prenda_category_id', '=', 'prenda_categories.id')->where('prendas.estado', true)->get();
        return view('livewire.regis-franela',['prendas'=>$this->prendas]);
    }
}
