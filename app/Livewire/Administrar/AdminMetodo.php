<?php

namespace App\Livewire\Administrar;

use Livewire\Component;
use App\Models\metodo_pago;
use App\Models\banco;
use App\Models\tipo_pago;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\SoftDeletes;
use Livewire\WithFileUploads;

class AdminMetodo extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $blob;
    public $logoUrl;

    public $nameMetodo;
    public $banco;
    public $tipo_pago;
    public $metodo = null;
    public $open_edit = false;
    public $open = false;
    public $post_edit_id;
    public $actualizar = false;
    public $registrar = false;

    public $post_create = [
        'tipo_pago_id' => "",
        'banco_id' => "",
        'n°_cuenta' => null,
        'cedula' => null,
        'telefono' => null,
        'propietario' => null,
        'ABA' => null,
        'SWIT' => null,
        'correo' => null,
        'estado' => null,
    ];
    public $post_update = [
        'tipo_pago_id' => "",
        'banco_id' => "",
        'n°_cuenta' => "",
        'cedula' => "",
        'telefono' => "",
        'propietario' => "",
        'ABA' => "",
        'SWIT' => "",
        'correo' => "",
        'estado' => "",

    ];
    protected $listeners = ['delete'];
    public function mount()
    {
        $this->nameMetodo = metodo_pago::all();
        $this->banco = banco::all();
        $this->tipo_pago = tipo_pago::all();
    }

    public function changeEvent($value)
    {

        $this->metodo = $value;
    }
    public function crear()
    {
        $this->open = true;
    }
    public function seve()
    {
        $this->validate();
        $post = metodo_pago::create([
            'tipo_pago_id' => $this->post_create['tipo_pago_id'],
            'banco_id' => $this->post_create['banco_id'],
            'n°_cuenta' => $this->post_create['n°_cuenta'],
            'cedula' => $this->post_create['cedula'],
            'telefono' => $this->post_create['telefono'],
            'propietario' => $this->post_create['propietario'],
            'ABA' => $this->post_create['ABA'],
            'SWIT' => $this->post_create['SWIT'],
            'correo' => $this->post_create['correo'],
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
        $post = metodo_pago::find($edit_id);
        $this->post_update["tipo_pago_id"] = $post->tipo_pago_id;
        $this->post_update["banco_id"] = $post->banco_id;
        $this->post_update["n°_cuenta"] = $post->n°_cuenta;
        $this->post_update["cedula"] = $post->cedula;
        $this->post_update["telefono"] = $post->telefono;
        $this->post_update["propietario"] = $post->propietario;
        $this->post_update["ABA"] = $post->ABA;
        $this->post_update["SWIT"] = $post->SWIT;
        $this->post_update["correo"] = $post->correo;
        $this->post_update["estado"] = $post->estado;
    }
    public function update()
    {
        $this->validate();
        $posts = metodo_pago::find($this->post_edit_id);
        $posts->update([
            'tipo_pago_id' => $this->post_update['tipo_pago_id'],
            'banco_id' => $this->post_update['banco_id'],
            'n°_cuenta' => $this->post_update['n°_cuenta'],
            'cedula' => $this->post_update['cedula'],
            'telefono' => $this->post_update['telefono'],
            'propietario' => $this->post_update['propietario'],
            'ABA' => $this->post_update['ABA'],
            'SWIT' => $this->post_update['SWIT'],
            'correo' => $this->post_update['correo'],
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
        $post = metodo_pago::find($delete_id);
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
            $rules = [];
            $rules["post_create.tipo_pago_id"] = 'required|integer';
            $rules["post_create.banco_id"] = 'required|integer';
            $rules["post_create.estado"] = 'required';
            $rules["post_create.propietario"] = 'required|string|max:49|regex:/^[a-zA-Z\s]+$/';

            if ($this->post_create["tipo_pago_id"] == 2) {
                $rules["post_create.n°_cuenta"] = 'required|string|regex:/^[0-9]+$/';
                $rules["post_create.propietario"] = 'required|string|max:49|regex:/^[a-zA-Z\s]+$/';
                $rules["post_create.ABA"] = 'required|string|regex:/^[0-9]+$/';
                $rules["post_create.SWIT"] = 'required|string|regex:/^[0-9]+$/';
                $rules["post_create.correo"] = 'required|email|max:60';
            } elseif ($this->post_create["tipo_pago_id"] == 3) {
                $rules["post_create.propietario"] = 'required|string|max:49|regex:/^[a-zA-Z\s]+$/';
                $rules["post_create.cedula"] = 'required|string|digits:8|regex:/^[0-9]+$/';
                $rules["post_create.telefono"] = 'required|string|digits:11|regex:/^[0-9]+$/';
            } elseif ($this->post_create["tipo_pago_id"] == 4) {
                $rules["post_create.n°_cuenta"] = 'required|regex:/^[0-9]+$/';
                $rules["post_create.propietario"] = 'required|string|max:49|regex:/^[a-zA-Z\s]+$/';
                $rules["post_create.cedula"] = 'required|string|digits:8|regex:/^[0-9]+$/';
            }
            return $rules;
        } else if ($this->actualizar == true) {
            $this->registrar = false;
            $rules = [];
            $rules["post_update.tipo_pago_id"] = 'required|integer';
            $rules["post_update.banco_id"] = 'required|integer';
            $rules["post_update.estado"] = 'required';
            $rules["post_update.propietario"] = 'required|string|max:49|regex:/^[a-zA-Z\s]+$/';

            if ($this->post_update["tipo_pago_id"] == 2) {
                $rules["post_update.n°_cuenta"] = 'required|string|regex:/^[0-9]+$/';
                $rules["post_update.propietario"] = 'required|string|max:49|regex:/^[a-zA-Z\s]+$/';
                $rules["post_update.ABA"] = 'required|string|regex:/^[0-9]+$/';
                $rules["post_update.SWIT"] = 'required|string|regex:/^[0-9]+$/';
                $rules["post_update.correo"] = 'required|email|max:60';
            } elseif ($this->post_update["tipo_pago_id"] == 3) {
                $rules["post_update.propietario"] = 'required|string|max:49|regex:/^[a-zA-Z\s]+$/';
                $rules["post_update.cedula"] = 'required|string|digits:8|regex:/^[0-9]+$/';
                $rules["post_update.telefono"] = 'required|string|digits:11|regex:/^[0-9]+$/';
            } elseif ($this->post_update["tipo_pago_id"] == 4) {
                $rules["post_update.n°_cuenta"] = 'required|regex:/^[0-9]+$/';
                $rules["post_update.propietario"] = 'required|string|max:49|regex:/^[a-zA-Z\s]+$/';
                $rules["post_update.cedula"] = 'required|string|digits:8|regex:/^[0-9]+$/';
            }
            return $rules;
        } else {
            return [];
        }
    }
    public function messages(): array
    {
        if ($this->registrar) {
            $messages["post_create.tipo_pago_id.required"] = __('El campo Metodo es obligatorio.');
            $messages["post_create.tipo_pago_id.integer"] = __('El campo Metodo debe ser un numero .');
            $messages["post_create.banco_id.required"] = __('El campo Banco no debe ser mayor a 49 letras.');
            $messages["post_create.banco_id.integer"] = __('El campo Banco debe ser un numero');
            $messages["post_create.estado.required"] = __('Este campo es obligatorio.');
            $messages["post_create.n°_cuenta.required"] = __('El n° de cuenta es obligatorio.');
            $messages["post_create.n°_cuenta.string"] = __('El n° de cuenta debe ser una cadena de texto.');
            $messages["post_create.n°_cuenta.regex"] = __('Este campo solo acepta numeros.');
            $messages["post_create.propietario.required"] = __('El campo propietario es obligatorio.');
            $messages["post_create.propietario.string"] = __('El campo propietario debe ser una cadena de texto.');
            $messages["post_create.propietario.max"] = __('El campo propietario de debe ser mayor a 49 digitos.');
            $messages["post_create.propietario.regex"] = __('El campo cantidad solo acepta letras.');
            $messages["post_create.ABA.required"] = __('El ABA es obligatorio.');
            $messages["post_create.ABA.string"] = __('El ABA debe ser una cadena de texto.');
            $messages["post_create.ABA.regex"] = __('Este campo solo acepta numeros.');
            $messages["post_create.SWIT.required"] = __('El SWIT es obligatorio.');
            $messages["post_create.SWIT.string"] = __('El SWIT debe ser una cadena de texto.');
            $messages["post_create.SWIT.regex"] = __('Este campo solo acepta numeros.');
            $messages["post_create.correo.required"] = __('El campo correo es obligatorio.');
            $messages["post_create.correo.email"] = __('El campo correo debe tener la sintaxis correcta.');

            $messages["post_create.cedula.required"] = __('El campo cedula es obligatorio.');
            $messages["post_create.cedula.string"] = __('El campo cedula debe ser una cadena de texto.');
            $messages["post_create.cedula.regex"] = __('Este campo solo acepta numeros.');
            $messages["post_create.cedula.max"] = __('El campo cedula no debe ser mayor a 8 digitos.');

            $messages["post_create.telefono.required"] = __('El campo telefono es obligatorio.');
            $messages["post_create.telefono.string"] = __('El campo telefono debe ser una cadena de texto.');
            $messages["post_create.telefono.regex"] = __('Este campo solo acepta numeros.');
            $messages["post_create.telefono.max"] = __('El campo telefono no debe ser mayor a 11 digitos.');
            return $messages;
        } else if ($this->actualizar ) {

            $messages["post_update.tipo_pago_id.required"] = __('El campo Metodo es obligatorio.');
            $messages["post_update.tipo_pago_id.integer"] = __('El campo Metodo debe ser un numero .');
            $messages["post_update.banco_id.required"] = __('El campo Banco no debe ser mayor a 49 letras.');
            $messages["post_update.banco_id.integer"] = __('El campo Banco debe ser un numero.');
            $messages["post_update.estado.required"] = __('Este campo es obligatorio.');
            $messages["post_update.n°_cuenta.required"] = __('El n° de cuenta es obligatorio.');
            $messages["post_update.n°_cuenta.string"] = __('El n° de cuenta debe ser una cadena de texto.');
            $messages["post_update.n°_cuenta.regex"] = __('Este campo solo acepta numeros.');
            $messages["post_update.propietario.required"] = __('El campo propietario es obligatorio.');
            $messages["post_update.propietario.string"] = __('El campo propietario debe ser una cadena de texto.');
            $messages["post_update.propietario.max"] = __('El campo propietario de debe ser mayor a 49 digitos.');
            $messages["post_update.propietario.regex"] = __('El campo cantidad solo acepta letras.');
            $messages["post_update.ABA.required"] = __('El ABA es obligatorio.');
            $messages["post_update.ABA.string"] = __('El ABA debe ser una cadena de texto.');
            $messages["post_update.ABA.regex"] = __('Este campo solo acepta numeros.');
            $messages["post_update.SWIT.required"] = __('El SWIT es obligatorio.');
            $messages["post_update.SWIT.string"] = __('El SWIT debe ser una cadena de texto.');
            $messages["post_update.SWIT.regex"] = __('Este campo solo acepta numeros.');
            $messages["post_update.correo.required"] = __('El campo correo es obligatorio.');
            $messages["post_update.correo.email"] = __('El campo correo debe tener la sintaxis correcta.');

            $messages["post_update.cedula.required"] = __('El campo cedula es obligatorio.');
            $messages["post_update.cedula.string"] = __('El campo cedula debe ser una cadena de texto.');
            $messages["post_update.cedula.regex"] = __('Este campo solo acepta numeros.');
            $messages["post_update.cedula.max"] = __('El campo cedula no debe ser mayor a 8 digitos.');

            $messages["post_update.telefono.required"] = __('El campo telefono es obligatorio.');
            $messages["post_update.telefono.string"] = __('El campo telefono debe ser una cadena de texto.');
            $messages["post_update.telefono.regex"] = __('Este campo solo acepta numeros.');
            $messages["post_update.telefono.max"] = __('El campo telefono no debe ser mayor a 11 digitos.');
            return $messages;
        } else {
            return [];
        }
    }

    public function render()
    {
        $nameMetodo = metodo_pago::select('metodo_pagos.*', 'tipo_pagos.nombre as tipo_pago', 'bancos.nombre as banco', 'bancos.logo as logo')->join('tipo_pagos', 'metodo_pagos.tipo_pago_id', '=', 'tipo_pagos.id')->join('bancos', 'metodo_pagos.banco_id', '=', 'bancos.id')

            ->orderBy('created_at', 'desc')->paginate(5);

        return view('livewire.administrar.admin-metodo', [
            'posts' => $nameMetodo
        ]);
    }
}
