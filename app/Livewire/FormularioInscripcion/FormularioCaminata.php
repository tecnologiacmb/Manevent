<?php

namespace App\Livewire\FormularioInscripcion;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\evento;
use App\Models\participante;
use Carbon\Carbon;
use App\Models\grupo;
use App\Models\dolar;
use App\Models\numero;
use App\Models\inscripcion;
use App\Models\estado;
use App\Models\ciudad;
use App\Models\categoriaHabilitada;
use App\Models\mesa;
use App\Enum\Mesas_enum;
use SebastianBergmann\Environment\Console;

class FormularioCaminata extends Component
{
    public $evento = null;
    public $participante;
    public $metodo_pago;
    public $grupo;
    public $dolars;
    public $numero;
    public $estados;
    public $ciudad;
    public $participante_id;
    public $banco;
    public $tipo_pago;
    public $fecha_nacimiento_maxima;
    public $cantidad;
    public $opcion2 = null;
    public $opcion0 = null;
    public $opcion = null;
    public $opcion3 = null;
    public $opcion4 = null;
    public $groupId = null;

    public $ultimoParticipante;
    public $categoria_habilitada;
    public $inscripcion;
    public $numeros;
    public $mesa;
    public $metodo = null;
    public $metodos = [];
    public $ciudades = [];
    public $unico = null;
    public $mixto = null;
    public $bolivar = null;
    public $dolar = null;
    public $bolivar_mixto = null;
    public $dolar_mixto = null;
    public $unico_valor = null;
    public $mixto_valor = null;
    public $fecha_actual = null;
    public $selectedEstado = null;
    public $datos_json = [];
    public $create_participante = [
        'ciudad_id' => null,
        'estado_id' => null,
        'ciudades' => [],
        'cedula' => "",
        'nombre' => "",
        'apellido' => "",
        'telefono' => "",
        'correo' => "",
        'direccion' => "",
        'fecha_nacimiento' => "",
    ];

    public $create_inscripcion = [

        'evento_id' => null,
        'cedula' => "",
        'participante_id' => null,
        'metodo_pago_id' => null,
        'grupo_id' => null,
        'dolar_id' => null,
        'numero_id' => null,
        'mesa_id' => null,
        'datos' => null,
        'monto_pagado_bs' => "",
        'ip' => "",
        'nomenclatura' => "",
        'metodo' => null,
        'metodos' => [],
        'unico' => null,
        'mixto' => null,
        'bolivar' => null,
        'dolar' => null,
        'bolivar_mixto' => null,
        'dolar_mixto' => null,
        'monto' => null,
        'monto_mixto' => null,
        'fecha' => null,
        'fecha_mixto' => null,
        'referencia' => null,
        'referencia_mixto' => null,
        'cuenta_mixto_1' => null,
        'cuenta_mixto_2' => null,
    ];


