<?php

namespace App\Livewire\Administrar;

use App\Models\dolar;
use App\Models\grupo;
use App\Models\recorrido;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminGrupo extends Component
{
    use WithPagination;


    public $grupos;
    public $tipo_grupos;
    public $query;
    public $RecorridoId;
    public $dolars;
    public $recorridos;
    public $open_edit = false;
    public $open = false;
    public $actualizar = false;
    public $registrar = false;
    public $post_edit_id;
    public $post_create = [
        'recorrido_id' => "",
        'nombre' => "",
        'precio' => null,
        'cantidad' => "",
        'estado' => null,

    ];
    public $post_update = [
        'recorrido_id' => "",
        'nombre' => "",
        'precio' => "",
        'cantidad' => "",
        'estado' => "",
    ];
    protected $listeners = ['delete'];

    public function mount()
    {

        $this->grupos = grupo::all();

        $this->dolars = dolar::select('id', 'precio')->whereDate('created_at', Carbon::today())->latest()->first();
        if (!$this->dolars) {
            $this->dolars = dolar::latest()->first();
        }
        $this->recorridos = recorrido::all();
    }
    public function crear()
    {
        $this->open = true;
    }
    public function calculo($num)
    {
        if (isset($this->dolars)) {
            $total = 0;
            $ultimoDolar = $this->dolars;
            $total = $num * $ultimoDolar->precio;

            return $total;
        } else {
            $total = 0;

            return $total;
        }
    }
    public function seve()
    {
        $this->validate();
        $posts = grupo::create([
            'recorrido_id' => $this->post_create['recorrido_id'],
            'nombre' => $this->post_create['nombre'],
            'precio' => $this->post_create['precio'],
            'cantidad' => $this->post_create['cantidad'],
            'estado' => $this->post_create['estado'],
        ]);
        $this->reset(['post_create']);
        $this->dispatch('alert');
        $this->open = false;
    }
    public function edit($edit_id)
    {
        $this->open_edit = true;
        $this->post_edit_id = $edit_id;
        $post = grupo::find($edit_id);

        $this->post_update["recorrido_id"] = $post->recorrido_id;
        $this->post_update["nombre"] = $post->nombre;
        $this->post_update["precio"] = $post->precio;
        $this->post_update["cantidad"] = $post->cantidad;
        $this->post_update["estado"] = $post->estado;
    }
    public function update()
    {
        $this->validate();
        $posts = grupo::find($this->post_edit_id);
        $posts->update([
            'recorrido_id' => $this->post_update['recorrido_id'],
            'nombre' => $this->post_update['nombre'],
            'precio' => $this->post_update['precio'],
            'cantidad' => $this->post_update['cantidad'],
            'estado' => $this->post_update['estado'],

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
        $post = grupo::find($delete_id);
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
        if ($this->registrar == true) {
            $this->actualizar = false;
            return [
                "post_create.recorrido_id" => 'required|integer',
                "post_create.nombre" => 'required|string|max:70|regex:/^[a-zA-Z0-9 ]+$/',
                'post_create.precio' => 'required|numeric|min:0',
                "post_create.cantidad" => 'required|integer|regex:/^[0-9]+$/',
                "post_create.estado" => 'required',
            ];
        } else if ($this->actualizar == true) {
            $this->registrar = false;
            return [
                "post_update.recorrido_id" => 'required|integer',
                'post_update.nombre' => 'required|string|max:70|regex:/^[a-zA-Z0-9 ]+$/',
                'post_update.precio' => 'required|numeric|min:0',
                "post_update.cantidad" => 'required|integer|regex:/^[0-9]+$/',
                "post_update.estado" => 'required',
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
                "post_create.recorrido_id.required" => __('El campo recorrido es obligatorio.'),
                "post_create.recorrido_id.integer" => __('El campo recorrido debe ser un numero.'),
                "post_create.nombre.required" => __('El campo nombre es obligatorio.'),
                "post_create.nombre.string" => __('El campo nombre debe ser una cadena de texto.'),
                "post_create.nombre.max" => __('El campo nombre no debe ser mayor a 70 letras.'),
                "post_create.nombre.regex" => __('El campo nombre solo acepta letras y numeros.'),
                "post_create.precio.required" => __('El campo precio es obligatorio.'),
                "post_create.precio.numeric" => __('El campo precio debe ser un numero.'),
                "post_create.precio.min" => __('El campo precio debe ser mayor a 0.'),
                "post_create.cantidad.required" => __('El campo cantidad es obligatorio.'),
                "post_update.cantidad.integer" => __('El campo cantidad debe ser un numero.'),
                "post_create.cantidad.regex" => __('El campo cantidad solo acepta numeros.'),
                "post_create.estado.required" => __('Este campo es obligatorio.'),
            ];
        } else if ($this->actualizar == true) {
            $this->registrar = false;
            return [
                "post_update.recorrido_id.required" => __('El campo recorrido es obligatorio.'),
                "post_update.recorrido_id.integer" => __('El campo recorrido debe ser un numero.'),
                "post_update.nombre.required" => __('El campo nombre es obligatorio.'),
                "post_update.nombre.string" => __('El campo nombre debe ser una cadena de texto.'),
                "post_update.nombre.max" => __('El campo nombre no debe ser mayor a 70 letras.'),
                "post_update.nombre.regex" => __('El campo nombre solo acepta letras y numeros.'),
                "post_update.precio.required" => __('El campo precio es obligatorio.'),
                "post_update.precio.numeric" => __('El campo precio debe ser un numero.'),
                "post_update.precio.min" => __('El campo precio debe ser mayor a 0.'),
                "post_update.cantidad.required" => __('El campo cantidad es obligatorio.'),
                "post_update.cantidad.integer" => __('El campo cantidad debe ser un numero.'),
                "post_update.cantidad.regex" => __('El campo cantidad solo acepta numeros.'),
                "post_update.estado.required" => __('Este campo es obligatorio.'),
            ];
        } else {
            return [];
        }
    }

    public function render()
    {
        $grupos =  grupo::select('grupos.*')->join('recorridos', 'grupos.recorrido_id', '=', 'recorridos.id')
            ->where(function ($query) {
                $query->orWhere('grupos.nombre', 'like', '%' . $this->query . '%')
                    ->orWhere('grupos.precio', 'like', '%' . $this->query . '%');
            })
            ->when($this->RecorridoId, function ($query) { // Add this when clause
                $query->where('grupos.recorrido_id', $this->RecorridoId);
            }) // Especificar tabla para el género
            ->orderBy('id', 'desc')
            ->paginate(4);
        return view('livewire.administrar.admin-grupo', [
            'posts' => $grupos
        ]);
    }
}
