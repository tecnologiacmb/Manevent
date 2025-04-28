<?php

namespace App\Livewire;

use App\Models\inscripcion;
use App\Models\numero;
use App\Models\recorrido;
use App\Models\mesa;
use App\Models\grupo;
use App\Models\categoriaHabilitada;
use App\Models\metodo_pago;
use App\Models\prenda;
use Carbon\Carbon;
use Livewire\Component;

class VistaInscripcion extends Component
{
    public $post_edit_id;
    public $participantes = null;
    public $estados;
    public $ciudad;
    public $numeros;
    public $post;
    public $recorridos;
    public $clasificacions;
    public $mesas;
    public $grupos;
    public $categoria_habilitada;
    public $metodo_pago;
    public $datos;
    public $prendas;
    public $fecha_actual;

    protected $listeners = ['delete'];
    public $post_update = [
        'evento_id' => null,
        'participante_id' => null,
        'metodo_pago_id' => null,
        'grupo_id' => null,
        'grupo_precio' => null,
        'dolar_id' => null,
        'numero_id' => null,
        'categoria_habilitada_id' => null,
        'mesa_id' => null,
        'datos' => [],
        'ip' => null,
        'nomenclatura' => null,
        'recorrido_id' => null,
        'recorrido_id_grupos' => null,
        'created_at' => "",
        'monto_Bs' => null,
        'monto_USD' => null,
        'monto_mixto_Bs' => null,
        'monto_mixto_USD' => null,
        'fecha' => null,
        'fecha_mixto' => null,
        'referencia' => null,
        'referencia_mixto' => null,
        'cuenta_mixto_1' => null,
        'cuenta_mixto_2' => null,
        'prenda_id' => null,
        'monto_a_pagar_bs' => null,

    ];
    public function mount($id = null)
    {
        if (!is_null($id)) {
            $this->post_edit_id = $id;
            $this->recorridos = recorrido::select('id', 'nombre')->whereBetween('id', [1, 3])->get();
            $this->clasificacions = recorrido::select('id', 'nombre')->whereBetween('id', [1, 2])->get();
            $this->fecha_actual = Carbon::now()->format('Y-m-d');
            $this->mesas = mesa::select('id', 'nombre')->where('estado', true)->get();
            $this->categoria_habilitada = categoriaHabilitada::select('id', 'nombre')->get();
            // Obtener la inscripción y sus detalles relacionados
            $this->post = inscripcion::select('inscripcions.*', 'prendas.id as prenda_id', 'numeros.id as id_numero', 'eventos.nombre as evento_nombre', 'participantes.cedula as participante_cedula', 'tipo_pagos.nombre as metodo', 'grupos.id as grupo_id', 'grupos.precio as grupo_precio', 'mesas.id as mesa_id', 'recorridos.id as recorrido_id', 'categoria_habilitadas.id as id_category', 'dolars.precio as precio')->join('eventos', 'inscripcions.evento_id', '=', 'eventos.id')->join('participantes', 'inscripcions.participante_id', '=', 'participantes.id')->join('metodo_pagos', 'inscripcions.metodo_pago_id', '=', 'metodo_pagos.id')->join('grupos', 'inscripcions.grupo_id', '=', 'grupos.id')->join('mesas', 'inscripcions.mesa_id', '=', 'mesas.id')->join('recorridos', 'inscripcions.recorrido_id', '=', 'recorridos.id')->join('categoria_habilitadas', 'inscripcions.categoria_habilitada_id', '=', 'categoria_habilitadas.id')->join('tipo_pagos', 'metodo_pagos.tipo_pago_id', '=', 'tipo_pagos.id')->join('prendas', 'inscripcions.prenda_id', '=', 'prendas.id')->join('dolars', 'inscripcions.dolar_id', '=', 'dolars.id')->join('numeros', 'inscripcions.numero_id', '=', 'numeros.id')->find($this->post_edit_id);
            // Rellenar los detalles de la inscripción
            $this->post_update["evento_id"] = $this->post->evento_nombre;
            $this->post_update["participante_id"] = $this->post->participante_cedula;
            $this->post_update["metodo_pago_id"] = $this->post->metodo_pago_id;
            $this->post_update["grupo_id"] = $this->post->grupo_id;
            $this->post_update["grupo_precio"] = $this->post->grupo_precio;
            $this->post_update["dolar_id"] = $this->post->dolar_id;
            $this->post_update["numero_id"] = $this->post->numero_id;
            $this->post_update["numero"] = $this->post->id_numero;
            $this->post_update["prenda_id"] = $this->post->prenda_id;
            $this->post_update["categoria_habilitada_id"] = $this->post->categoria_habilitada_id;
            $this->post_update["mesa_id"] = $this->post->mesa_id;
            $this->post_update["datos"] = json_decode($this->post->datos, true);
            $this->datos = $this->post_update["datos"];
            $this->post_update["monto_a_pagar_bs"] = $this->post->monto_a_pagar_bs;
            $this->post_update["ip"] = $this->post->ip;
            $this->post_update["nomenclatura"] = $this->post->nomenclatura;
            $this->post_update["recorrido_id"] = $this->post->recorrido_id;
            $this->post_update["recorrido_id_grupos"] = $this->post->recorrido_id_grupos;
            $this->update_grupos($this->post->recorrido_id_grupos);
            $this->post_update["created_at"] = \Carbon\Carbon::parse($this->post->created_at)->format('Y-m-d');
            // Obtener el último dígito de la cédula del participante
            if ($this->post->recorrido_id == 1) {
                $this->cargar_numeros_caminata();
            } elseif ($this->post->recorrido_id == 2) {
                $this->cargar_numeros_carrera();
            } else {
                echo 'No hay Nada';
            }
        }
    }

