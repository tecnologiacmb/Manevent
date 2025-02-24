<?php

namespace App\Livewire;

use App\Models\inscripcion;
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
    protected $listeners = ['delete'];

    public function mount($id = null)
    {
        if (!is_null($id)) {
            $this->post_edit_id = $id;
            /* $post = inscripcion::select('inscripcions.*', 'eventos.nombre as evento_nombre','participantes.cedula as participante_cedula','tipo_pagos.nombre as tipo_pago','grupos.nombre as grupo_nombre','numeros.numero')->join('participantes','participantes.id','=','inscripcions.participante_id')->join('eventos', 'eventos.id', '=','inscripcions.evento_id')->join('metodo_pagos','metodo_pagos.tipo_pago_id','=','inscripcions.metodo_pago_id')->join('grupos', 'grupos.id', '=', 'inscripcions.grupo_id')->join('numeros','numeros.id', '=','inscripcions.numero_id')->join('tipo_pagos','tipo_pagos.id','=','metodo_pagos.tipo_pago_id')->find($this->post_edit_id); */
            $post = inscripcion::select('inscripcions.*', 'eventos.nombre as evento_nombre', 'participantes.cedula as participante_cedula','tipo_pagos.nombre as metodo','grupos.nombre as grupo_nombre','grupos.precio as grupo_precio','mesas.nombre as mesa_nombre','recorridos.nombre as recorrido_nombre','categoria_habilitadas.nombre as nombre_category','dolars.precio as precio',)->join('eventos', 'inscripcions.evento_id', '=', 'eventos.id')->join('participantes', 'inscripcions.participante_id', '=', 'participantes.id')->join('metodo_pagos', 'inscripcions.metodo_pago_id', '=', 'metodo_pagos.id')->join('grupos','inscripcions.grupo_id','=','grupos.id')->join('mesas','inscripcions.mesa_id','=','mesas.id')->join('recorridos','inscripcions.recorrido_id','=','recorridos.id')->join('categoria_habilitadas','inscripcions.categoria_habilitada_id','=','categoria_habilitadas.id')->join('tipo_pagos','metodo_pagos.tipo_pago_id','=','tipo_pagos.id')->join('dolars','inscripcions.dolar_id','=','dolars.id')->find($this->post_edit_id);

            $this->post_update["evento_id"] = $post->evento_nombre;
            $this->post_update["participante_id"] = $post->participante_cedula;
            $this->post_update["metodo_pago_id"] = $post->metodo;
            $this->post_update["grupo_id"] = $post->grupo_nombre;
            $this->post_update["grupo_precio"] = $post->grupo_precio;

            $this->post_update["dolar_id"] = $post->precio;
            $this->post_update["numero_id"] = $post->numero_id;
            if (is_null($this->post_update["categoria_habilitada_id"])) {
                $this->post_update["categoria_habilitada_id"] = $post->nombre_category;
            } else {
                $this->post_update["categoria_habilitada_id"] = $post->nombre_category;
            }
            $this->post_update["mesa_id"] = $post->mesa_nombre;
            $this->post_update["datos"] = json_decode($post->datos, true);
            $this->post_update["monto_pagado_bs"] = $post->monto_pagado_bs;
            $this->post_update["ip"] = $post->ip;
            $this->post_update["nomenclatura"] = $post->nomenclatura;
            $this->post_update["recorrido_id"] = $post->recorrido_nombre;
            $this->post_update["created_at"] = \Carbon\Carbon::parse($post->created_at)->format('Y-m-d');
        }
    }
    public function render()
    {
        return view('livewire.vista-inscripcion');
    }
}