    public function mount($id = null)
    {
        if (!is_null($id)) {

            $this->fecha_actual = Carbon::now()->format('Y-m-d');
            $this->evento = evento::select('id', 'nombre')->where('estado', true)->orderBy('id', 'desc')->first();

            $this->subtractYears();

            $this->participante = participante::all();
            $this->categoria_habilitada = categoriaHabilitada::all();

            $this->grupo = grupo::find($id);
            $this->dolars = dolar::select('id', 'precio')->whereDate('created_at', Carbon::today())->latest()->first();
            if (!$this->dolars) {
                $this->dolars = dolar::latest()->first();
            }



            $this->numeros = numero::all();
            $this->estados = estado::all();
            $this->cantidad = $this->grupo->cantidad;

            for ($i = 0; $i <= $this->cantidad - 1; $i++) {

                $this->create_participante[$i] = [
                    'ciudad_id' => null,
                    'estado_id' => null,
                    'ciudades' => [],
                    'cedula' => "",
                    'nombre' => "",
                    'apellido' => "",
                    'telefono' => "",
                    'correo' => "",
                    'direccion' => "",
                    'fecha_nacimiento' => "",
                ];


                $this->create_inscripcion[$i] = [

                    'evento_id' => $this->evento->id,
                    'cedula' => "",
                    'participante_id' => null,
                    'metodo_pago_id' => null,
                    'grupo_id' => $id,
                    'dolar_id' => $this->dolars->id,
                    'numero_id' => null,
                    'mesa_id' => null,
                    'datos' => null,
                    'monto_pagado_bs' =>  $this->calculo($this->grupo->precio),
                    'ip' => "",
                    'nomenclatura' => "",
                    'metodo' => null,
                    'metodos' => [],
                    'unico' => null,
                    'mixto' => null,
                    'bolivar' => null,
                    'dolar' => null,
                    'bolivar_mixto' => null,
                    'dolar_mixto' => null,
                    'monto' => null,
                    'monto_mixto' => null,
                    'fecha' => null,
                    'fecha_mixto' => null,
                    'referencia' => null,
                    'referencia_mixto' => null,
                    'cuenta_mixto_1' => null,
                    'cuenta_mixto_2' => null,
                ];
            }

            $this->ciudad = ciudad::all();
            $this->mesa = mesa::all();


            $this->metodo_pago = DB::table('metodo_pagos')->join('tipo_pagos', 'metodo_pagos.tipo_pago_id', '=', 'tipo_pagos.id')->join('bancos', 'metodo_pagos.banco_id', '=', 'bancos.id')->select('metodo_pagos.*', 'tipo_pagos.nombre as tipo_pago_nombre', 'bancos.nombre as banco_nombre')->get();
        }

        //$this->create_inscripcion['metodo_pago_id'] = $this->metodo_pago->id;




    }
    public function subtractYears()
    {
        $this->evento->fecha_evento = Carbon::parse($this->evento->fecha_evento)->subYears(15)->format('Y-m-d');

        $this->fecha_nacimiento_maxima = $this->evento->fecha_evento;
    }

    public function updatedCreateParticipante($value, $name)
    {
        $parts = explode('.', $name);
        $index = $parts[0];
        $field = $parts[1];
        if ($field === 'estado_id') {
            $this->create_participante[$index]['ciudades'] = ciudad::where('estado_id', $value)->get();
        }
    }

    public function updated_pago($value, $name)
    {
        $parts = explode('.', $name);
        $index = $parts[0];
        $field = $parts[1];
        return dd($value);
        if ($field === 'metodo') {
            $this->create_participante[$index]['metodos'] = $value;
        }
    }

    public function update_radio($index, $option)
    {
        if ($option === '1') {
            $this->create_inscripcion[$index]['unico'] = '1';
            $this->create_inscripcion[$index]['mixto'] = null;
        } elseif ($option === '2') {
            $this->create_inscripcion[$index]['unico'] = null;
            $this->create_inscripcion[$index]['mixto'] = '2';
        } elseif ($option === ''){
            $this->create_inscripcion[$index]['unico'] = null;
            $this->create_inscripcion[$index]['mixto'] = null;
        }
    }

    public function update_pago($index, $option)
    {
        if ($option === '1') {

            $this->create_inscripcion[$index]['bolivar'] = '1';
            $this->create_inscripcion[$index]['dolar'] = null;
        } elseif ($option === '2') {
            $this->create_inscripcion[$index]['bolivar'] = null;
            $this->create_inscripcion[$index]['dolar'] = '2';
        } elseif ($option === '') {
            $this->create_inscripcion[$index]['bolivar'] = null;
            $this->create_inscripcion[$index]['dolar'] = null;
        }
    }
    public function update_pago_mixto($index, $option)
    {
        if ($option === '1') {

            $this->create_inscripcion[$index]['bolivar_mixto'] = '1';
            $this->create_inscripcion[$index]['dolar_mixto'] = null;
        } elseif ($option === '2') {
            $this->create_inscripcion[$index]['bolivar_mixto'] = null;
            $this->create_inscripcion[$index]['dolar_mixto'] = '2';
        }
        elseif ($option === '') {
            $this->create_inscripcion[$index]['bolivar_mixto'] = null;
            $this->create_inscripcion[$index]['dolar_mixto'] = null;
        }
    }