    public function cargar_numeros_otro()
    {
        $this->numeros = numero::where('disponible', true)->where('estado', true)->whereBetween('id', [501, 700])->orderBy('id', 'asc')->get();
    }
    public function updatedPostUpdateRecorridoIdGrupos($value)
    {
        $this->update_grupos($value);
    }
    public function updatedPostUpdateRecorridoId($value)
    {
        $inscripcion = inscripcion::find($this->post_edit_id);
        if ($inscripcion->recorrido_id == 1) {
            $this->cargar_numeros_caminata();
        } elseif ($inscripcion->recorrido_id == 2) {
            $this->cargar_numeros_carrera();
        } else {
            $this->cargar_numeros_otro();
        }
    }
    public function updatedPostUpdateDatos($value, $name)
    {
        $parts = explode('.', $name);
        $field = $parts[2];
        if ($field === 'monto_Bs') {
            $this->post_update['datos']['monto_USD'] = null;
        } elseif ($field === 'monto_USD') {
            $this->post_update['datos']['monto_Bs'] = null;
        } elseif ($field === 'monto_mixto_Bs') {
            $this->post_update['datos']['monto_mixto_USD'] = null;
        } elseif ($field === 'monto_mixto_USD') {
            $this->post_update['datos']['monto_mixto_Bs'] = null;
        }
    }
    public function cargar_numeros_caminata()
    {

        $ultimo_digito = substr($this->post->participante_cedula, -1);
        // Seleccionar los números disponibles y con estado verdadero según el último dígito
        switch ($ultimo_digito) {
            case '0':
            case '1':
            case '2':
            case '3':
            case '4':
                $this->numeros = numero::where('disponible', true)->where('estado', true)->whereBetween('id', [701, 850])->orderBy('id', 'asc')->get();
                break;
            case '5':
            case '6':
            case '7':
            case '8':
            case '9':
                $this->numeros = numero::where('disponible', true)->where('estado', true)->whereBetween('id', [851, 999])->orderBy('id', 'asc')->get();
                break;
        }
    }
    public function cargar_numeros_carrera()
    {

        $ultimo_digito = substr($this->post->participante_cedula, -1);
        // Seleccionar los números disponibles y con estado verdadero según el último dígito
        switch ($ultimo_digito) {
            case '0':
            case '1':
                $this->numeros = numero::where('disponible', true)->where('estado', true)->whereBetween('id', [1, 100])->orderBy('id', 'asc')->get();
                break;
            case '2':
            case '3':
                $this->numeros = numero::where('disponible', true)->where('estado', true)->whereBetween('id', [101, 200])->orderBy('id', 'asc')->get();
                break;
            case '4':
            case '5':
                $this->numeros = numero::where('disponible', true)->where('estado', true)->whereBetween('id', [201, 300])->orderBy('id', 'asc')->get();
                break;
            case '6':
            case '7':
                $this->numeros = numero::where('disponible', true)->where('estado', true)->whereBetween('id', [301, 400])->orderBy('id', 'asc')->get();
                break;
            case '8':
            case '9':
                $this->numeros = numero::where('disponible', true)->where('estado', true)->whereBetween('id', [401, 500])->orderBy('id', 'asc')->get();
                break;
        }
    }
    public function update_grupos($value)
    {
        if ($value == 1) {
            $this->grupos = grupo::where('recorrido_id', $value)->get();
        } else if ($value == 2) {
            $this->grupos = grupo::where('recorrido_id', $value)->get();
        } else if ($value == 3) {
            $this->grupos = Grupo::where('recorrido_id', $value)->get();
        }
    }
    public function update()
    {
        $this->validate();
        $posts = inscripcion::find($this->post_edit_id);
        $datos = $this->datos;
        $datos['fecha'] = $this->post_update['datos']['fecha'];
        $datos['referencia'] = $this->post_update['datos']['referencia'];
        if (isset($this->post_update['datos']['monto_Bs'])) {
            $datos['monto_Bs'] = $this->post_update['datos']['monto_Bs'];
        } else {
            $datos['monto_USD'] = $this->post_update['datos']['monto_USD'];
        }
        if (isset($this->post_update['datos']['fecha_mixto'])) {
            $datos['fecha_mixto'] = $this->post_update['datos']['fecha_mixto'];
            $datos['referencia_mixto'] = $this->post_update['datos']['referencia_mixto'];
            $datos['cuenta_mixto_1'] = $this->post_update['datos']['cuenta_mixto_1'];
            $datos['cuenta_mixto_2'] = $this->post_update['datos']['cuenta_mixto_2'];
            if (isset($this->post_update['datos']['monto_mixto_Bs'])) {
                $datos['monto_mixto_Bs'] = $this->post_update['datos']['monto_mixto_Bs'];
            } else {
                $datos['monto_mixto_USD'] = $this->post_update['datos']['monto_mixto_USD'];
            }
        }
        // Codificar el array datos a JSON
        $datosJson = json_encode($datos);
        $posts->update([
            'metodo_pago_id' => $this->post_update['metodo_pago_id'],
            'grupo_id' => $this->post_update['grupo_id'],
            'recorrido_id' => $this->post_update['recorrido_id'],
            'recorrido_id_grupos' => $this->post_update['recorrido_id_grupos'],
            'categoria_habilitada_id' => $this->post_update['categoria_habilitada_id'],
            'mesa_id' => $this->post_update['mesa_id'],
            'numero_id' => $this->post_update['numero_id'],
            'created_at' => $this->post_update['created_at'],
            'prenda_id' => $this->post_update['prenda_id'],
            'datos' => $datosJson, // Guardar el JSON codificado
        ]);
        $this->dispatch('alert_update');
    }
    public function rules(): array
    {
        $rules["post_update.recorrido_id_grupos"] = 'required|integer';
        $rules["post_update.recorrido_id"] = 'required|integer';
        $rules["post_update.categoria_habilitada_id"] = 'required|integer';
        $rules["post_update.mesa_id"] = 'required|integer';
        $rules["post_update.numero_id"] = 'required|integer';
        $rules["post_update.grupo_id"] = 'required|integer';
        $rules["post_update.prenda_id"] = 'required|integer';

        if (!isset($this->post_update['datos']['fecha_mixto'])) {
            $rules["post_update.metodo_pago_id"] = 'required|integer';
            $rules["post_update.datos.fecha"] = 'required|date|before_or_equal:' . $this->fecha_actual;
            $rules["post_update.datos.referencia"] = 'required|numeric|digits:6';

            if (isset($this->post_update['datos']['monto_Bs'])) {
                $rules["post_update.datos.monto_Bs"] = 'required|numeric';
            } else {
                $rules["post_update.datos.monto_USD"] = 'required|numeric';
            }
        } else {
            $rules["post_update.datos.fecha"] = 'required|date|before_or_equal:' . $this->fecha_actual;
            $rules["post_update.datos.referencia"] = 'required|numeric|digits:6';
            $rules["post_update.datos.fecha_mixto"] = 'required|date|before_or_equal:' . $this->fecha_actual;
            $rules["post_update.datos.referencia_mixto"] = 'required|numeric|digits:6';
            $rules["post_update.datos.cuenta_mixto_1"] = 'required|string';
            $rules["post_update.datos.cuenta_mixto_2"] = 'required|string';

            if (isset($this->post_update['datos']['monto_Bs'])) {
                $rules["post_update.datos.monto_Bs"] = 'required|numeric';
            } else {
                $rules["post_update.datos.monto_USD"] = 'required|numeric';
            }

            if (isset($this->post_update['datos']['monto_mixto_Bs'])) {
                $rules["post_update.datos.monto_mixto_Bs"] = 'required|numeric';
            } else {
                $rules["post_update.datos.monto_mixto_USD"] = 'required|numeric';
            }
        }
        return $rules;
    }
    public function messages(): array
    {
        $messages["post_update.recorrido_id_grupos.required"] = __('El campo recorrido es obligatorio.');
        $messages["post_update.recorrido_id_grupos.integer"] = __('El campo recorrido debe ser un numero.');
        $messages["post_update.recorrido_id.required"] = __('El campo recorrido es obligatorio.');
        $messages["post_update.recorrido_id.integer"] = __('El campo recorrido debe ser un numero.');
        $messages["post_update.categoria_habilitada_id.required"] = __('El campo categoria es obligatorio.');
        $messages["post_update.categoria_habilitada_id.integer"] = __('El campo categoria debe ser un numero.');
        $messages["post_update.mesa_id.required"] = __('El campo mesa es obligatorio.');
        $messages["post_update.mesa_id.integer"] = __('El campo mesa debe ser un numero.');
        $messages["post_update.numero_id.required"] = __('El campo numero es obligatorio.');
        $messages["post_update.numero_id.integer"] = __('El campo numero debe ser un numero.');
        $messages["post_update.grupo_id.required"] = __('El campo grupo es obligatorio.');
        $messages["post_update.grupo_id.integer"] = __('El campo grupo debe ser un numero.');
        $messages["post_update.prenda_id.required"] = __('El campo prenda es obligatorio.');
        $messages["post_update.prenda_id.integer"] = __('El campo prenda debe ser un numero.');
        $messages["post_update.metodo_pago_id.required"] = __('El campo cuentas es obligatorio.');
        $messages["post_update.metodo_pago_id.integer"] = __('El campo ciudad debe ser un numero.');
        $messages["post_update.datos.monto_Bs.required"] = __('El campo monto Bs es obligatorio.');
        $messages["post_update.datos.monto_Bs.numeric"] = __('El campo monto Bs solo permite numeros.');
        $messages["post_update.datos.monto_USD.required"] = __('El campo monto USD es obligatorio.');
        $messages["post_update.datos.monto_USD.numeric"] = __('El campo monto USD solo permite numeros.');
        $messages["post_update.datos.fecha.required"] = __('El campo fecha de pago es obligatorio.');
        $messages["post_update.datos.fecha.date"] = __('El campo fecha de pago debe tener la sintaxis correcta.');
        $messages["post_update.datos.fecha.before_or_equal"] = __('El campo fecha de pago debe ser menor o igual a ' . Carbon::parse($this->fecha_actual)->format('d-m-Y'));
        $messages["post_update.datos.referencia.required"] = __('El campo referencia es obligatorio.');
        $messages["post_update.datos.referencia.numeric"] = __('El campo referencia solo permite numeros.');
        $messages["post_update.datos.referencia.digits"] = __('El campo referencia solo admite 6 digitos');
        $messages["post_update.datos.monto_mixto_Bs.required"] = __('El campo monto es obligatorio.');
        $messages["post_update.datos.monto_mixto_Bs.numeric"] = __('El campo monto solo permite numeros.');
        $messages["post_update.datos.monto_mixto_USD.required"] = __('El campo monto es obligatorio.');
        $messages["post_update.datos.monto_mixto_USD.numeric"] = __('El campo monto solo permite numeros.');
        $messages["post_update.datos.fecha_mixto.required"] = __('El campo fecha de pago es obligatorio.');
        $messages["post_update.datos.fecha_mixto.date"] = __('El campo fecha de pago debe tener la sintaxis correcta.');
        $messages["post_update.datos.fecha_mixto.before_or_equal"] = __('El campo fecha de pago debe ser menor o igual a ' . Carbon::parse($this->fecha_actual)->format('d-m-Y'));
        $messages["post_update.datos.referencia_mixto.required"] = __('El campo referencia es obligatorio.');
        $messages["post_update.datos.referencia_mixto.numeric"] = __('El campo referencia solo permite numeros.');
        $messages["post_update.datos.referencia_mixto.digits"] = __('El campo referencia solo admite los ultimos 6 digitos');
        $messages["post_update.datos.cuenta_mixto_1.required"] = __('El campo cuenta es obligatorio.');
        $messages["post_update.datos.cuenta_mixto_1.string"] = __('El campo cuenta debe ser una cadena de texto. ');
        $messages["post_update.datos.cuenta_mixto_2.required"] = __('El campo cuenta es obligatorio.');
        $messages["post_update.datos.cuenta_mixto_2.string"] = __('El campo cuenta debe ser una cadena de texto. ');
        return $messages;
    }
    public function confirm_delete($delete_id)
    {
        $this->dispatch('alert_delete', $delete_id);
    }
    public function delete($delete_id)
    {
        $post = inscripcion::find($delete_id);
        $post->delete();
    }
    public function cargar_modulos()
    {
        $this->metodo_pago = metodo_pago::select('metodo_pagos.*', 'tipo_pagos.nombre as tipo_pago_nombre', 'bancos.nombre as banco_nombre')->join('tipo_pagos', 'metodo_pagos.tipo_pago_id', '=', 'tipo_pagos.id')->join('bancos', 'metodo_pagos.banco_id', '=', 'bancos.id')->get();

        $this->prendas = prenda::join('prenda_categories', 'prendas.prenda_category_id', '=', 'prenda_categories.id')->join('prenda_tallas', 'prendas.prenda_talla_id', '=', 'prenda_tallas.id')->select('prendas.*', 'prenda_categories.nombre as categoria', 'prenda_tallas.talla as talla')->get();
    }
    public function render()
    {
        $this->cargar_modulos();
        $recorridoId = $this->post_update['recorrido_id'];
        $grupo = grupo::select('id', 'nombre', 'precio')
            ->whereRaw("nombre NOT LIKE ?", ['%sin franela%'])
            ->where('recorrido_id', $recorridoId)
            ->get();

        return view('livewire.vista-inscripcion', [
            'grupos' => $grupo
        ]);
    }
}
