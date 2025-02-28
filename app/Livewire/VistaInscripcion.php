<?php

namespace App\Livewire;

use App\Models\inscripcion;
use App\Models\numero;
use App\Models\recorrido;
use App\Models\mesa;
use App\Models\grupo;
use App\Models\categoriaHabilitada;



use Livewire\Component;

class VistaInscripcion extends Component
{
    public $post_edit_id;
    public $post_update = [
        'evento_id' => null,
        'participante_id' => "",
        'metodo_pago_id' => "",
        'grupo_id' => "",
        'grupo_precio' => "",
        'dolar_id' => "",
        'numero_id' => "",
        'categoria_habilitada_id' => null,
        'mesa_id' => null,
        'datos' => [],
        'monto_pagado_bs' => "",
        'ip' => null,
        'nomenclatura' => "",
        'recorrido_id' => "",
        'created_at' => ""
    ];
    public $participantes = null;
    public $estados;
    public $ciudad;
    public $numeros;
    public $post;
    public $recorridos;
    public $mesas;
    public $grupos;
    public $categoria_habilitada;

    protected $listeners = ['delete'];

    public function mount($id = null)
    {
        if (!is_null($id)) {
            $this->post_edit_id = $id;
            $this->recorridos = recorrido::select('id', 'nombre')->whereBetween('id', [1, 2])->get();
            $this->mesas = mesa::select('id', 'nombre')->where('estado',true)->get();
            $this->grupos = grupo::select('id', 'nombre')->where('estado',true)->get();
            $this->categoria_habilitada = categoriaHabilitada::select('id', 'nombre')->get();


            // Obtener la inscripción y sus detalles relacionados
            $this->post = inscripcion::select('inscripcions.*', 'numeros.id as id_numero','eventos.nombre as evento_nombre', 'participantes.cedula as participante_cedula', 'tipo_pagos.nombre as metodo', 'grupos.id as grupo_id', 'grupos.precio as grupo_precio', 'mesas.id as mesa_id', 'recorridos.id as recorrido_id', 'categoria_habilitadas.id as id_category', 'dolars.precio as precio')
                ->join('eventos', 'inscripcions.evento_id', '=', 'eventos.id')
                ->join('participantes', 'inscripcions.participante_id', '=', 'participantes.id')
                ->join('metodo_pagos', 'inscripcions.metodo_pago_id', '=', 'metodo_pagos.id')
                ->join('grupos', 'inscripcions.grupo_id', '=', 'grupos.id')
                ->join('mesas', 'inscripcions.mesa_id', '=', 'mesas.id')
                ->join('recorridos', 'inscripcions.recorrido_id', '=', 'recorridos.id')
                ->join('categoria_habilitadas', 'inscripcions.categoria_habilitada_id', '=', 'categoria_habilitadas.id')
                ->join('tipo_pagos', 'metodo_pagos.tipo_pago_id', '=', 'tipo_pagos.id')
                ->join('dolars', 'inscripcions.dolar_id', '=', 'dolars.id')
                ->join('numeros','inscripcions.numero_id','=','numeros.id')->find($this->post_edit_id);

            // Rellenar los detalles de la inscripción
            $this->post_update["evento_id"] = $this->post->evento_nombre;
            $this->post_update["participante_id"] = $this->post->participante_cedula;
            $this->post_update["metodo_pago_id"] = $this->post->metodo;
            $this->post_update["grupo_id"] = $this->post->grupo_id;
            $this->post_update["grupo_precio"] = $this->post->grupo_precio;
            $this->post_update["dolar_id"] = $this->post->precio;
            $this->post_update["numero_id"] = $this->post->id_numero;
            $this->post_update["numero"] = $this->post->id_numero;

            $this->post_update["categoria_habilitada_id"] = $this->post->id_category;
            $this->post_update["mesa_id"] = $this->post->mesa_id;
            $this->post_update["datos"] = json_decode($this->post->datos, true);
            $this->post_update["monto_pagado_bs"] = $this->post->monto_pagado_bs;
            $this->post_update["ip"] = $this->post->ip;
            $this->post_update["nomenclatura"] = $this->post->nomenclatura;
            $this->post_update["recorrido_id"] = $this->post->recorrido_id;
            $this->post_update["created_at"] = \Carbon\Carbon::parse($this->post->created_at)->format('Y-m-d');

            // Obtener el último dígito de la cédula del participante
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
    }

    public function render()
    {
        return view('livewire.vista-inscripcion', [
            'numeros' => $this->numeros,
        ]);
    }
}
