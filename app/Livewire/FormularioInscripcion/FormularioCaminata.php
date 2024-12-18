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

    public $unico_valor = null;
    public $mixto_valor = null;

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
        'categoria_habilitada_id' => null,
        'mesa_id' => null,
        'datos' => "",
        'monto_pagado_bs' => "",
        'ip' => "",
        'nomenclatura' => "",
        'metodo' => null,
        'metodos' => [],
        'unico' => null,
        'mixto' => null,
    ];


    public function mount($id = null)
    {
        if (!is_null($id)) {




            $this->evento = evento::select('id', 'nombre')->where('estado', true)->orderBy('id', 'desc')->first();



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
                    'categoria_habilitada_id' => null,
                    'mesa_id' => null,
                    'datos' => "",
                    'monto_pagado_bs' =>  $this->calculo($this->grupo->precio),
                    'ip' => "",
                    'nomenclatura' => "",
                    'metodo' => null,
                    'metodos' => [],
                    'unico' => null,
                    'mixto' => null,
                ];
                $this->unico_valor = $this->create_inscripcion[$i]['unico'];
                $this->mixto_valor = $this->create_inscripcion[$i]['mixto'];


                //return var_dump($this->create_participante[$i]);

            }

            $this->ciudad = ciudad::all();
            $this->mesa = mesa::all();


            $this->metodo_pago = DB::table('metodo_pagos')->join('tipo_pagos', 'metodo_pagos.tipo_pago_id', '=', 'tipo_pagos.id')->join('bancos', 'metodo_pagos.banco_id', '=', 'bancos.id')->select('metodo_pagos.*', 'tipo_pagos.nombre as tipo_pago_nombre', 'bancos.nombre as banco_nombre')->get();
        }

        //$this->create_inscripcion['metodo_pago_id'] = $this->metodo_pago->id;




    }

    public function updatedCreateParticipante($value, $name)
    {
        $parts = explode('.', $name);
        $index = $parts[0];
        $field = $parts[1];
        if ($field === 'estado_id') {
            $this->create_participante[$index]['ciudades'] = ciudad::where('estado_id', $value)->get();
            /*  return dd($this->create_participante[$index]['ciudades']); */
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
        $fecha_nacimiento = Carbon::parse($fecha_nacimiento);
        $ahora = Carbon::now();
        $edad = $ahora->diffInYears($fecha_nacimiento);

        foreach ($this->categoria_habilitada as $categoria_habilitadas) {
            if ($edad >= $categoria_habilitadas->edad_min && $edad <= $categoria_habilitadas->edad_max) {
                return $categoria_habilitadas->id;
            }
        }
        return null;
    }

    public function asignar_num_mesa($inscripcion_id, $cedula)
    {
        $ultimo_digito = substr($cedula, -1);

        $this->inscripcion = inscripcion::find($inscripcion_id);
        if ($ultimo_digito == '0' || $ultimo_digito == '1') {
            $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [1, 100])->orderBy('id', 'asc')->first();

            /* logica asignacion de numeros y mesa*/
            $this->inscripcion->numero_id = $numero_id->id;
            $this->inscripcion->mesa_id = Mesas_enum::Mesa_1;
            $this->inscripcion->save();
            /* update numero asignado */
            $this->numero = numero::find($numero_id->id);
            $this->numero->disponible = false;
            $this->numero->save();
        } else if ($ultimo_digito == '2' || $ultimo_digito == '3') {
            $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [101, 200])->orderBy('id', 'asc')->first();

            /* logica asignacion de numeros y mesa*/
            $this->inscripcion->numero_id = $numero_id->id;
            $this->inscripcion->mesa_id = Mesas_enum::Mesa_2;
            $this->inscripcion->save();
            /* update numero asignado */
            $this->numero = numero::find($numero_id->id);
            $this->numero->disponible = false;
            $this->numero->save();
        } else if ($ultimo_digito == '4' || $ultimo_digito == '5') {
            $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [201, 300])->orderBy('id', 'asc')->first();

            /* logica asignacion de numeros y mesa*/
            $this->inscripcion->numero_id = $numero_id->id;
            $this->inscripcion->mesa_id = Mesas_enum::Mesa_3;
            $this->inscripcion->save();
            /* update numero asignado */
            $this->numero = numero::find($numero_id->id);
            $this->numero->disponible = false;
            $this->numero->save();
        } else if ($ultimo_digito == '6' || $ultimo_digito == '7') {
            $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [301, 400])->orderBy('id', 'asc')->first();

            /* logica asignacion de numeros y mesa*/
            $this->inscripcion->numero_id = $numero_id->id;
            $this->inscripcion->mesa_id = Mesas_enum::Mesa_4;
            $this->inscripcion->save();
            /* update numero asignado */
            $this->numero = numero::find($numero_id->id);
            $this->numero->disponible = false;
            $this->numero->save();
        } else if ($ultimo_digito == '8' || $ultimo_digito == '9') {
            $numero_id = numero::select('id')->where('disponible', true)->where('estado', true)->whereBetween('id', [401, 500])->orderBy('id', 'asc')->first();

            /* logica asignacion de numeros y mesa*/
            $this->inscripcion->numero_id = $numero_id->id;
            $this->inscripcion->mesa_id = Mesas_enum::Mesa_5;
            $this->inscripcion->save();
            /* update numero asignado */
            $this->numero = numero::find($numero_id->id);
            $this->numero->disponible = false;
            $this->numero->save();
        }
    }


    public function save()
    {
        /* return dd( $this->create_participante[0]['ciudad_id'],$this->create_participante[1]['ciudad_id']); */
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

            if (!is_null($this->create_inscripcion[$i]['referencia2'])) {
                $datos_json += [
                    'monto_mixto' => $this->create_inscripcion[$i]['monto_mixto'],
                    'fecha_mixto' => $this->create_inscripcion[$i]['fecha_mixto'],
                    'referencia_mixto' => $this->create_inscripcion[$i]['referencia_mixto']

                ];
            }
            $datos_json=json_encode($this->$datos_json);

            $this->create_inscripcion[$i]['datos'] = $datos_json;

            $categoria_id = $this->edad($ultimoParticipante->fecha_nacimiento);

            $this->create_inscripcion[$i]['categoria_habilitada_id'] = $categoria_id;



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