    public function calculo($num)
    {
        $total = 0;
        $ultimoDolar = $this->dolars->latest()->first();

        $total = $num * $ultimoDolar->precio;

        return $total;
    }

    /*   public function edad($fecha_nacimiento)
    {
        $fecha_nacimiento = Carbon::parse($fecha_nacimiento);
        $ahora = Carbon::now();
        $edad = $ahora->diffInYears($fecha_nacimiento);

        foreach ($this->categoria_habilitada as $categoria_habilitadas) {
            if ($edad >= $categoria_habilitadas->edad_min && $edad <= $categoria_habilitadas->edad_max) {
                return $categoria_habilitadas->id;
            }
        }
        return null;
    } */

    public function asignar_num_mesa($inscripcion_id, $cedula)
    {
        $ultimo_digito = substr($cedula, -1);

        $this->inscripcion = inscripcion::find($inscripcion_id);
        if ($ultimo_digito == '0' || $ultimo_digito == '1' || $ultimo_digito == '2' || $ultimo_digito == '3' || $ultimo_digito == '4') {

            $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [701, 850])->orderBy('id', 'asc')->first();

            if (!is_null($numero_id)) {

                $this->inscripcion->numero_id = $numero_id->id;
                $this->inscripcion->mesa_id = Mesas_enum::Mesa_6;
                $this->inscripcion->save();
                /* update numero asignado */
                $this->numero = numero::find($numero_id->id);
                $this->numero->disponible = false;
                $this->numero->save();
            } else {
                $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [501, 700])->orderBy('id', 'asc')->first();
                $this->inscripcion->numero_id = $numero_id->id;
                $this->inscripcion->mesa_id = Mesas_enum::Mesa_8;
                $this->inscripcion->save();
                /* update numero asignado */
                $this->numero = numero::find($numero_id->id);
                $this->numero->disponible = false;
                $this->numero->save();
            }


