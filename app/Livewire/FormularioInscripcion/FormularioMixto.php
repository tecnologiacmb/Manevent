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
use App\Models\prenda;
use App\Models\genero;

class FormularioMixto extends Component
{
    public $evento = null;
    public $cedula = null;
    public $nombre = null;
    public $apellido = null;
    public $metodo_pago;
    public $grupo;
    public $dolars;
    public $numero;
    public $estados;
    public $ciudad;
    public $value = null;
    public $categoria_habilitada;
    public $inscripcion;
    public $numeros;
    public $mesa;
    public $dolar = null;
    public $fecha_actual = null;
    public $fecha_evento;
    public $cantidad_carrera;
    public $cantidad_caminata;
    public $nomenclatura;
    public $nuevoNumeroOrden = null;
    public $userIp;
    public $generos;
    public $prendas_caminata;
    public $prendas_carrera;

    public $datos_json = [];
    public $inscripcion_validate_global = [];
    public $participantes_ids = [];
    public $carrera_participante = [];
    public $caminata_participante = [];
    public $participante_carrera = [
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
    public $participante_caminata = [
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
    public $inscripcion_carrera = [
        'evento_id' => null,
        'cedula' => "",
        'participante_id' => null,
        'tipo_pago_id' => null,
        'metodo_pago_id' => null,
        'grupo_id' => null,
        'dolar_id' => null,
        'numero_id' => null,
        'categoria_habilitada_id' => null,
        'mesa_id' => null,
        'datos' => null,
        'monto_pagado_bs' => null,
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
        'recorrido_id' => null,
        'recorrido_id_grupos' => null,
        'prenda_id' => null,
    ];
    public $inscripcion_caminata = [
        'evento_id' => null,
        'cedula' => "",
        'participante_id' => null,
        'tipo_pago_id' => null,
        'metodo_pago_id' => null,
        'grupo_id' => null,
        'dolar_id' => null,
        'numero_id' => null,
        'categoria_habilitada_id' => null,
        'mesa_id' => null,
        'datos' => null,
        'monto_pagado_bs' => null,
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
        'recorrido_id' => null,
        'recorrido_id_grupos' => null,
        'prenda_id' => null,
    ];
    public $create_prendas_carrera = [
        'prendas' => null,
        'genero' => null
    ];
    public $create_prendas_caminata = [
        'prendas' => null,
        'genero' => null
    ];
    public function mount($id = null, $cantidad_carrera, $cantidad_caminata)
    {
        if (!is_null($id)) {
            $this->cantidad_carrera = $cantidad_carrera;
            $this->cantidad_caminata = $cantidad_caminata;
            $this->userIp = request()->ip();
            $this->generos = genero::all();
            $this->fecha_actual = Carbon::now()->format('Y-m-d');
            $this->evento = evento::select('id', 'nombre', 'fecha_evento')->where('estado', true)->orderBy('id', 'desc')->first();
            $this->subtractYears();
            $this->categoria_habilitada = categoriaHabilitada::all();
            $this->grupo = grupo::find($id);
            $this->dolars = dolar::select('id', 'precio')->whereDate('created_at', Carbon::today())->latest()->first();
            if (!$this->dolars) {
                $this->dolars = dolar::latest()->first();
            }
            $this->numeros = numero::all();
            $this->estados = estado::all();
            for ($i = 0; $i <= $this->cantidad_carrera - 1; $i++) {
                $this->participante_carrera[$i] = [
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
                $this->inscripcion_carrera[$i] = [
                    'evento_id' => $this->evento->id,
                    'cedula' => "",
                    'participante_id' => null,
                    'tipo_pago_id' => null,
                    'metodo_pago_id' => null,
                    'grupo_id' => $id,
                    'dolar_id' => $this->dolars->id,
                    'numero_id' => null,
                    'categoria_habilitada_id' => null,
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
                    'monto_Bs' => null,
                    'monto_USD' => null,
                    'monto_mixto_Bs' => null,
                    'monto_mixto_USD' => null,
                    'fecha' => $this->fecha_actual,
                    'fecha_mixto' => $this->fecha_actual,
                    'referencia' => null,
                    'referencia_mixto' => null,
                    'cuenta_mixto_1' => null,
                    'cuenta_mixto_2' => null,
                    'recorrido_id' => null,
                    'recorrido_id_grupos' => null,
                    'prenda_id' => null,
                ];
                $this->create_prendas_carrera[$i] = [
                    'prendas' => null,
                    'genero' => null
                ];
            }
            for ($j = 0; $j <= $this->cantidad_caminata - 1; $j++) {
                $this->participante_caminata[$j] = [
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
                $this->inscripcion_caminata[$j] = [
                    'evento_id' => $this->evento->id,
                    'cedula' => "",
                    'participante_id' => null,
                    'tipo_pago_id' => null,
                    'metodo_pago_id' => null,
                    'grupo_id' => $id,
                    'dolar_id' => $this->dolars->id,
                    'numero_id' => null,
                    'categoria_habilitada_id' => null,
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
                    'monto_Bs' => null,
                    'monto_USD' => null,
                    'monto_mixto_Bs' => null,
                    'monto_mixto_USD' => null,
                    'fecha' => $this->fecha_actual,
                    'fecha_mixto' => $this->fecha_actual,
                    'referencia' => null,
                    'referencia_mixto' => null,
                    'cuenta_mixto_1' => null,
                    'cuenta_mixto_2' => null,
                    'recorrido_id' => null,
                    'recorrido_id_grupos' => null,
                    'prenda_id' => null,
                ];
                $this->create_prendas_caminata[$j] = [
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
    public function updatedParticipanteCarrera($value, $name)
    {
        $parts = explode('.', $name);
        $index = $parts[0];
        $field = $parts[1];
        if ($field === 'estado_id') {
            $this->participante_carrera[$index]['ciudades'] = ciudad::where('estado_id', $value)->get();
        }
    }
    public function updatedParticipanteCaminata($value, $name)
    {
        $parts = explode('.', $name);
        $index = $parts[0];
        $field = $parts[1];
        if ($field === 'estado_id') {
            $this->participante_caminata[$index]['ciudades'] = ciudad::where('estado_id', $value)->get();
        }
    }

    public function updated_pago_carrera($value, $name)
    {
        $parts = explode('.', $name);
        $index = $parts[0];
        $field = $parts[1];
        return dd($value);
        if ($field === 'metodo') {
            $this->participante_carrera[$index]['metodos'] = $value;
        }
    }

    public function updated_pago_caminata($value, $name)
    {
        $parts = explode('.', $name);
        $index = $parts[0];
        $field = $parts[1];
        return dd($value);
        if ($field === 'metodo') {
            $this->participante_caminata[$index]['metodos'] = $value;
        }
    }

    public function update_radio_carrera($index, $option)
    {
        if ($option === '1') {
            $this->inscripcion_carrera[$index]['unico'] = '1';
            $this->inscripcion_carrera[$index]['mixto'] = null;
        } elseif ($option === '2') {
            $this->inscripcion_carrera[$index]['unico'] = null;
            $this->inscripcion_carrera[$index]['mixto'] = '2';
        } elseif ($option === '') {
            $this->inscripcion_carrera[$index]['unico'] = null;
            $this->inscripcion_carrera[$index]['mixto'] = null;
        }
    }

    public function update_radio_caminata($index, $option)
    {
        if ($option === '1') {
            $this->inscripcion_caminata[$index]['unico'] = '1';
            $this->inscripcion_caminata[$index]['mixto'] = null;
        } elseif ($option === '2') {
            $this->inscripcion_caminata[$index]['unico'] = null;
            $this->inscripcion_caminata[$index]['mixto'] = '2';
        } elseif ($option === '') {
            $this->inscripcion_caminata[$index]['unico'] = null;
            $this->inscripcion_caminata[$index]['mixto'] = null;
        }
    }

    public function update_pago_carrera($index, $option)
    {
        if ($option === '1') {

            $this->inscripcion_carrera[$index]['bolivar'] = '1';
            $this->inscripcion_carrera[$index]['dolar'] = null;
        } elseif ($option === '2') {
            $this->inscripcion_carrera[$index]['bolivar'] = null;
            $this->inscripcion_carrera[$index]['dolar'] = '2';
        } elseif ($option === '') {
            $this->inscripcion_carrera[$index]['bolivar'] = null;
            $this->inscripcion_carrera[$index]['dolar'] = null;
        }
    }

    public function update_pago_caminata($index, $option)
    {
        if ($option === '1') {

            $this->inscripcion_caminata[$index]['bolivar'] = '1';
            $this->inscripcion_caminata[$index]['dolar'] = null;
        } elseif ($option === '2') {
            $this->inscripcion_caminata[$index]['bolivar'] = null;
            $this->inscripcion_caminata[$index]['dolar'] = '2';
        } elseif ($option === '') {
            $this->inscripcion_caminata[$index]['bolivar'] = null;
            $this->inscripcion_caminata[$index]['dolar'] = null;
        }
    }

    public function update_pago_mixto_carrera($index, $option)
    {
        if ($option === '1') {

            $this->inscripcion_carrera[$index]['bolivar_mixto'] = '1';
            $this->inscripcion_carrera[$index]['dolar_mixto'] = null;
        } elseif ($option === '2') {
            $this->inscripcion_carrera[$index]['bolivar_mixto'] = null;
            $this->inscripcion_carrera[$index]['dolar_mixto'] = '2';
        } elseif ($option === '') {
            $this->inscripcion_carrera[$index]['bolivar_mixto'] = null;
            $this->inscripcion_carrera[$index]['dolar_mixto'] = null;
        }
    }

    public function update_pago_mixto_caminata($index, $option)
    {
        if ($option === '1') {

            $this->inscripcion_caminata[$index]['bolivar_mixto'] = '1';
            $this->inscripcion_caminata[$index]['dolar_mixto'] = null;
        } elseif ($option === '2') {
            $this->inscripcion_caminata[$index]['bolivar_mixto'] = null;
            $this->inscripcion_caminata[$index]['dolar_mixto'] = '2';
        } elseif ($option === '') {
            $this->inscripcion_caminata[$index]['bolivar_mixto'] = null;
            $this->inscripcion_caminata[$index]['dolar_mixto'] = null;
        }
    }

    public function calculo($num)
    {
        $total = 0;
        $ultimoDolar = $this->dolars->latest()->first();

        $total = $num * $ultimoDolar->precio;

        return $total;
    }

    public function edad($fecha_nacimiento)
    {
        $fecha_nacimiento = Carbon::parse($fecha_nacimiento)->format('Y-m-d');
        $ahora = Carbon::parse($this->evento->fecha_evento)->format('Y-m-d');
        $edad = Carbon::parse($ahora)->diffInYears(Carbon::parse($fecha_nacimiento));

        foreach ($this->categoria_habilitada as $categoria_habilitadas) {
            if ($edad >= $categoria_habilitadas->edad_min && $edad <= $categoria_habilitadas->edad_max) {
                return $categoria_habilitadas->id;
            }
        }
        return null;
    }

    public function asignar_num_mesa_carrera($inscripcion_id, $cedula)
    {
        $ultimo_digito = substr($cedula, -1);

        $this->inscripcion = inscripcion::find($inscripcion_id);
        if ($ultimo_digito == '0' || $ultimo_digito == '1') {
            $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [1, 100])->orderBy('id', 'asc')->first();

            /* logica asignacion de numeros y mesa*/

            if (!is_null($numero_id)) {
                $this->inscripcion->numero_id = $numero_id->id;
                $this->inscripcion->mesa_id = Mesas_enum::Mesa_1;
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
        } else if ($ultimo_digito == '2' || $ultimo_digito == '3') {
            $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [101, 200])->orderBy('id', 'asc')->first();

            /* logica asignacion de numeros y mesa*/
            if (!is_null($numero_id)) {
                $this->inscripcion->numero_id = $numero_id->id;
                $this->inscripcion->mesa_id = Mesas_enum::Mesa_2;
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
        } else if ($ultimo_digito == '4' || $ultimo_digito == '5') {
            $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [201, 300])->orderBy('id', 'asc')->first();

            if (!is_null($numero_id)) {
                $this->inscripcion->numero_id = $numero_id->id;
                $this->inscripcion->mesa_id = Mesas_enum::Mesa_3;
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
        } else if ($ultimo_digito == '6' || $ultimo_digito == '7') {
            $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [301, 400])->orderBy('id', 'asc')->first();

            /* logica asignacion de numeros y mesa*/
            if (!is_null($numero_id)) {
                $this->inscripcion->numero_id = $numero_id->id;
                $this->inscripcion->mesa_id = Mesas_enum::Mesa_4;
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
        } else if ($ultimo_digito == '8' || $ultimo_digito == '9') {
            $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [401, 500])->orderBy('id', 'asc')->first();

            /* logica asignacion de numeros y mesa*/
            if (!is_null($numero_id)) {
                $this->inscripcion->numero_id = $numero_id->id;
                $this->inscripcion->mesa_id = Mesas_enum::Mesa_5;
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
        }
    }

    public function asignar_num_mesa_caminata($inscripcion_id, $cedula)
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
        for ($i = 0; $i <= $this->cantidad_carrera - 1; $i++) {
            $rules["participante_carrera.$i.ciudad_id"] = 'required';
            $rules["participante_carrera.$i.cedula"] = 'required|string|max:8|regex:/^[0-9]+$/';
            $rules["participante_carrera.$i.nombre"] = 'required|string|max:25|regex:/^[a-zA-Z\s]+$/';
            $rules["participante_carrera.$i.apellido"] = 'required|string|max:25|regex:/^[a-zA-Z\s]+$/';
            $rules["participante_carrera.$i.telefono"] = 'required|string|max:11|regex:/^[0-9]+$/';
            $rules["participante_carrera.$i.correo"] = 'required|email|max:60';
            $rules["participante_carrera.$i.direccion"] = 'required|string|max:60|regex:/^[a-zA-Z0-9\s]+$/';
            $rules["participante_carrera.$i.fecha_nacimiento"] = 'required|date|before_or_equal:' . $this->fecha_evento;

            if (!is_null($this->inscripcion_carrera[$i]['unico'])) {
                $rules["inscripcion_carrera.$i.metodo_pago_id"] = 'required';
                $rules["inscripcion_carrera.$i.fecha"] = 'required|date|before_or_equal:' . $this->fecha_actual;
                $rules["inscripcion_carrera.$i.referencia"] = 'required|numeric|digits:6';

                if (!is_null($this->inscripcion_carrera[$i]['monto_Bs'])) {
                    $rules["inscripcion_carrera.$i.monto_Bs"] = 'required|numeric';
                } else {
                    $rules["inscripcion_carrera.$i.monto_USD"] = 'required|numeric';
                }
            } else {
                $rules["inscripcion_carrera.$i.fecha"] = 'required|date|before_or_equal:' . $this->fecha_actual;
                $rules["inscripcion_carrera.$i.referencia"] = 'required|numeric|digits:6';
                $rules["inscripcion_carrera.$i.fecha_mixto"] = 'required|date|before_or_equal:' . $this->fecha_actual;
                $rules["inscripcion_carrera.$i.referencia_mixto"] = 'required|numeric|digits:6';
                $rules["inscripcion_carrera.$i.cuenta_mixto_1"] = 'required|string';
                $rules["inscripcion_carrera.$i.cuenta_mixto_2"] = 'required|string';

                if (!is_null($this->inscripcion_carrera[$i]['monto_mixto_Bs'])) {
                    $rules["inscripcion_carrera.$i.monto_mixto_Bs"] = 'required|numeric';
                } else {
                    $rules["inscripcion_carrera.$i.monto_mixto_USD"] = 'required|numeric';
                }
            }
        }

        for ($j = 0; $j <= $this->cantidad_caminata - 1; $j++) {
            $rules["participante_caminata.$j.ciudad_id"] = 'required';
            $rules["participante_caminata.$j.cedula"] = 'required|string|max:8|regex:/^[0-9]+$/';
            $rules["participante_caminata.$j.nombre"] = 'required|string|max:25|regex:/^[a-zA-Z\s]+$/';
            $rules["participante_caminata.$j.apellido"] = 'required|string|max:25|regex:/^[a-zA-Z\s]+$/';
            $rules["participante_caminata.$j.telefono"] = 'required|string|max:11|regex:/^[0-9]+$/';
            $rules["participante_caminata.$j.correo"] = 'required|email|max:60';
            $rules["participante_caminata.$j.direccion"] = 'required|string|max:60|regex:/^[a-zA-Z0-9\s]+$/';
            $rules["participante_caminata.$j.fecha_nacimiento"] = 'required|date|before_or_equal:' . $this->fecha_evento;

            if (!is_null($this->inscripcion_caminata[$j]['unico'])) {
                $rules["inscripcion_caminata.$j.metodo_pago_id"] = 'required';
                $rules["inscripcion_caminata.$j.fecha"] = 'required|date|before_or_equal:' . $this->fecha_actual;
                $rules["inscripcion_caminata.$j.referencia"] = 'required|numeric|digits:6';

                if (!is_null($this->inscripcion_caminata[$j]['monto_Bs'])) {
                    $rules["inscripcion_caminata.$j.monto_Bs"] = 'required|numeric';
                } else {
                    $rules["inscripcion_caminata.$j.monto_USD"] = 'required|numeric';
                }
            } else {
                $rules["inscripcion_caminata.$j.fecha"] = 'required|date|before_or_equal:' . $this->fecha_actual;
                $rules["inscripcion_caminata.$j.referencia"] = 'required|numeric|digits:6';
                $rules["inscripcion_caminata.$j.fecha_mixto"] = 'required|date|before_or_equal:' . $this->fecha_actual;
                $rules["inscripcion_caminata.$j.referencia_mixto"] = 'required|numeric|digits:6';
                $rules["inscripcion_caminata.$j.cuenta_mixto_1"] = 'required|string';
                $rules["inscripcion_caminata.$j.cuenta_mixto_2"] = 'required|string';

                if (!is_null($this->inscripcion_caminata[$j]['monto_mixto_Bs'])) {
                    $rules["inscripcion_caminata.$j.monto_mixto_Bs"] = 'required|numeric';
                } else {
                    $rules["inscripcion_caminata.$j.monto_mixto_USD"] = 'required|numeric';
                }
            }
        }
        return $rules;
    }
    public function messages(): array
    {
        $messages = [];
        for ($i = 0; $i <= $this->cantidad_carrera - 1; $i++) {
            $messages["participante_carrera.$i.ciudad_id.required"] = __('El campo ciudad es obligatorio.');
            $messages["participante_carrera.$i.cedula.required"] = __('El campo cedula es obligatorio.');
            $messages["participante_carrera.$i.cedula.string"] = __('El campo cedula debe ser una cadena de texto numerico.');
            $messages["participante_carrera.$i.cedula.max"] = __('El campo cedula no debe ser mayor a 8 caracteres.');
            $messages["participante_carrera.$i.cedula.regex"] = __('El campo cedula solo acepta numeros.');
            $messages["participante_carrera.$i.nombre.required"] = __('El campo nombre es obligatorio.');
            $messages["participante_carrera.$i.nombre.string"] = __('El campo nombre debe ser una cadena de texto.');
            $messages["participante_carrera.$i.nombre.max"] = __('El campo nombre no debe ser mayor a 25 caracteres.');
            $messages["participante_carrera.$i.nombre.regex"] = __('El campo nombre no acepta caracteres especiales.');
            $messages["participante_carrera.$i.apellido.required"] = __('El campo apellido es obligatorio.');
            $messages["participante_carrera.$i.apellido.string"] = __('El campo apellido debe ser una cadena de texto.');
            $messages["participante_carrera.$i.apellido.max"] = __('El campo apellido no debe ser mayor a 25 caracteres.');
            $messages["participante_carrera.$i.apellido.regex"] = __('El campo apellido no acepta caracteres especiales.');
            $messages["participante_carrera.$i.telefono.required"] = __('El campo telefono es obligatorio.');
            $messages["participante_carrera.$i.telefono.string"] = __('El campo telefono debe ser una cadena de texto.');
            $messages["participante_carrera.$i.telefono.max"] = __('El campo telefono no debe ser mayor a 10 caracteres.');
            $messages["participante_carrera.$i.telefono.regex"] = __('El campo telefono solo acepta numeros.');
            $messages["participante_carrera.$i.correo.required"] = __('El campo correo es obligatorio.');
            $messages["participante_carrera.$i.correo.email"] = __('El campo correo debe tener la sintaxis correcta.');
            $messages["participante_carrera.$i.correo.max"] = __('El campo correo no debe ser mayor a 60 caracteres.');
            $messages["participante_carrera.$i.direccion.required"] = __('El campo direccion es obligatorio.');
            $messages["participante_carrera.$i.direccion.string"] = __('El campo direccion debe ser una cadena de texto.');
            $messages["participante_carrera.$i.direccion.max"] = __('El campo direccion no debe ser mayor a 60 caracteres.');
            $messages["participante_carrera.$i.direccion.regex"] = __('El campo direccion no acepta caracteres especiales.');
            $messages["participante_carrera.$i.fecha_nacimiento.required"] = __('El campo fecha de nacimiento es obligatorio.');
            $messages["participante_carrera.$i.fecha_nacimiento.date"] = __('El campo fecha de nacimiento debe ser de tipo fecha');
            $messages["participante_carrera.$i.fecha_nacimiento.before_or_equal"] = __('El campo fecha de nacimiento debe ser menor o igual a ' . Carbon::parse($this->fecha_evento)->format('d-m-Y'));

            $messages["inscripcion_carrera.$i.metodo_pago_id.required"] = __('El campo cuentas es obligatorio.');

            $messages["inscripcion_carrera.$i.monto_Bs.required"] = __('El campo monto es obligatorio.');
            $messages["inscripcion_carrera.$i.monto_Bs.numeric"] = __('El campo monto solo permite numeros.');
            $messages["inscripcion_carrera.$i.monto_$.required"] = __('El campo monto es obligatorio.');
            $messages["inscripcion_carrera.$i.monto_$.numeric"] = __('El campo monto solo permite numeros.');


            $messages["inscripcion_carrera.$i.fecha.required"] = __('El campo fecha de pago es obligatorio.');
            $messages["inscripcion_carrera.$i.fecha.date"] = __('El campo fecha de pago debe tener la sintaxis correcta.');
            $messages["inscripcion_carrera.$i.fecha.before_or_equal"] = __('El campo fecha de pago debe ser menor o igual a ' . Carbon::parse($this->fecha_evento)->format('d-m-Y'));
            $messages["inscripcion_carrera.$i.referencia.required"] = __('El campo referencia es obligatorio.');
            $messages["inscripcion_carrera.$i.referencia.numeric"] = __('El campo referencia solo permite numeros.');
            $messages["inscripcion_carrera.$i.referencia.digits"] = __('El campo referencia solo admite 6 digitos');


            $messages["inscripcion_carrera.$i.monto_mixto_Bs.required"] = __('El campo monto es obligatorio.');
            $messages["inscripcion_carrera.$i.monto_mixto_Bs.numeric"] = __('El campo monto solo permite numeros.');
            $messages["inscripcion_carrera.$i.monto_mixto_$.required"] = __('El campo monto es obligatorio.');
            $messages["inscripcion_carrera.$i.monto_mixto_$.numeric"] = __('El campo monto solo permite numeros.');
            $messages["inscripcion_carrera.$i.fecha_mixto.required"] = __('El campo fecha de pago es obligatorio.');
            $messages["inscripcion_carrera.$i.fecha_mixto.date"] = __('El campo fecha de pago debe tener la sintaxis correcta.');
            $messages["inscripcion_carrera.$i.fecha_mixto.before_or_equal"] = __('El campo fecha de pago debe ser menor o igual a ' . Carbon::parse($this->fecha_actual)->format('d-m-Y'));

            $messages["inscripcion_carrera.$i.referencia_mixto.required"] = __('El campo referencia es obligatorio.');
            $messages["inscripcion_carrera.$i.referencia_mixto.numeric"] = __('El campo referencia solo permite numeros.');
            $messages["inscripcion_carrera.$i.referencia_mixto.digits"] = __('El campo referencia solo admite los ultimos 6 digitos');


            $messages["inscripcion_carrera.$i.cuenta_mixto_1.required"] = __('El campo cuenta es obligatorio.');
            $messages["inscripcion_carrera.$i.cuenta_mixto_1.string"] = __('El campo cuenta debe ser una cadena de texto. ');
            $messages["inscripcion_carrera.$i.cuenta_mixto_2.required"] = __('El campo cuenta es obligatorio.');
            $messages["inscripcion_carrera.$i.cuenta_mixto_2.string"] = __('El campo cuenta debe ser una cadena de texto. ');
        }

        for ($j = 0; $j <= $this->grupo->cantidad - 1; $j++) {
            $messages["participante_caminata.$j.ciudad_id.required"] = __('El campo ciudad es obligatorio.');
            $messages["participante_caminata.$j.cedula.required"] = __('El campo cedula es obligatorio.');
            $messages["participante_caminata.$j.cedula.string"] = __('El campo cedula debe ser una cadena de texto numerico.');
            $messages["participante_caminata.$j.cedula.max"] = __('El campo cedula no debe ser mayor a 8 caracteres.');
            $messages["participante_caminata.$j.cedula.regex"] = __('El campo cedula solo acepta numeros.');
            $messages["participante_caminata.$j.nombre.required"] = __('El campo nombre es obligatorio.');
            $messages["participante_caminata.$j.nombre.string"] = __('El campo nombre debe ser una cadena de texto.');
            $messages["participante_caminata.$j.nombre.max"] = __('El campo nombre no debe ser mayor a 25 caracteres.');
            $messages["participante_caminata.$j.nombre.regex"] = __('El campo nombre no acepta caracteres especiales.');
            $messages["participante_caminata.$j.apellido.required"] = __('El campo apellido es obligatorio.');
            $messages["participante_caminata.$j.apellido.string"] = __('El campo apellido debe ser una cadena de texto.');
            $messages["participante_caminata.$j.apellido.max"] = __('El campo apellido no debe ser mayor a 25 caracteres.');
            $messages["participante_caminata.$j.apellido.regex"] = __('El campo apellido no acepta caracteres especiales.');
            $messages["participante_caminata.$j.telefono.required"] = __('El campo telefono es obligatorio.');
            $messages["participante_caminata.$j.telefono.string"] = __('El campo telefono debe ser una cadena de texto.');
            $messages["participante_caminata.$j.telefono.max"] = __('El campo telefono no debe ser mayor a 10 caracteres.');
            $messages["participante_caminata.$j.telefono.regex"] = __('El campo telefono solo acepta numeros.');
            $messages["participante_caminata.$j.correo.required"] = __('El campo correo es obligatorio.');
            $messages["participante_caminata.$j.correo.email"] = __('El campo correo debe tener la sintaxis correcta.');
            $messages["participante_caminata.$j.correo.max"] = __('El campo correo no debe ser mayor a 60 caracteres.');
            $messages["participante_caminata.$j.direccion.required"] = __('El campo direccion es obligatorio.');
            $messages["participante_caminata.$j.direccion.string"] = __('El campo direccion debe ser una cadena de texto.');
            $messages["participante_caminata.$j.direccion.max"] = __('El campo direccion no debe ser mayor a 60 caracteres.');
            $messages["participante_caminata.$j.direccion.regex"] = __('El campo direccion no acepta caracteres especiales.');
            $messages["participante_caminata.$j.fecha_nacimiento.required"] = __('El campo fecha de nacimiento es obligatorio.');
            $messages["participante_caminata.$j.fecha_nacimiento.date"] = __('El campo fecha de nacimiento debe ser de tipo fecha');
            $messages["participante_caminata.$j.fecha_nacimiento.before_or_equal"] = __('El campo fecha de nacimiento debe ser menor o igual a ' . Carbon::parse($this->fecha_evento)->format('d-m-Y'));

            $messages["inscripcion_caminata.$j.metodo_pago_id.required"] = __('El campo cuentas es obligatorio.');

            $messages["inscripcion_caminata.$j.monto_Bs.required"] = __('El campo monto es obligatorio.');
            $messages["inscripcion_caminata.$j.monto_Bs.numeric"] = __('El campo monto solo permite numeros.');
            $messages["inscripcion_caminata.$j.monto_$.required"] = __('El campo monto es obligatorio.');
            $messages["inscripcion_caminata.$j.monto_$.numeric"] = __('El campo monto solo permite numeros.');

            $messages["inscripcion_caminata.$j.fecha.required"] = __('El campo fecha de pago es obligatorio.');
            $messages["inscripcion_caminata.$j.fecha.date"] = __('El campo fecha de pago debe tener la sintaxis correcta.');
            $messages["inscripcion_caminata.$j.fecha.before_or_equal"] = __('El campo fecha de pago debe ser menor o igual a ' . Carbon::parse($this->fecha_evento)->format('d-m-Y'));
            $messages["inscripcion_caminata.$j.referencia.required"] = __('El campo referencia es obligatorio.');
            $messages["inscripcion_caminata.$j.referencia.numeric"] = __('El campo referencia solo permite numeros.');
            $messages["inscripcion_caminata.$j.referencia.digits"] = __('El campo referencia solo admite 6 digitos');


            $messages["inscripcion_caminata.$j.monto_mixto_Bs.required"] = __('El campo monto es obligatorio.');
            $messages["inscripcion_caminata.$j.monto_mixto_Bs.numeric"] = __('El campo monto solo permite numeros.');
            $messages["inscripcion_caminata.$j.monto_mixto_$.required"] = __('El campo monto es obligatorio.');
            $messages["inscripcion_caminata.$j.monto_mixto_$.numeric"] = __('El campo monto solo permite numeros.');
            $messages["inscripcion_caminata.$j.fecha_mixto.required"] = __('El campo fecha de pago es obligatorio.');
            $messages["inscripcion_caminata.$j.fecha_mixto.date"] = __('El campo fecha de pago debe tener la sintaxis correcta.');
            $messages["inscripcion_caminata.$j.fecha_mixto.before_or_equal"] = __('El campo fecha de pago debe ser menor o igual a ' . Carbon::parse($this->fecha_actual)->format('d-m-Y'));

            $messages["inscripcion_caminata.$j.referencia_mixto.required"] = __('El campo referencia es obligatorio.');
            $messages["inscripcion_caminata.$j.referencia_mixto.numeric"] = __('El campo referencia solo permite numeros.');
            $messages["inscripcion_caminata.$j.referencia_mixto.digits"] = __('El campo referencia solo admite los ultimos 6 digitos');


            $messages["inscripcion_caminata.$j.cuenta_mixto_1.required"] = __('El campo cuenta es obligatorio.');
            $messages["inscripcion_caminata.$j.cuenta_mixto_1.string"] = __('El campo cuenta debe ser una cadena de texto. ');
            $messages["inscripcion_caminata.$j.cuenta_mixto_2.required"] = __('El campo cuenta es obligatorio.');
            $messages["inscripcion_caminata.$j.cuenta_mixto_2.string"] = __('El campo cuenta debe ser una cadena de texto. ');
        }
        return $messages;
    }

    public function buscarCedula_carrera()
    {
        for ($i = 0; $i <= $this->cantidad_carrera - 1; $i++) {
            $this->carrera_participante[$i] = participante::select('participantes.*', 'estados.id as estado_id')->where('cedula', $this->participante_carrera[$i]["cedula"])->join('ciudads', 'participantes.ciudad_id', '=', 'ciudads.id')->join('estados', 'ciudads.estado_id', '=', 'estados.id')->first();

            if (isset($this->carrera_participante[$i])) {
                $this->participante_carrera[$i]['ciudades'] = ciudad::where('estado_id', $this->carrera_participante[$i]->estado_id)->get();
                $this->participante_carrera[$i]["ciudad_id"] = $this->carrera_participante[$i]->ciudad_id;
                $this->participante_carrera[$i]["cedula"] = $this->carrera_participante[$i]->cedula;
                $this->participante_carrera[$i]["estado_id"] = $this->carrera_participante[$i]->estado_id;
                $this->participante_carrera[$i]["nombre"] = $this->carrera_participante[$i]->nombre;
                $this->participante_carrera[$i]["apellido"] = $this->carrera_participante[$i]->apellido;
                $this->participante_carrera[$i]["telefono"] = $this->carrera_participante[$i]->telefono;
                $this->participante_carrera[$i]["correo"] = $this->carrera_participante[$i]->correo;
                $this->participante_carrera[$i]["direccion"] = $this->carrera_participante[$i]->direccion;
                $this->participante_carrera[$i]["fecha_nacimiento"] = $this->carrera_participante[$i]->fecha_nacimiento;
            } else {
                $this->carrera_participante[$i] = null;
            }
        }
    }

    public function buscarCedula_caminata()
    {
        for ($i = 0; $i <= $this->cantidad_caminata - 1; $i++) {
            $this->caminata_participante[$i] = participante::select('participantes.*', 'estados.id as estado_id')->where('cedula', $this->participante_caminata[$i]["cedula"])->join('ciudads', 'participantes.ciudad_id', '=', 'ciudads.id')->join('estados', 'ciudads.estado_id', '=', 'estados.id')->first();

            if (isset($this->caminata_participante[$i])) {
                $this->participante_caminata[$i]['ciudades'] = ciudad::where('estado_id', $this->caminata_participante[$i]->estado_id)->get();
                $this->participante_caminata[$i]["ciudad_id"] = $this->caminata_participante[$i]->ciudad_id;
                $this->participante_caminata[$i]["cedula"] = $this->caminata_participante[$i]->cedula;
                $this->participante_caminata[$i]["estado_id"] = $this->caminata_participante[$i]->estado_id;
                $this->participante_caminata[$i]["nombre"] = $this->caminata_participante[$i]->nombre;
                $this->participante_caminata[$i]["apellido"] = $this->caminata_participante[$i]->apellido;
                $this->participante_caminata[$i]["telefono"] = $this->caminata_participante[$i]->telefono;
                $this->participante_caminata[$i]["correo"] = $this->caminata_participante[$i]->correo;
                $this->participante_caminata[$i]["direccion"] = $this->caminata_participante[$i]->direccion;
                $this->participante_caminata[$i]["fecha_nacimiento"] = $this->caminata_participante[$i]->fecha_nacimiento;
            } else {
                $this->caminata_participante[$i] = null;
            }
        }
    }

    public function asignar_prendas_carrera($value)
    {
        // Encuentra la prenda solo una vez
        $prenda = prenda::select('cantidad', 'restadas')->find($value);
        for ($i = 0; $i <= $this->cantidad_carrera - 1; $i++) {
            $this->create_prendas_carrera[$i]['prendas'] = $value;

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
    public function asignar_prendas_caminata($value)
    {
        // Encuentra la prenda solo una vez
        $prenda = prenda::select('cantidad', 'restadas')->find($value);
        for ($i = 0; $i <= $this->cantidad_caminata - 1; $i++) {
            $this->create_prendas_caminata[$i]['prendas'] = $value;

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
    public function update_prendas_caminata($index, $option)
    {

        if ($option === '1') {

            $this->create_prendas_caminata[$index]['genero'] = 'Masculino';
            $this->prendas_caminata[$index] = DB::table('prendas')
                ->join('prenda_tallas', 'prendas.prenda_talla_id', '=', 'prenda_tallas.id')->join('prenda_categories', 'prendas.prenda_category_id', '=', 'prenda_categories.id')->select('prendas.*', 'prenda_tallas.talla as prenda_talla', 'prenda_categories.nombre as prenda_categories_nombre')->where('prendas.sexo', 'Masculino')->get();
        } elseif ($option === '2') {
            $this->create_prendas_caminata[$index]['genero'] = 'Femenino';
            $this->prendas_caminata[$index] = DB::table('prendas')
                ->join('prenda_tallas', 'prendas.prenda_talla_id', '=', 'prenda_tallas.id')->join('prenda_categories', 'prendas.prenda_category_id', '=', 'prenda_categories.id')->select('prendas.*', 'prenda_tallas.talla as prenda_talla', 'prenda_categories.nombre as prenda_categories_nombre')->where('prendas.sexo', 'Femenino')->get();
        } elseif ($option === '') {
            $this->create_prendas_caminata[$index]['genero'] = null;
            $this->prendas_caminata = null;
        }
    }
    public function update_prendas_carrera($index, $option)
    {
        // Asignar el género basado en la opción seleccionada
        if ($option === '1') {
            $this->create_prendas_carrera[$index]['genero'] = 'Masculino';
            $this->prendas_carrera[$index] = DB::table('prendas')
                ->join('prenda_tallas', 'prendas.prenda_talla_id', '=', 'prenda_tallas.id')
                ->join('prenda_categories', 'prendas.prenda_category_id', '=', 'prenda_categories.id')
                ->select('prendas.*', 'prenda_tallas.talla as prenda_talla', 'prenda_categories.nombre as prenda_categories_nombre')
                ->where('prendas.sexo', 'Masculino')
                ->get();
        } elseif ($option === '2') {
            $this->create_prendas_carrera[$index]['genero'] = 'Femenino';
            $this->prendas_carrera[$index] = DB::table('prendas')
                ->join('prenda_tallas', 'prendas.prenda_talla_id', '=', 'prenda_tallas.id')
                ->join('prenda_categories', 'prendas.prenda_category_id', '=', 'prenda_categories.id')
                ->select('prendas.*', 'prenda_tallas.talla as prenda_talla', 'prenda_categories.nombre as prenda_categories_nombre')
                ->where('prendas.sexo', 'Femenino')
                ->get();
        } elseif ($option === '') {
            $this->create_prendas_carrera[$index]['genero'] = null;
            $this->prendas_carrera[$index] = null; // Cambia esto para que sea específico para el índice
        }
    }

    public function save()
    {
        $this->validate();
        $evento = evento::select('id', 'nombre', 'fecha_evento')->where('estado', true)->orderBy('id', 'desc')->first();

        $ultimoNumeroOrden = Inscripcion::max('id');
        $this->nuevoNumeroOrden = $ultimoNumeroOrden ? $ultimoNumeroOrden + 1 : 1;
        $this->nomenclatura = 'GRMX' . '-' . $this->grupo->cantidad . $this->nuevoNumeroOrden;

        for ($i = 0; $i <= $this->cantidad_caminata - 1; $i++) {
            if (!empty($this->caminata_participante[$i]) && !is_null($this->caminata_participante[$i])) {
                if (isset($this->caminata_participante[$i]->id)) {
                    $this->participantes_ids[] = $this->caminata_participante[$i]->id;

                    $this->inscripcion_validate_global = inscripcion::whereIn('participante_id', $this->participantes_ids)->join('participantes', 'participantes.id', '=', 'inscripcions.participante_id')->join('eventos', 'inscripcions.evento_id', '=', 'eventos.id')->where('eventos.estado', true)->get()->toArray();
                }
            } else {
                $this->inscripcion_validate_global = [];
            }
        }
        for ($i = 0; $i <= $this->cantidad_carrera - 1; $i++) {
            if (!empty($this->carrera_participante[$i]) && !is_null($this->carrera_participante[$i])) {
                if (isset($this->carrera_participante[$i]->id)) {
                    $this->participantes_ids[] = $this->carrera_participante[$i]->id;

                    $this->inscripcion_validate_global = inscripcion::whereIn('participante_id', $this->participantes_ids)->join('participantes', 'participantes.id', '=', 'inscripcions.participante_id')->join('eventos', 'inscripcions.evento_id', '=', 'eventos.id')->where('eventos.estado', true)->get()->toArray();
                }
            } else {
                $this->inscripcion_validate_global = [];
            }
        }

        if (!empty($this->inscripcion_validate_global)) {
            for ($i = 0; $i <= $this->cantidad_caminata - 1; $i++) {
                $this->cedula = $this->inscripcion_validate_global[$i]['cedula'];
                $this->nombre = $this->inscripcion_validate_global[$i]['nombre'];
                $this->apellido = $this->inscripcion_validate_global[$i]['apellido'];
                $this->inscripcion_validate_global = [];

                $this->participantes_ids = [];

                return $this->dispatch('existe', ['cedula' => $this->cedula], ['nombre' => $this->nombre], ['apellido' => $this->apellido]);
                //Retornar mensaje de validacion con datos del participante que se repite

            }
            for ($i = 0; $i <= $this->cantidad_carrera - 1; $i++) {
                $this->cedula = $this->inscripcion_validate_global[$i]['cedula'];
                $nombre_inscripcion_validate_global = $this->inscripcion_validate_global[$i]['nombre'];
                $apellido_inscripcion_validate_global = $this->inscripcion_validate_global[$i]['apellido'];
                $this->inscripcion_validate_global = [];

                $this->participantes_ids = [];

                return $this->dispatch('existe', ['valor' => $this->cedula]);
                //Retornar mensaje de validacion con datos del participante que se repite
            }
        } else {
            for ($i = 0; $i <= $this->cantidad_caminata - 1; $i++) {
                //Validar si alguno de los enviados ya se encuentra registrado en el evento actual
                if (isset($this->caminata_participante[$i]) && !is_null($this->caminata_participante[$i])) {

                    $latestId = $this->caminata_participante[$i]->id;
                    $this->inscripcion_caminata[$i]['participante_id'] = $latestId;
                    $datos_json = [
                        'fecha' => $this->inscripcion_caminata[$i]['fecha'],
                        'referencia' => $this->inscripcion_caminata[$i]['referencia']
                    ];
                    if (!is_null($this->inscripcion_caminata[$i]['monto_Bs'])) {
                        $datos_json += [
                            'monto_Bs' => $this->inscripcion_caminata[$i]['monto_Bs'],
                        ];
                    } else {
                        $datos_json += [
                            'monto_USD' => $this->inscripcion_caminata[$i]['monto_USD'],
                        ];
                    }
                    if (!is_null($this->inscripcion_caminata[$i]['monto_mixto_Bs']) || !is_null($this->inscripcion_caminata[$i]['monto_mixto_USD'])) {
                        $datos_json += [
                            'fecha_mixto' => $this->inscripcion_caminata[$i]['fecha_mixto'],
                            'referencia_mixto' => $this->inscripcion_caminata[$i]['referencia_mixto'],
                            'cuenta_mixto_1' => $this->inscripcion_caminata[$i]['cuenta_mixto_1'],
                            'cuenta_mixto_2' => $this->inscripcion_caminata[$i]['cuenta_mixto_2']
                        ];
                        if (!is_null($this->inscripcion_caminata[$i]['monto_mixto_Bs'])) {
                            $datos_json += [
                                'monto_mixto_Bs' => $this->inscripcion_caminata[$i]['monto_mixto_Bs'],
                            ];
                        } else if (!is_null($this->inscripcion_caminata[$i]['monto_mixto_USD'])) {
                            $datos_json += [
                                'monto_mixto_USD' => $this->inscripcion_caminata[$i]['monto_mixto_USD'],
                            ];
                        }
                    }
                    $datos_json = json_encode($datos_json);
                    $this->inscripcion_caminata[$i]['datos'] = $datos_json;

                    if (is_null($this->inscripcion_caminata[$i]['metodo_pago_id'])) {
                        $this->inscripcion_caminata[$i]['metodo_pago_id'] = 1;
                    }
                    if (is_null($this->inscripcion_caminata[$i]['recorrido_id'])) {
                        $this->inscripcion_caminata[$i]['recorrido_id'] = 1;
                    }
                    $this->inscripcion_caminata[$i]['recorrido_id_grupos'] = $this->grupo->recorrido_id;
                    $this->inscripcion_caminata[$i]['nomenclatura'] = $this->nomenclatura;
                    $this->inscripcion_caminata[$i]['ip'] = $this->userIp;
                    $this->inscripcion_caminata[$i]['categoria_habilitada_id'] = 12;
                    if (!is_null($this->create_prendas_caminata[$i]['prendas'])) {
                        $this->inscripcion_caminata[$i]['prenda_id'] = $this->create_prendas_caminata[$i]['prendas'];
                        $this->asignar_prendas_caminata($this->create_prendas_caminata[$i]['prendas']);
                    } else {
                        $this->inscripcion_caminata[$i]['prenda_id'] = 1;
                    }
                    $inscripciones = inscripcion::create([
                        'evento_id' => $this->inscripcion_caminata[$i]['evento_id'],
                        'participante_id' => $this->inscripcion_caminata[$i]['participante_id'],
                        'metodo_pago_id' => $this->inscripcion_caminata[$i]['metodo_pago_id'],
                        'grupo_id' => $this->inscripcion_caminata[$i]['grupo_id'],
                        'dolar_id' => $this->inscripcion_caminata[$i]['dolar_id'],
                        'numero_id' => $this->inscripcion_caminata[$i]['numero_id'],
                        'categoria_habilitada_id' => $this->inscripcion_caminata[$i]['categoria_habilitada_id'],
                        'mesa_id' => $this->inscripcion_caminata[$i]['mesa_id'],
                        'datos' => $this->inscripcion_caminata[$i]['datos'],
                        'monto_pagado_bs' => $this->inscripcion_caminata[$i]['monto_pagado_bs'],
                        'ip' => $this->inscripcion_caminata[$i]['ip'],
                        'nomenclatura' => $this->inscripcion_caminata[$i]['nomenclatura'],
                        'recorrido_id' => $this->inscripcion_caminata[$i]['recorrido_id'],
                        'recorrido_id_grupos' => $this->inscripcion_caminata[$i]['recorrido_id_grupos'],
                        'prenda_id' => $this->inscripcion_caminata[$i]['prenda_id'],
                    ]);
                    $ultima_inscripcion_id = inscripcion::latest('id')->first()->id;
                    $this->asignar_num_mesa_caminata($ultima_inscripcion_id, $this->participante_caminata[$i]['cedula']);
                } else {
                    $participante = participante::create([
                        'ciudad_id' => $this->participante_caminata[$i]['ciudad_id'],
                        'cedula' => $this->participante_caminata[$i]['cedula'],
                        'nombre' => $this->participante_caminata[$i]['nombre'],
                        'apellido' => $this->participante_caminata[$i]['apellido'],
                        'telefono' => $this->participante_caminata[$i]['telefono'],
                        'correo' => $this->participante_caminata[$i]['correo'],
                        'direccion' => $this->participante_caminata[$i]['direccion'],
                        'fecha_nacimiento' => $this->participante_caminata[$i]['fecha_nacimiento'],
                        'genero_id' => $this->participante_caminata[$i]['genero_id'],
                    ]);
                    $latestId = participante::latest('id')->first()->id;
                    $this->inscripcion_caminata[$i]['participante_id'] = $latestId;
                    $ultimoParticipante = participante::find($latestId);
                    $datos_json = [
                        'fecha' => $this->inscripcion_caminata[$i]['fecha'],
                        'referencia' => $this->inscripcion_caminata[$i]['referencia']
                    ];
                    if (!is_null($this->inscripcion_caminata[$i]['monto_Bs'])) {
                        $datos_json += [
                            'monto_Bs' => $this->inscripcion_caminata[$i]['monto_Bs'],
                        ];
                    } else {
                        $datos_json += [
                            'monto_USD' => $this->inscripcion_caminata[$i]['monto_USD'],
                        ];
                    }
                    if (!is_null($this->inscripcion_caminata[$i]['monto_mixto_Bs']) || !is_null($this->inscripcion_caminata[$i]['monto_mixto_USD'])) {
                        $datos_json += [
                            'fecha_mixto' => $this->inscripcion_caminata[$i]['fecha_mixto'],
                            'referencia_mixto' => $this->inscripcion_caminata[$i]['referencia_mixto'],
                            'cuenta_mixto_1' => $this->inscripcion_caminata[$i]['cuenta_mixto_1'],
                            'cuenta_mixto_2' => $this->inscripcion_caminata[$i]['cuenta_mixto_2']
                        ];
                        if (!is_null($this->inscripcion_caminata[$i]['monto_mixto_Bs'])) {
                            $datos_json += [
                                'monto_mixto_Bs' => $this->inscripcion_caminata[$i]['monto_mixto_Bs'],
                            ];
                        } else if (!is_null($this->inscripcion_caminata[$i]['monto_mixto_USD'])) {
                            $datos_json += [
                                'monto_mixto_USD' => $this->inscripcion_caminata[$i]['monto_mixto_USD'],
                            ];
                        }
                    }

                    $datos_json = json_encode($datos_json);
                    $this->inscripcion_caminata[$i]['datos'] = $datos_json;

                    if (is_null($this->inscripcion_caminata[$i]['metodo_pago_id'])) {
                        $this->inscripcion_caminata[$i]['metodo_pago_id'] = 1;
                    }
                    if (is_null($this->inscripcion_caminata[$i]['recorrido_id'])) {
                        $this->inscripcion_caminata[$i]['recorrido_id'] = 1;
                    }
                    $this->inscripcion_caminata[$i]['recorrido_id_grupos'] = $this->grupo->recorrido_id;

                    $this->inscripcion_caminata[$i]['nomenclatura'] = $this->nomenclatura;
                    $this->inscripcion_caminata[$i]['ip'] = $this->userIp;
                    $this->inscripcion_caminata[$i]['categoria_habilitada_id'] = 12;
                    if (!is_null($this->create_prendas_caminata[$i]['prendas'])) {
                        $this->inscripcion_caminata[$i]['prenda_id'] = $this->create_prendas_caminata[$i]['prendas'];
                        $this->asignar_prendas_caminata($this->create_prendas_caminata[$i]['prendas']);
                    } else {
                        $this->inscripcion_caminata[$i]['prenda_id'] = 1;
                    }

                    $inscripciones = inscripcion::create([
                        'evento_id' => $this->inscripcion_caminata[$i]['evento_id'],
                        'participante_id' => $this->inscripcion_caminata[$i]['participante_id'],
                        'metodo_pago_id' => $this->inscripcion_caminata[$i]['metodo_pago_id'],
                        'grupo_id' => $this->inscripcion_caminata[$i]['grupo_id'],
                        'dolar_id' => $this->inscripcion_caminata[$i]['dolar_id'],
                        'numero_id' => $this->inscripcion_caminata[$i]['numero_id'],
                        'categoria_habilitada_id' => $this->inscripcion_caminata[$i]['categoria_habilitada_id'],
                        'mesa_id' => $this->inscripcion_caminata[$i]['mesa_id'],
                        'datos' => $this->inscripcion_caminata[$i]['datos'],
                        'monto_pagado_bs' => $this->inscripcion_caminata[$i]['monto_pagado_bs'],
                        'ip' => $this->inscripcion_caminata[$i]['ip'],
                        'nomenclatura' => $this->inscripcion_caminata[$i]['nomenclatura'],
                        'recorrido_id' => $this->inscripcion_caminata[$i]['recorrido_id'],
                        'recorrido_id_grupos' => $this->inscripcion_caminata[$i]['recorrido_id_grupos'],
                        'prenda_id' => $this->inscripcion_caminata[$i]['prenda_id'],
                    ]);
                    $ultima_inscripcion_id = inscripcion::latest('id')->first()->id;
                    $this->asignar_num_mesa_caminata($ultima_inscripcion_id, $this->participante_caminata[$i]['cedula']);
                }
            }

            for ($i = 0; $i <= $this->cantidad_carrera - 1; $i++) {

                //Validar si alguno de los enviados ya se encuentra registrado en el evento actual
                if (isset($this->carrera_participante[$i]) && !is_null($this->carrera_participante[$i])) {

                    $latestId = $this->carrera_participante[$i]->id;
                    $this->inscripcion_carrera[$i]['participante_id'] = $latestId;
                    $ultimoParticipante = participante::find($latestId);
                    $datos_json = [
                        'fecha' => $this->inscripcion_carrera[$i]['fecha'],
                        'referencia' => $this->inscripcion_carrera[$i]['referencia']

                    ];
                    if (!is_null($this->inscripcion_carrera[$i]['monto_Bs'])) {
                        $datos_json += [
                            'monto_Bs' => $this->inscripcion_carrera[$i]['monto_Bs'],
                        ];
                    } else {
                        $datos_json += [
                            'monto_USD' => $this->inscripcion_carrera[$i]['monto_USD'],
                        ];
                    }

                    if (!is_null($this->inscripcion_carrera[$i]['monto_mixto_Bs']) || !is_null($this->inscripcion_carrera[$i]['monto_mixto_USD'])) {
                        $datos_json += [
                            'fecha_mixto' => $this->inscripcion_carrera[$i]['fecha_mixto'],
                            'referencia_mixto' => $this->inscripcion_carrera[$i]['referencia_mixto'],
                            'cuenta_mixto_1' => $this->inscripcion_carrera[$i]['cuenta_mixto_1'],
                            'cuenta_mixto_2' => $this->inscripcion_carrera[$i]['cuenta_mixto_2']
                        ];
                        if (!is_null($this->inscripcion_carrera[$i]['monto_mixto_Bs'])) {
                            $datos_json += [
                                'monto_mixto_Bs' => $this->inscripcion_carrera[$i]['monto_mixto_Bs'],
                            ];
                        } else if (!is_null($this->inscripcion_carrera[$i]['monto_mixto_USD'])) {
                            $datos_json += [
                                'monto_mixto_USD' => $this->inscripcion_carrera[$i]['monto_mixto_USD'],
                            ];
                        }
                    }
                    $datos_json = json_encode($datos_json);
                    $this->inscripcion_carrera[$i]['datos'] = $datos_json;
                    $categoria_id = $this->edad($ultimoParticipante->fecha_nacimiento);
                    $this->inscripcion_carrera[$i]['categoria_habilitada_id'] = $categoria_id;

                    if (is_null($this->inscripcion_carrera[$i]['metodo_pago_id'])) {
                        $this->inscripcion_carrera[$i]['metodo_pago_id'] = 1;
                    }
                    if (is_null($this->inscripcion_carrera[$i]['recorrido_id'])) {
                        $this->inscripcion_carrera[$i]['recorrido_id'] = 2;
                    }
                    $this->inscripcion_carrera[$i]['recorrido_id_grupos'] = $this->grupo->recorrido_id;

                    $this->inscripcion_carrera[$i]['nomenclatura'] = $this->nomenclatura;
                    $this->inscripcion_carrera[$i]['ip'] = $this->userIp;
                    if (!is_null($this->create_prendas_carrera[$i]['prendas'])) {
                        $this->inscripcion_carrera[$i]['prenda_id'] = $this->create_prendas_carrera[$i]['prendas'];
                        $this->asignar_prendas_carrera($this->create_prendas_carrera[$i]['prendas']);
                    } else {
                        $this->inscripcion_carrera[$i]['prenda_id'] = 1;
                    }
                    $inscripciones = inscripcion::create([
                        'evento_id' => $this->inscripcion_carrera[$i]['evento_id'],
                        'participante_id' => $this->inscripcion_carrera[$i]['participante_id'],
                        'metodo_pago_id' => $this->inscripcion_carrera[$i]['metodo_pago_id'],
                        'grupo_id' => $this->inscripcion_carrera[$i]['grupo_id'],
                        'dolar_id' => $this->inscripcion_carrera[$i]['dolar_id'],
                        'numero_id' => $this->inscripcion_carrera[$i]['numero_id'] ?? null,
                        'categoria_habilitada_id' => $this->inscripcion_carrera[$i]['categoria_habilitada_id'] ?? null,
                        'mesa_id' => $this->inscripcion_carrera[$i]['mesa_id'] ?? null,
                        'datos' => $this->inscripcion_carrera[$i]['datos'],
                        'monto_pagado_bs' => $this->inscripcion_carrera[$i]['monto_pagado_bs'],
                        'ip' => $this->inscripcion_carrera[$i]['ip'],
                        'nomenclatura' => $this->inscripcion_carrera[$i]['nomenclatura'],
                        'recorrido_id' => $this->inscripcion_carrera[$i]['recorrido_id'],
                        'recorrido_id_grupos' => $this->inscripcion_carrera[$i]['recorrido_id_grupos'],
                        'prenda_id' => $this->inscripcion_carrera[$i]['prenda_id'],
                    ]);
                    $ultima_inscripcion_id = inscripcion::latest('id')->first()->id;
                    $this->asignar_num_mesa_carrera($ultima_inscripcion_id, $this->participante_carrera[$i]['cedula']);
                } else {
                    $participante = participante::create([
                        'ciudad_id' => $this->participante_carrera[$i]['ciudad_id'],
                        'cedula' => $this->participante_carrera[$i]['cedula'],
                        'nombre' => $this->participante_carrera[$i]['nombre'],
                        'apellido' => $this->participante_carrera[$i]['apellido'],
                        'telefono' => $this->participante_carrera[$i]['telefono'],
                        'correo' => $this->participante_carrera[$i]['correo'],
                        'direccion' => $this->participante_carrera[$i]['direccion'],
                        'fecha_nacimiento' => $this->participante_carrera[$i]['fecha_nacimiento'],
                        'genero_id' => $this->participante_carrera[$i]['genero_id'],

                    ]);
                    $latestId = participante::latest('id')->first()->id;
                    $this->inscripcion_carrera[$i]['participante_id'] = $latestId;
                    $ultimoParticipante = participante::find($latestId);
                    $datos_json = [
                        'fecha' => $this->inscripcion_carrera[$i]['fecha'],
                        'referencia' => $this->inscripcion_carrera[$i]['referencia']

                    ];
                    if (!is_null($this->inscripcion_carrera[$i]['monto_Bs'])) {
                        $datos_json += [
                            'monto_Bs' => $this->inscripcion_carrera[$i]['monto_Bs'],
                        ];
                    } else {
                        $datos_json += [
                            'monto_USD' => $this->inscripcion_carrera[$i]['monto_USD'],
                        ];
                    }

                    if (!is_null($this->inscripcion_carrera[$i]['monto_mixto_Bs']) || !is_null($this->inscripcion_carrera[$i]['monto_mixto_$'])) {
                        $datos_json += [
                            'fecha_mixto' => $this->inscripcion_carrera[$i]['fecha_mixto'],
                            'referencia_mixto' => $this->inscripcion_carrera[$i]['referencia_mixto'],
                            'cuenta_mixto_1' => $this->inscripcion_carrera[$i]['cuenta_mixto_1'],
                            'cuenta_mixto_2' => $this->inscripcion_carrera[$i]['cuenta_mixto_2']
                        ];
                        if (!is_null($this->inscripcion_carrera[$i]['monto_mixto_Bs'])) {
                            $datos_json += [
                                'monto_mixto_Bs' => $this->inscripcion_carrera[$i]['monto_mixto_Bs'],
                            ];
                        } else if (!is_null($this->inscripcion_carrera[$i]['monto_mixto_USD'])) {
                            $datos_json += [
                                'monto_mixto_USD' => $this->inscripcion_carrera[$i]['monto_mixto_USD'],
                            ];
                        }
                    }
                    $datos_json = json_encode($datos_json);
                    $this->inscripcion_carrera[$i]['datos'] = $datos_json;
                    $categoria_id = $this->edad($ultimoParticipante->fecha_nacimiento);
                    $this->inscripcion_carrera[$i]['categoria_habilitada_id'] = $categoria_id;

                    if (is_null($this->inscripcion_carrera[$i]['metodo_pago_id'])) {
                        $this->inscripcion_carrera[$i]['metodo_pago_id'] = 1;
                    }
                    if (is_null($this->inscripcion_carrera[$i]['recorrido_id'])) {
                        $this->inscripcion_carrera[$i]['recorrido_id'] = 2;
                    }
                    $this->inscripcion_carrera[$i]['recorrido_id_grupos'] = $this->grupo->recorrido_id;

                    $this->inscripcion_carrera[$i]['nomenclatura'] = $this->nomenclatura;
                    $this->inscripcion_carrera[$i]['ip'] = $this->userIp;
                    if (!is_null($this->create_prendas_carrera[$i]['prendas'])) {
                        $this->inscripcion_carrera[$i]['prenda_id'] = $this->create_prendas_carrera[$i]['prendas'];
                        $this->asignar_prendas_carrera($this->create_prendas_carrera[$i]['prendas']);
                    } else {
                        $this->inscripcion_carrera[$i]['prenda_id'] = 1;
                    }

                    $inscripciones = inscripcion::create([
                        'evento_id' => $this->inscripcion_carrera[$i]['evento_id'],
                        'participante_id' => $this->inscripcion_carrera[$i]['participante_id'],
                        'metodo_pago_id' => $this->inscripcion_carrera[$i]['metodo_pago_id'],
                        'grupo_id' => $this->inscripcion_carrera[$i]['grupo_id'],
                        'dolar_id' => $this->inscripcion_carrera[$i]['dolar_id'],
                        'numero_id' => $this->inscripcion_carrera[$i]['numero_id'] ?? null,
                        'categoria_habilitada_id' => $this->inscripcion_carrera[$i]['categoria_habilitada_id'] ?? null,
                        'mesa_id' => $this->inscripcion_carrera[$i]['mesa_id'] ?? null,
                        'datos' => $this->inscripcion_carrera[$i]['datos'],
                        'monto_pagado_bs' => $this->inscripcion_carrera[$i]['monto_pagado_bs'],
                        'ip' => $this->inscripcion_carrera[$i]['ip'],
                        'nomenclatura' => $this->inscripcion_carrera[$i]['nomenclatura'],
                        'recorrido_id' => $this->inscripcion_carrera[$i]['recorrido_id'],
                        'recorrido_id_grupos' => $this->inscripcion_carrera[$i]['recorrido_id_grupos'],
                        'prenda_id' => $this->inscripcion_carrera[$i]['prenda_id'],
                    ]);
                    $ultima_inscripcion_id = inscripcion::latest('id')->first()->id;
                    $this->asignar_num_mesa_carrera($ultima_inscripcion_id, $this->participante_carrera[$i]['cedula']);
                }
            }
        }
        $this->dispatch('alert');
        $this->participante_caminata = [];
        $this->inscripcion_caminata = [];
        $this->participante_carrera = [];
        $this->inscripcion_carrera = [];
    }
    public function render()
    {
        return view('livewire.formulario-inscripcion.formulario-mixto');
    }
}
