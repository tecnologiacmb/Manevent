<?php

namespace App\Livewire;

use App\Models\categoriaHabilitada;
use App\Models\evento;
use App\Models\grupo;
use App\Models\prenda;
use Livewire\Component;
use App\Models\prenda_category;
use App\Models\prenda_talla;
use Illuminate\Support\Facades\DB;

class RegisFranela extends Component
{
    public $tallas;
    public $categorias;
    public $prendas;
    public $open = false;
    public $open_update = false;
    public $eventos;
    public $query;
    public $eventoId;
    public $genero;
    public $post_edit_id;
    public $actualizar = false;
    public $registrar = false;
    public $create_prenda = [
        'evento_id' => null,
        'prenda_category_id' => null,
        'prenda_talla_id' => null,
        'cantidad' => null,
        'restadas' => null,
        'sexo' => null,
        'estado' => null,
    ];
    public $actualizar_prenda = [
        'evento_id' => null,
        'prenda_category_id' => null,
        'prenda_talla_id' => null,
        'cantidad' => null,
        'restadas' => null,
        'sexo' => null,
        'estado' => null,
    ];
    protected $listeners = ['delete'];

    public function mount()
    {
        $this->tallas = prenda_talla::all();
        $this->categorias = prenda_category::all();
        $this->eventos = evento::all();
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
    public function crear()
    {
        $this->open = true;
    }
    public function limpiar()
    {
        $this->genero = '';
        $this->query = '';
        $this->eventoId = '';
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
        $this->actualizar_prenda["prenda_category_id"] = $post->prenda_category_id;
        $this->actualizar_prenda["prenda_talla_id"] = $post->prenda_talla_id;
        $this->actualizar_prenda["cantidad"] = $post->cantidad;
        $this->actualizar_prenda["sexo"] = $post->sexo;
        $this->actualizar_prenda["estado"] = $post->estado;
    }
    public function actualizar()
    {
        $this->validate();

        $posts = grupo::find($this->post_edit_id);
        $posts->update([
            'prenda_category_id' => $this->actualizar_prenda['prenda_category_id'],
            'prenda_talla_id' => $this->actualizar_prenda['prenda_talla_id'],
            'cantidad' => $this->actualizar_prenda['cantidad'],
            'sexo' => $this->actualizar_prenda['sexo'],
            'estado' => $this->actualizar_prenda['estado'],
        ]);
        $this->reset(['create_prenda']);
        $this->dispatch('alert');
        $this->open_update = false;
    }
    public function seve()
    {
        $this->validate();
        $evento = evento::select('id', 'nombre', 'fecha_evento')->where('estado', true)->orderBy('id', 'desc')->first();
        $this->create_prenda['evento_id'] = $evento->id;
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
    public function confirm_delete($delete_id)
    {
        $this->dispatch('alert_delete', $delete_id);
    }
    public function delete($delete_id)
    {
        $post = categoriaHabilitada::find($delete_id);
        $post->delete();
    }
    public function rules(): array
    {
        if ($this->registrar==true) {
            $this->actualizar=false;
            return [
                "create_prenda.prenda_category_id" => 'required|integer',
                "create_prenda.prenda_talla_id" => 'required|integer',
                "create_prenda.cantidad" => 'required|integer',
                "create_prenda.sexo" => 'required',
                "create_prenda.estado" => 'required',
            ];
        }else if ($this->actualizar==true) {
            $this->registrar=false;
            return [
                "actualizar_prenda.prenda_category_id" => 'required|integer',
                "actualizar_prenda.prenda_talla_id" => 'required|integer',
                "actualizar_prenda.cantidad" => 'required|integer',
                "actualizar_prenda.sexo" => 'required',
                "actualizar_prenda.estado" => 'required',
            ];
        }else{
            return [];
        }

    }
    public function messages(): array
    {
        if ($this->registrar==true) {
            $this->actualizar=false;
            return [
                "create_prenda.prenda_category_id.required" => __('El campo categoria es obligatorio.'),
                "create_prenda.prenda_category_id.integer" => __('El campo categoria debe ser un numero.'),
                "create_prenda.prenda_talla_id.required" => __('El campo talla es obligatorio.'),
                "create_prenda.prenda_talla_id.integer" => __('El campo talla debe ser un numero.'),
                "create_prenda.cantidad.required" => __('El campo cantidad es obligatorio.'),
                "create_prenda.cantidad.integer" => __('El campo cantidad debe ser un numero.'),
                "create_prenda.sexo.required" => __('El campo sexo es obligatorio.'),
                "create_prenda.estado.required" => __('Este campo es obligatorio.'),
            ];
        }else if ($this->actualizar==true) {
            $this->registrar=false;
            return [
                "actualizar_prenda.prenda_category_id.required" => __('El campo categoria es obligatorio.'),
                "actualizar_prenda.prenda_category_id.integer" => __('El campo categoria debe ser un numero.'),
                "actualizar_prenda.prenda_talla_id.required" => __('El campo talla es obligatorio.'),
                "actualizar_prenda.prenda_talla_id.integer" => __('El campo talla debe ser un numero.'),
                "actualizar_prenda.cantidad.required" => __('El campo cantidad es obligatorio.'),
                "actualizar_prenda.cantidad.integer" => __('El campo cantidad debe ser un numero.'),
                "actualizar_prenda.sexo.required" => __('El campo sexo es obligatorio.'),
                "actualizar_prenda.estado.required" => __('Este campo es obligatorio.'),
            ];
        }else{
            return [];
        }
    }
    public function render()
    {
        $prendas =  prenda::select('prendas.*', 'prenda_tallas.talla as prenda_talla', 'prenda_categories.nombre as prenda_categories_nombre')->join('prenda_tallas', 'prendas.prenda_talla_id', '=', 'prenda_tallas.id')->join('prenda_categories', 'prendas.prenda_category_id', '=', 'prenda_categories.id')
            ->join('eventos', 'prendas.evento_id', '=', 'eventos.id')
            ->where(function ($query) {
                $query->orWhere('prenda_tallas.talla', 'like', '%' . $this->query . '%')
                    ->orWhere('prenda_categories.nombre', 'like', '%' . $this->query . '%');
            })
            ->when($this->eventoId, function ($query) { // Add this when clause
                $query->where('prendas.evento_id', $this->eventoId);
            })->when($this->genero, function ($query) {
                $query->where('prendas.sexo', $this->genero); // Especificar tabla para el género
            })->where('prenda_categories.id', '!=', 1)
            ->orderBy('prendas.id', 'desc')
            ->paginate(4);

        $eventos = \App\Models\Evento::all();

        return view('livewire.regis-franela', ['users' => $prendas, 'eventos' => $eventos]);
    }
}
