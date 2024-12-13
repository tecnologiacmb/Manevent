<?php

namespace App\Livewire\FormularioInscripcion;

use Livewire\Component;
 use Illuminate\Support\Facades\DB;
 use App\Models\evento;
use App\Models\participante;

use App\Models\grupo;
use App\Models\dolar;
use App\Models\numero;
use App\Models\inscripcion;
use App\Models\estado;
use App\Models\ciudad;

use SebastianBergmann\Environment\Console;

class FormularioCaminata extends Component
{
    public $evento;
    public $participante;
    public $metodo_pago;
    public $grupo;
    public $dolars;
    public $numero;
    public $estado;
    public $ciudad;
    public $participante_id;
    public $banco;
    public $tipo_pago;
    public $opcion=null;
    public $opcion2=null;
    public $opcion3=null;
    public $opcion4=null;
    public $groupId=null;


    public $create_participante= [
        'ciudad_id' => "",
        'cedula' => "",
        'nombre' => "",
        'apellido' => "",
        'telefono' => "",
        'correo' => "",
        'direccion' => "",
        'fecha_nacimiento' => "",
    ];

    public $create_inscripcion= [

        'evento_id' => "",
        'cedula' => "",
        'participante_id' => "",
        'metodo_pago_id' => "",
        'grupo_id' => "",
        'dolar_id' => "",
        'numero_id' => "",
        'datos' => "",
        'monto_pagado_bs' => "",
        'ip' => "",
        'nomenclatura' => "",

    ];


    public function mount()
    {
        $this->evento = evento::all();
        $this->participante = participante::all();
        $this->grupo = grupo::all();
        $this->dolars = dolar::where('');
        $this->create_inscripcion['monto_pagado_bs']= $this->dolars;
        $this->numero = numero::all();
        $this->estado = estado::all();
        $this->ciudad = ciudad::all();
        $this->metodo_pago = DB::table('metodo_pagos')->join('tipo_pagos', 'metodo_pagos.tipo_pago_id', '=', 'tipo_pagos.id')->join('bancos', 'metodo_pagos.banco_id', '=', 'bancos.id')->select('metodo_pagos.*', 'tipo_pagos.name as tipo_pago_nombre', 'bancos.name as banco_nombre')->get();


        $this->groupId = request()->get('groupId');


    }
    public function changeEvent($value){

        $this->opcion = $value;

    }

    public function changeEvent2($value){

        $this->opcion2 = $value;
    }

    public function changeEvent3($value){

        $this->opcion3 = $value;

    }
    public function changeEvent4($value){


        $this->opcion4 = $value;
    }

    public function calculo($num){
        $total = 0;
        $ultimoDolar = $this->dolars->last();

        $total = $num * $ultimoDolar->valor;

        return $total;
    }

    public function seve()
    {

        $posts = participante::create([
            'ciudad_id' => $this->create_participante['ciudad_id'],
            'cedula' => $this->create_participante['cedula'],
            'nombre' => $this->create_participante['nombre'],
            'apellido' => $this->create_participante['apellido'],
            'telefono' => $this->create_participante['telefono'],
            'correo' => $this->create_participante['correo'],
            'direccion' => $this->create_participante['direccion'],
            'fecha_nacimiento' => $this->create_participante['fecha_nacimiento'],

        ]);
        $latestId = participante::latest('id')->first()->id;

        $datos_json = json_encode([
            'monto' => $this->create_inscripcion['monto'],
             'fecha' => $this->create_inscripcion['fecha'],
             'referencia' => $this->create_inscripcion['referencia']
            ]);

         $this->create_inscripcion['datos'] = $datos_json;

        $posts = inscripcion::create([
            'evento_id' => $this->create_inscripcion['evento_id'],
            'cedula' => $this->create_inscripcion['cedula'],
            $latestId => $this->create_inscripcion['participante_id'],
            'metodo_pago_id' => $this->create_inscripcion['metodo_pago_id'],
            'grupo_id' => $this->create_inscripcion['grupo_id'],
            'dolar_id' => $this->create_inscripcion['dolar_id'],
            'numero_id' => $this->create_inscripcion['numero_id'],
            'datos' => $this->create_inscripcion['datos'],
            'monto_pagado_bs' => $this->create_inscripcion['monto_pagado_bs'],
            'ip' => $this->create_inscripcion['ip'],
            'nomenclatura' => $this->create_inscripcion['nomenclatura'],

        ]);


        $this->reset(['create_participante']);
        $this->reset(['create_inscripcion']);
        $this->participante = participante::all();
        $this->participante = inscripcion::all();

    }
    public function render()
    {
        return view('livewire.formulario-inscripcion.formulario-caminata',[
            'dolar' => $this->dolars ]);

    }
}