            /* logica asignacion de numeros y mesa*/
        } else if ($ultimo_digito == '5' || $ultimo_digito == '6' || $ultimo_digito == '7' || $ultimo_digito == '8' || $ultimo_digito == '9') {
            $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [851, 999])->orderBy('id', 'asc')->first();
            if (!is_null($numero_id)) {
                $this->inscripcion->numero_id = $numero_id->id;
                $this->inscripcion->mesa_id = Mesas_enum::Mesa_7;
                $this->inscripcion->save();
                /* update numero asignado */
                $this->numero = numero::find($numero_id->id);
                $this->numero->disponible = false;
                $this->numero->save();
            } else {
                $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [501, 700])->orderBy('id', 'asc')->first();
                $this->inscripcion->numero_id = $numero_id->id;
                $this->inscripcion->mesa_id = Mesas_enum::Mesa_8;
                $this->inscripcion->save();
                /* update numero asignado */
                $this->numero = numero::find($numero_id->id);
                $this->numero->disponible = false;
                $this->numero->save();
            }

            /* logica asignacion de numeros y mesa*/
        }
    }
    public function rules(): array
    {
        $rules = [];
        for ($i = 0; $i <= $this->grupo->cantidad - 1; $i++) {
            $rules["create_participante.$i.ciudad_id"] = 'required|string|max:3';
            $rules["create_participante.$i.cedula"] = 'required|string|max:8|regex:/^[0-9]+$/';
            $rules["create_participante.$i.nombre"] = 'required|string|max:25|regex:/^[a-zA-Z\s]+$/';
            $rules["create_participante.$i.apellido"] = 'required|string|max:25|regex:/^[a-zA-Z\s]+$/';
            $rules["create_participante.$i.telefono"] = 'required|string|max:11|regex:/^[0-9]+$/';
            $rules["create_participante.$i.correo"] = 'required|email|max:60';
            $rules["create_participante.$i.direccion"] = 'required|string|max:60|regex:/^[a-zA-Z0-9\s]+$/';
            $rules["create_participante.$i.fecha_nacimiento"] = 'required|date|before_or_equal:' . $this->fecha_nacimiento_maxima;



            if ( !is_null($this->create_inscripcion[$i]['unico'])) {

                $rules["create_inscripcion.$i.metodo_pago_id"] = 'required|integer|max:3';
                $rules["create_inscripcion.$i.monto"] = 'required|numeric';
                $rules["create_inscripcion.$i.fecha"] = 'required|date|before_or_equal:' . $this->fecha_actual;
                $rules["create_inscripcion.$i.referencia"] = 'required|numeric|digits:6';
            }else {

                $rules["create_inscripcion.$i.monto"] = 'required|numeric';
                $rules["create_inscripcion.$i.fecha"] = 'required|date|before_or_equal:' . $this->fecha_actual;
                $rules["create_inscripcion.$i.referencia"] = 'required|numeric|digits:6';
                $rules["create_inscripcion.$i.monto_mixto"] = 'required|numeric';
                $rules["create_inscripcion.$i.fecha_mixto"] = 'required|date|before_or_equal:' . $this->fecha_actual;
                $rules["create_inscripcion.$i.referencia_mixto"] = 'required|numeric|min:6|max:6';
                $rules["create_inscripcion.$i.cuenta_mixto_1"] = 'required|string';
                $rules["create_inscripcion.$i.cuenta_mixto_2"] = 'required|string';
            }


        }
        return $rules;
    }
    public function messages(): array
    {
        $messages = [];
        for ($i = 0; $i <= $this->grupo->cantidad - 1; $i++) {
            $messages["create_participante.$i.ciudad_id.required"] = __('El campo ciudad es obligatorio.');
            $messages["create_participante.$i.cedula.required"] = __('El campo cedula es obligatorio.');
            $messages["create_participante.$i.cedula.string"] = __('El campo cedula debe ser una cadena de texto numerico.');
            $messages["create_participante.$i.cedula.max"] = __('El campo cedula no debe ser mayor a 8 caracteres.');
            $messages["create_participante.$i.cedula.regex"] = __('El campo cedula solo acepta numeros.');
            $messages["create_participante.$i.nombre.required"] = __('El campo nombre es obligatorio.');
            $messages["create_participante.$i.nombre.string"] = __('El campo nombre debe ser una cadena de texto.');
            $messages["create_participante.$i.nombre.max"] = __('El campo nombre no debe ser mayor a 25 caracteres.');
            $messages["create_participante.$i.nombre.regex"] = __('El campo nombre no acepta caracteres especiales.');
            $messages["create_participante.$i.apellido.required"] = __('El campo apellido es obligatorio.');
            $messages["create_participante.$i.apellido.string"] = __('El campo apellido debe ser una cadena de texto.');
            $messages["create_participante.$i.apellido.max"] = __('El campo apellido no debe ser mayor a 25 caracteres.');
            $messages["create_participante.$i.apellido.regex"] = __('El campo apellido no acepta caracteres especiales.');
            $messages["create_participante.$i.telefono.required"] = __('El campo telefono es obligatorio.');
            $messages["create_participante.$i.telefono.string"] = __('El campo telefono debe ser una cadena de texto.');
            $messages["create_participante.$i.telefono.max"] = __('El campo telefono no debe ser mayor a 10 caracteres.');
            $messages["create_participante.$i.telefono.regex"] = __('El campo telefono solo acepta numeros.');
            $messages["create_participante.$i.correo.required"] = __('El campo correo es obligatorio.');
            $messages["create_participante.$i.correo.email"] = __('El campo correo debe tener la sintaxis correcta.');
            $messages["create_participante.$i.correo.max"] = __('El campo correo no debe ser mayor a 60 caracteres.');
            $messages["create_participante.$i.direccion.required"] = __('El campo direccion es obligatorio.');
            $messages["create_participante.$i.direccion.string"] = __('El campo direccion debe ser una cadena de texto.');
            $messages["create_participante.$i.direccion.max"] = __('El campo direccion no debe ser mayor a 60 caracteres.');
            $messages["create_participante.$i.direccion.regex"] = __('El campo direccion no acepta caracteres especiales.');
            $messages["create_participante.$i.fecha_nacimiento.required"] = __('El campo fecha de nacimiento es obligatorio.');
            $messages["create_participante.$i.fecha_nacimiento.date"] = __('El campo fecha de nacimiento debe ser de tipo fecha');
            $messages["create_participante.$i.fecha_nacimiento.before_or_equal"] = __('El campo fecha de nacimiento debe ser menor o igual a ' . $this->fecha_nacimiento_maxima = Carbon::parse($this->evento->fecha_evento)->format('d-m-Y'));

            $messages["create_inscripcion.$i.metodo_pago_id.required"] = __('El campo cuentas es obligatorio.');
            $messages["create_inscripcion.$i.metodo_pago_id.integer"] = __('El campo cuentas debe ser un entero.');
            $messages["create_inscripcion.$i.metodo_pago_id.max"] = __('El campo cuentas no debe ser mayor a 3 caracteres ');
            $messages["create_inscripcion.$i.monto.required"] = __('El campo monto es obligatorio.');
            $messages["create_inscripcion.$i.monto.numeric"] = __('El campo monto solo permite numeros.');
            $messages["create_inscripcion.$i.fecha.required"] = __('El campo fecha de pago es obligatorio.');
            $messages["create_inscripcion.$i.fecha.date"] = __('El campo fecha de pago debe tener la sintaxis correcta.');
            $messages["create_inscripcion.$i.fecha.before_or_equal"] = __('El campo fecha de pago debe ser menor o igual a ' . $this->fecha_nacimiento_maxima = Carbon::parse($this->fecha_actual)->format('d-m-Y'));
            $messages["create_inscripcion.$i.referencia.required"] = __('El campo referencia es obligatorio.');
            $messages["create_inscripcion.$i.referencia.numeric"] = __('El campo referencia solo permite numeros.');
            $messages["create_inscripcion.$i.referencia.digits"] = __('El campo referencia solo admite 6 digitos');


            $messages["create_inscripcion.$i.monto_mixto.required"] = __('El campo monto es obligatorio.');
            $messages["create_inscripcion.$i.monto_mixto.numeric"] = __('El campo monto solo permite numeros.');
            $messages["create_inscripcion.$i.fecha_mixto.required"] = __('El campo fecha de pago es obligatorio.');
            $messages["create_inscripcion.$i.fecha_mixto.date"] = __('El campo fecha de pago debe tener la sintaxis correcta.');
            $messages["create_inscripcion.$i.fecha_mixto.before_or_equal"] = __('El campo fecha de pago debe ser menor o igual a ' . $this->fecha_nacimiento_maxima = Carbon::parse($this->fecha_actual)->format('d-m-Y'));

            $messages["create_inscripcion.$i.referencia_mixto.required"] = __('El campo referencia es obligatorio.');
            $messages["create_inscripcion.$i.referencia_mixto.numeric"] = __('El campo referencia solo permite numeros.');
            $messages["create_inscripcion.$i.referencia_mixto.digits"] = __('El campo referencia solo admite los ultimos 6 digitos');


            $messages["create_inscripcion.$i.cuenta_mixto_1.required"] = __('El campo cuenta es obligatorio.');
            $messages["create_inscripcion.$i.cuenta_mixto_1.string"] = __('El campo cuenta debe ser una cadena de texto. ');
            $messages["create_inscripcion.$i.cuenta_mixto_2.required"] = __('El campo cuenta es obligatorio.');
            $messages["create_inscripcion.$i.cuenta_mixto_2.string"] = __('El campo cuenta debe ser una cadena de texto. ');
        }
        return $messages;
    }


    public function save()
    {
        /* return dd( $this->create_participante[0]['ciudad_id'],$this->create_participante[1]['ciudad_id']); */
        $this->validate();
        for ($i = 0; $i <= $this->grupo->cantidad - 1; $i++) {
            $participante = participante::create([
                'ciudad_id' => $this->create_participante[$i]['ciudad_id'],
                'cedula' => $this->create_participante[$i]['cedula'],
                'nombre' => $this->create_participante[$i]['nombre'],
                'apellido' => $this->create_participante[$i]['apellido'],
                'telefono' => $this->create_participante[$i]['telefono'],
                'correo' => $this->create_participante[$i]['correo'],
                'direccion' => $this->create_participante[$i]['direccion'],
                'fecha_nacimiento' => $this->create_participante[$i]['fecha_nacimiento'],

            ]);

            $latestId = participante::latest('id')->first()->id;
            $this->create_inscripcion[$i]['participante_id'] = $latestId;
            $ultimoParticipante = participante::find($latestId);


            $datos_json = [
                'monto' => $this->create_inscripcion[$i]['monto'],
                'fecha' => $this->create_inscripcion[$i]['fecha'],
                'referencia' => $this->create_inscripcion[$i]['referencia']
            ];

            if (!is_null($this->create_inscripcion[$i]['monto_mixto'])) {
                $datos_json += [
                    'monto_mixto' => $this->create_inscripcion[$i]['monto_mixto'],
                    'fecha_mixto' => $this->create_inscripcion[$i]['fecha_mixto'],
                    'referencia_mixto' => $this->create_inscripcion[$i]['referencia_mixto'],
                    'cuenta_mixto_1' => $this->create_inscripcion[$i]['cuenta_mixto_1'],
                    'cuenta_mixto_2' => $this->create_inscripcion[$i]['cuenta_mixto_2']
                ];
            }
            $datos_json = json_encode($datos_json);

            $this->create_inscripcion[$i]['datos'] = $datos_json;
            // return dd($this->create_inscripcion[$i]['datos']);





            if (is_null($this->create_inscripcion[$i]['metodo_pago_id'])) {
                $this->create_inscripcion[$i]['metodo_pago_id'] = 3;
            }


            $inscripciones = inscripcion::create([
                'evento_id' => $this->create_inscripcion[$i]['evento_id'],
                'participante_id' => $this->create_inscripcion[$i]['participante_id'],
                'metodo_pago_id' => $this->create_inscripcion[$i]['metodo_pago_id'],
                'grupo_id' => $this->create_inscripcion[$i]['grupo_id'],
                'dolar_id' => $this->create_inscripcion[$i]['dolar_id'],
                'numero_id' => $this->create_inscripcion[$i]['numero_id'],

                'mesa_id' => $this->create_inscripcion[$i]['mesa_id'],
                'datos' => $this->create_inscripcion[$i]['datos'],
                'monto_pagado_bs' => $this->create_inscripcion[$i]['monto_pagado_bs'],
                'ip' => $this->create_inscripcion[$i]['ip'],
                'nomenclatura' => $this->create_inscripcion[$i]['nomenclatura'],

            ]);

            $ultima_inscripcion_id = inscripcion::latest('id')->first()->id;

            $this->asignar_num_mesa($ultima_inscripcion_id, $this->create_participante[$i]['cedula']);
        }

        $this->create_participante = [];
        $this->create_inscripcion = [];
    }

    public function render()
    {
        return view('livewire.formulario-inscripcion.formulario-caminata');
    }
}
