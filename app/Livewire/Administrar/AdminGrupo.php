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
    public $dolars;
    public $recorridos;
    public $open_edit = false;
    public $open = false;
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
        $this->post_create['dolar_id'] = $this->dolars ? $this->dolars->id : null;
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
    public function rules(): array
    {
        $rules["post_create.recorrido_id"] = 'required|regex:/^[0-9]+$/';
        $rules["post_create.nombre"] = 'required|string|max:49|regex:/^[a-zA-Z\s]+$/';
        $rules["post_create.precio"] = 'required|string|regex:/^[0-9]+$/';
        $rules["post_create.cantidad"] = 'required|string|regex:/^[0-9]+$/';
        $rules["post_create.estado"] = 'required';

        return $rules;
    }
    public function messages(): array
    {
        $messages["post_create.nombre.required"] = __('El campo nombre es obligatorio.');
        $messages["post_create.nombre.string"] = __('El campo nombre debe ser una cadena de texto .');
        $messages["post_create.nombre.max"] = __('El campo nombre no debe ser mayor a 49 letras.');
        $messages["post_create.nombre.regex"] = __('El campo nombre solo acepta letras.');
        $messages["post_create.precio.required"] = __('El campo precio de inicio es obligatorio.');
        $messages["post_create.precio.string"] = __('El campo precio de inicio debe debe ser una cadena de texto.');
        $messages["post_create.precio.regex"] = __('El campo precio solo acepta numeros.');
        $messages["post_create.cantidad.required"] = __('El campo cantidad de inicio es obligatorio.');
        $messages["post_create.cantidad.string"] = __('El campo cantidad de inicio debe debe ser una cadena de texto.');
        $messages["post_create.cantidad.regex"] = __('El campo cantidad solo acepta numeros.');
        $messages["post_create.estado.required"] = __('El campo estado es obligatorio.');
        $messages["post_create.recorrido_id.required"] = __('El campo categoria es obligatorio.');
        $messages["post_create.recorrido_id.regex"] = __('El campo recorrido_id solo acepta numeros.');
        $messages["post_create.estado.required"] = __('Este campo es obligatorio.');
        return $messages;
    }
    public function render()
    {
        $grupos = grupo::orderBy('id', 'desc')->paginate(5);
        return view('livewire.administrar.admin-grupo', [
            'posts' => $grupos
        ]);
    }
}
