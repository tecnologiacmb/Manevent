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
use App\Models\recorrido;
use App\Models\prenda;
use App\Models\genero;
use App\Enum\Mesas_enum;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormularioCaminata extends Component
{
    public $evento = null;
    public $prendas;
    public $inscripcion_validate_global = [];
    public $metodo_pago;
    public $grupo;
    public $dolars;
    public $numero;
    public $estados;
    public $ciudad;
    public $participantes_ids = [];
    public $banco;
    public $cantidad;
    public $ultimoParticipante;
    public $categoria_habilitada;
    public $inscripcion;
    public $numeros;
    public $mesa;
    public $fecha_evento;
    public $fecha_actual = null;
    public $cedula = null;
    public $nombre = null;
    public $userIp;
    public $recorrido;
    public $nomenclatura;
    public $nuevoNumeroOrden = null;
    public $generos = null;
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
        'genero_id' => null,

    ];
    public $participante = [];
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
        'numero_orden' => null,
        'recorrido_id' => null,
        'recorrido_id_grupos' => null,
        'prenda_id' => null,

    ];
    public $create_prendas = [
        'prendas' => null,
        'genero' => null
    ];

    public function mount($id = null)
    {
        if (!is_null($id)) {
            $this->userIp = request()->ip();
            $this->recorrido = recorrido::all();
            $this->fecha_actual = Carbon::now()->format('Y-m-d');
            $this->evento = evento::select('id', 'nombre', 'fecha_evento')->where('estado', true)->orderBy('id', 'desc')->first();

            $this->subtractYears();
            $this->categoria_habilitada = categoriaHabilitada::all();
            $this->generos = genero::all();
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
                    'genero_id' => null,

                ];
                $this->participante[$i] = [];
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
                    'numero_orden' => null,
                    'recorrido_id' => null,
                    'recorrido_id_grupos' => null,
                    'prenda_id' => null,
                ];
                $this->create_prendas[$i] = [
                    'prendas' => null,
                    'genero' => null
                ];
            }

            $this->ciudad = ciudad::all();
            $this->mesa = mesa::all();
            $this->metodo_pago = DB::table('metodo_pagos')->join('tipo_pagos', 'metodo_pagos.tipo_pago_id', '=', 'tipo_pagos.id')->join('bancos', 'metodo_pagos.banco_id', '=', 'bancos.id')->select('metodo_pagos.*', 'tipo_pagos.nombre as tipo_pago_nombre', 'bancos.nombre as banco_nombre')->get();
        }
    }

    public function subtractYears()
    {
        $this->fecha_evento = Carbon::parse($this->evento->fecha_evento)->subYears(15)->format('Y-m-d');
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

    public function buscarCedula()
    {
        for ($i = 0; $i <= $this->cantidad - 1; $i++) {
            $this->participante[$i] = participante::select('participantes.*', 'estados.id as estado_id')->where('cedula', $this->create_participante[$i]["cedula"])->join('ciudads', 'participantes.ciudad_id', '=', 'ciudads.id')->join('estados', 'ciudads.estado_id', '=', 'estados.id')->first();

            if (isset($this->participante[$i])) {
                $this->create_participante[$i]['ciudades'] = ciudad::where('estado_id', $this->participante[$i]->estado_id)->get();
                $this->create_participante[$i]["ciudad_id"] = $this->participante[$i]->ciudad_id;
                $this->create_participante[$i]["cedula"] = $this->participante[$i]->cedula;
                $this->create_participante[$i]["estado_id"] = $this->participante[$i]->estado_id;
                $this->create_participante[$i]["nombre"] = $this->participante[$i]->nombre;
                $this->create_participante[$i]["apellido"] = $this->participante[$i]->apellido;
                $this->create_participante[$i]["telefono"] = $this->participante[$i]->telefono;
                $this->create_participante[$i]["correo"] = $this->participante[$i]->correo;
                $this->create_participante[$i]["direccion"] = $this->participante[$i]->direccion;
                $this->create_participante[$i]["fecha_nacimiento"] = $this->participante[$i]->fecha_nacimiento;
            } else {
                $this->participante[$i] = null;
            }
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
        } elseif ($option === '') {
            $this->create_inscripcion[$index]['unico'] = null;
            $this->create_inscripcion[$index]['mixto'] = null;
        }
    }
    public function update_prendas($index, $option)
    {
        if ($option === '1') {

            $this->create_prendas[$index]['genero'] = 'Masculino';
            $this->prendas = DB::table('prendas')->join('prenda_tallas', 'prendas.prenda_talla_id', '=', 'prenda_tallas.id')->join('prenda_categories', 'prendas.prenda_category_id', '=', 'prenda_categories.id')->select('prendas.*', 'prenda_tallas.talla as prenda_talla', 'prenda_categories.nombre as prenda_categories_nombre')->where('prendas.sexo', 'Masculino')->get();
        } elseif ($option === '2') {
            $this->create_prendas[$index]['genero'] = 'Femenino';
            $this->prendas = DB::table('prendas')->join('prenda_tallas', 'prendas.prenda_talla_id', '=', 'prenda_tallas.id')->join('prenda_categories', 'prendas.prenda_category_id', '=', 'prenda_categories.id')->select('prendas.*', 'prenda_tallas.talla as prenda_talla', 'prenda_categories.nombre as prenda_categories_nombre')->where('prendas.sexo', 'Femenino')->get();
        } elseif ($option === '') {
            $this->create_prendas[$index]['genero'] = null;
            $this->prendas = null;
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
        } elseif ($option === '') {
            $this->create_inscripcion[$index]['bolivar_mixto'] = null;
            $this->create_inscripcion[$index]['dolar_mixto'] = null;
        }
    }
    public function calculo($num)
    {
        if (isset($this->dolars)) {
            $total = 0;
            $ultimoDolar = $this->dolars->latest()->first();
            $total = $num * $ultimoDolar->precio;

            return $total;
        } else {
            $total = 0;

            return $total;
        }
    }

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
            $rules["create_participante.$i.ciudad_id"] = 'required';
            $rules["create_participante.$i.cedula"] = 'required|string|max:8|regex:/^[0-9]+$/';
            $rules["create_participante.$i.nombre"] = 'required|string|max:25|regex:/^[a-zA-Z\s]+$/';
            $rules["create_participante.$i.apellido"] = 'required|string|max:25|regex:/^[a-zA-Z\s]+$/';
            $rules["create_participante.$i.telefono"] = 'required|string|max:11|regex:/^[0-9]+$/';
            $rules["create_participante.$i.correo"] = 'required|email|max:60';
            $rules["create_participante.$i.direccion"] = 'required|string|max:60|regex:/^[a-zA-Z0-9\s]+$/';
            $rules["create_participante.$i.fecha_nacimiento"] = 'required|date|before_or_equal:' . $this->fecha_evento;

            if (!is_null($this->create_inscripcion[$i]['unico'])) {
                $rules["create_inscripcion.$i.metodo_pago_id"] = 'required';
                $rules["create_inscripcion.$i.fecha"] = 'required|date|before_or_equal:' . $this->fecha_actual;
                $rules["create_inscripcion.$i.referencia"] = 'required|numeric|digits:6';

                if (!is_null($this->create_inscripcion[$i]['monto_Bs'])) {
                    $rules["create_inscripcion.$i.monto_Bs"] = 'required|numeric';
                } else {
                    $rules["create_inscripcion.$i.monto_$"] = 'required|numeric';
                }
            } else {

                $rules["create_inscripcion.$i.fecha"] = 'required|date|before_or_equal:' . $this->fecha_actual;
                $rules["create_inscripcion.$i.referencia"] = 'required|numeric|digits:6';
                $rules["create_inscripcion.$i.fecha_mixto"] = 'required|date|before_or_equal:' . $this->fecha_actual;
                $rules["create_inscripcion.$i.referencia_mixto"] = 'required|numeric|digits:6';
                $rules["create_inscripcion.$i.cuenta_mixto_1"] = 'required|string';
                $rules["create_inscripcion.$i.cuenta_mixto_2"] = 'required|string';

                if (!is_null($this->create_inscripcion[$i]['monto_mixto_Bs'])) {
                    $rules["create_inscripcion.$i.monto_mixto_Bs"] = 'required|numeric';
                } else {
                    $rules["create_inscripcion.$i.monto_mixto_$"] = 'required|numeric';
                }
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
            $messages["create_participante.$i.fecha_nacimiento.before_or_equal"] = __('El campo fecha de nacimiento debe ser menor o igual a ' . Carbon::parse($this->fecha_evento)->format('d-m-Y'));

            $messages["create_inscripcion.$i.metodo_pago_id.required"] = __('El campo cuentas es obligatorio.');
            $messages["create_inscripcion.$i.metodo_pago_id.string"] = __('El campo cuentas debe ser un string.');

            $messages["create_inscripcion.$i.monto.required"] = __('El campo monto es obligatorio.');
            $messages["create_inscripcion.$i.monto.numeric"] = __('El campo monto solo permite numeros.');
            $messages["create_inscripcion.$i.fecha.required"] = __('El campo fecha de pago es obligatorio.');
            $messages["create_inscripcion.$i.fecha.date"] = __('El campo fecha de pago debe tener la sintaxis correcta.');
            $messages["create_inscripcion.$i.fecha.before_or_equal"] = __('El campo fecha de pago debe ser menor o igual a ' . Carbon::parse($this->fecha_actual)->format('d-m-Y'));
            $messages["create_inscripcion.$i.referencia.required"] = __('El campo referencia es obligatorio.');
            $messages["create_inscripcion.$i.referencia.numeric"] = __('El campo referencia solo permite numeros.');
            $messages["create_inscripcion.$i.referencia.digits"] = __('El campo referencia solo admite 6 digitos');


            $messages["create_inscripcion.$i.monto_mixto.required"] = __('El campo monto es obligatorio.');
            $messages["create_inscripcion.$i.monto_mixto.numeric"] = __('El campo monto solo permite numeros.');
            $messages["create_inscripcion.$i.fecha_mixto.required"] = __('El campo fecha de pago es obligatorio.');
            $messages["create_inscripcion.$i.fecha_mixto.date"] = __('El campo fecha de pago debe tener la sintaxis correcta.');
            $messages["create_inscripcion.$i.fecha_mixto.before_or_equal"] = __('El campo fecha de pago debe ser menor o igual a ' . Carbon::parse($this->fecha_actual)->format('d-m-Y'));

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
        $this->validate();
        $evento = evento::select('id', 'nombre', 'fecha_evento')->where('estado', true)->orderBy('id', 'desc')->first();

        $ultimoNumeroOrden = Inscripcion::max('id');
        $this->nuevoNumeroOrden = $ultimoNumeroOrden ? $ultimoNumeroOrden + 1 : 1;

        $this->nomenclatura = 'GRCM' . '-' . $this->grupo->cantidad . $this->nuevoNumeroOrden;

        for ($i = 0; $i <= $this->grupo->cantidad - 1; $i++) {
            if (!empty($this->participante[$i]) && !is_null($this->participante[$i])) {
                if (isset($this->participante[$i]->id)) {
                    $this->participantes_ids[] = $this->participante[$i]->id;
                }
            }
        }

        $this->inscripcion_validate_global = inscripcion::whereIn('participante_id', $this->participantes_ids)->join('participantes', 'participantes.id', '=', 'inscripcions.participante_id')->join('eventos', 'inscripcions.evento_id', '=', 'eventos.id')->where('eventos.estado', true)->select('eventos.id', 'participantes.nombre as nombre', 'participantes.cedula as cedula')->get()->toArray();

        for ($i = 0; $i <= $this->grupo->cantidad - 1; $i++) {

            //Validar si alguno de los enviados ya se encuentra registrado en el evento actual
            if (!empty($this->inscripcion_validate_global)) {
                $this->cedula = '';
                $this->nombre = '';
                $this->cedula = $this->inscripcion_validate_global[$i]['cedula'];
                $this->nombre = $this->inscripcion_validate_global[$i]['nombre'];
                $this->inscripcion_validate_global = [];

                $this->participantes_ids = [];

                return $this->dispatch('existe', ['valor' => $this->cedula], ['nombre' =>  $this->nombre]);
                //Retornar mensaje de validacion con datos del participante que se repite

            } elseif (empty($this->inscripcion_validate_global) && isset($this->participante[$i]) && !is_null($this->participante[$i])) {
                $latestId = $this->participante[$i]->id;
                $this->create_inscripcion[$i]['participante_id'] = $latestId;

                $datos_json = [
                    'fecha' => $this->create_inscripcion[$i]['fecha'],
                    'referencia' => $this->create_inscripcion[$i]['referencia']
                ];
                if (!is_null($this->create_inscripcion[$i]['monto_Bs'])) {
                    $datos_json += [
                        'monto_Bs' => $this->create_inscripcion[$i]['monto_Bs'],
                    ];
                } else {
                    $datos_json += [
                        'monto_$' => $this->create_inscripcion[$i]['monto_$'],
                    ];
                }
                if (!is_null($this->create_inscripcion[$i]['fecha_mixto'])) {
                    $datos_json += [
                        'fecha_mixto' => $this->create_inscripcion[$i]['fecha_mixto'],
                        'referencia_mixto' => $this->create_inscripcion[$i]['referencia_mixto'],
                        'cuenta_mixto_1' => $this->create_inscripcion[$i]['cuenta_mixto_1'],
                        'cuenta_mixto_2' => $this->create_inscripcion[$i]['cuenta_mixto_2']
                    ];
                    if (!is_null($this->create_inscripcion[$i]['monto_mixto_Bs'])) {
                        $datos_json += [
                            'monto_mixto_Bs' => $this->create_inscripcion[$i]['monto_mixto_Bs'],
                        ];
                    } else {
                        $datos_json += [
                            'monto_mixto_$' => $this->create_inscripcion[$i]['monto_mixto_$'],
                        ];
                    }
                }
                $datos_json = json_encode($datos_json);
                $this->create_inscripcion[$i]['datos'] = $datos_json;

                if (is_null($this->create_inscripcion[$i]['metodo_pago_id'])) {
                    $this->create_inscripcion[$i]['metodo_pago_id'] = 3;
                }
                if (is_null($this->create_inscripcion[$i]['recorrido_id'])) {
                    $this->create_inscripcion[$i]['recorrido_id'] = $this->grupo->recorrido_id;
                }
                $this->create_inscripcion[$i]['recorrido_id_grupos'] = $this->grupo->recorrido_id;

                $this->create_inscripcion[$i]['nomenclatura'] = $this->nomenclatura;
                $this->create_inscripcion[$i]['ip'] = $this->userIp;
                $this->create_inscripcion[$i]['categoria_habilitada_id'] = 12;
                if (!is_null($this->create_prendas[$i]['prendas'])) {
                    $this->create_inscripcion[$i]['prenda_id'] = $this->create_prendas[$i]['prendas'];
                    $this->asignar_prendas($this->create_prendas[$i]['prendas']);
                } else {
                    $this->create_inscripcion[$i]['prenda_id'] = 1;
                }

                $inscripciones = inscripcion::create([
                    'evento_id' => $this->create_inscripcion[$i]['evento_id'],
                    'participante_id' => $this->create_inscripcion[$i]['participante_id'],
                    'metodo_pago_id' => $this->create_inscripcion[$i]['metodo_pago_id'],
                    'grupo_id' => $this->create_inscripcion[$i]['grupo_id'],
                    'dolar_id' => $this->create_inscripcion[$i]['dolar_id'],
                    'numero_id' => $this->create_inscripcion[$i]['numero_id'],
                    'categoria_habilitada_id' => $this->create_inscripcion[$i]['categoria_habilitada_id'],
                    'mesa_id' => $this->create_inscripcion[$i]['mesa_id'],
                    'datos' => $this->create_inscripcion[$i]['datos'],
                    'monto_pagado_bs' => $this->create_inscripcion[$i]['monto_pagado_bs'],
                    'ip' => $this->create_inscripcion[$i]['ip'],
                    'nomenclatura' => $this->create_inscripcion[$i]['nomenclatura'],
                    'recorrido_id' => $this->create_inscripcion[$i]['recorrido_id'],
                    'recorrido_id_grupos' => $this->create_inscripcion[$i]['recorrido_id_grupos'],
                    'prenda_id' => $this->create_inscripcion[$i]['prenda_id'],

                ]);
                $ultima_inscripcion_id = inscripcion::latest('id')->first()->id;
                $this->asignar_num_mesa($ultima_inscripcion_id, $this->create_participante[$i]['cedula']);
            } else {

                $participante = participante::create([
                    'ciudad_id' => $this->create_participante[$i]['ciudad_id'],
                    'cedula' => $this->create_participante[$i]['cedula'],
                    'nombre' => $this->create_participante[$i]['nombre'],
                    'apellido' => $this->create_participante[$i]['apellido'],
                    'telefono' => $this->create_participante[$i]['telefono'],
                    'correo' => $this->create_participante[$i]['correo'],
                    'direccion' => $this->create_participante[$i]['direccion'],
                    'fecha_nacimiento' => $this->create_participante[$i]['fecha_nacimiento'],
                    'genero_id' => $this->create_participante[$i]['genero_id'],

                ]);
                $latestId = participante::latest('id')->first()->id;
                $this->create_inscripcion[$i]['participante_id'] = $latestId;
                $ultimoParticipante = participante::find($latestId);
                $datos_json = [
                    'fecha' => $this->create_inscripcion[$i]['fecha'],
                    'referencia' => $this->create_inscripcion[$i]['referencia']
                ];
                if (!is_null($this->create_inscripcion[$i]['monto_Bs'])) {
                    $datos_json += [
                        'monto_Bs' => $this->create_inscripcion[$i]['monto_Bs'],
                    ];
                } else {
                    $datos_json += [
                        'monto_$' => $this->create_inscripcion[$i]['monto_$'],
                    ];
                }
                if (!is_null($this->create_inscripcion[$i]['fecha_mixto'])) {
                    $datos_json += [
                        'fecha_mixto' => $this->create_inscripcion[$i]['fecha_mixto'],
                        'referencia_mixto' => $this->create_inscripcion[$i]['referencia_mixto'],
                        'cuenta_mixto_1' => $this->create_inscripcion[$i]['cuenta_mixto_1'],
                        'cuenta_mixto_2' => $this->create_inscripcion[$i]['cuenta_mixto_2']
                    ];
                    if (!is_null($this->create_inscripcion[$i]['monto_mixto_Bs'])) {
                        $datos_json += [
                            'monto_mixto_Bs' => $this->create_inscripcion[$i]['monto_mixto_Bs'],
                        ];
                    } else {
                        $datos_json += [
                            'monto_mixto_$' => $this->create_inscripcion[$i]['monto_mixto_$'],
                        ];
                    }
                }
                $datos_json = json_encode($datos_json);
                $this->create_inscripcion[$i]['datos'] = $datos_json;

                if (is_null($this->create_inscripcion[$i]['metodo_pago_id'])) {
                    $this->create_inscripcion[$i]['metodo_pago_id'] = 3;
                }

                if (is_null($this->create_inscripcion[$i]['recorrido_id'])) {
                    $this->create_inscripcion[$i]['recorrido_id'] = $this->grupo->recorrido_id;
                }
                $this->create_inscripcion[$i]['recorrido_id_grupos'] = $this->grupo->recorrido_id;

                $this->create_inscripcion[$i]['nomenclatura'] = $this->nomenclatura;
                $this->create_inscripcion[$i]['ip'] = $this->userIp;
                $this->create_inscripcion[$i]['categoria_habilitada_id'] = 12;
                if (!is_null($this->create_prendas[$i]['prendas'])) {
                    $this->create_inscripcion[$i]['prenda_id'] = $this->create_prendas[$i]['prendas'];
                    $this->asignar_prendas($this->create_prendas[$i]['prendas']);
                } else {
                    $this->create_inscripcion[$i]['prenda_id'] = 1;
                }
                $inscripciones = inscripcion::create([
                    'evento_id' => $this->create_inscripcion[$i]['evento_id'],
                    'participante_id' => $this->create_inscripcion[$i]['participante_id'],
                    'metodo_pago_id' => $this->create_inscripcion[$i]['metodo_pago_id'],
                    'grupo_id' => $this->create_inscripcion[$i]['grupo_id'],
                    'dolar_id' => $this->create_inscripcion[$i]['dolar_id'],
                    'numero_id' => $this->create_inscripcion[$i]['numero_id'],
                    'categoria_habilitada_id' => $this->create_inscripcion[$i]['categoria_habilitada_id'],
                    'mesa_id' => $this->create_inscripcion[$i]['mesa_id'],
                    'datos' => $this->create_inscripcion[$i]['datos'],
                    'monto_pagado_bs' => $this->create_inscripcion[$i]['monto_pagado_bs'],
                    'ip' => $this->create_inscripcion[$i]['ip'],
                    'nomenclatura' => $this->create_inscripcion[$i]['nomenclatura'],
                    'recorrido_id' => $this->create_inscripcion[$i]['recorrido_id'],
                    'recorrido_id_grupos' => $this->create_inscripcion[$i]['recorrido_id_grupos'],
                    'prenda_id' => $this->create_inscripcion[$i]['prenda_id'],
                ]);

                $ultima_inscripcion_id = inscripcion::latest('id')->first()->id;
                $this->asignar_num_mesa($ultima_inscripcion_id, $this->create_participante[$i]['cedula']);
            }
        }
        $this->dispatch('alert');
        $this->create_participante = [];
        $this->create_inscripcion = [];
    }
    public function asignar_prendas($value)
    {
        // Encuentra la prenda solo una vez
        $prenda = prenda::select('cantidad', 'restadas')->find($value);
        for ($i = 0; $i < $this->grupo->cantidad; $i++) {
            $this->create_prendas[$i]['prendas'] = $value;

            // Resta de cantidades dependiendo de si 'restadas' es null o no
            if (is_null($prenda->restadas)) {
                $resta = $prenda->cantidad - 1;
                prenda::where('id', $value)->update(['restadas' => $resta]);
            } else {
                $resta = $prenda->restadas - 1;
                prenda::where('id', $value)->update(['restadas' => $resta]);
            }
        }
    }
    public function render()
    {
        $grupos = grupo::where('nombre', 'NOT LIKE', '%sin franela%')->get();

        return view('livewire.formulario-inscripcion.formulario-caminata', [
            'grupos' => $grupos
        ]);
    }
}
