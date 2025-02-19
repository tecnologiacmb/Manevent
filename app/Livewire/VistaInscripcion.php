<?php

namespace App\Livewire;

use App\Models\inscripcion;
use Livewire\Component;

class VistaInscripcion extends Component
{
    public $post_edit_id;
    public $post_update = [
        'evento_id' => "",
        'participante_id' => "",
        'metodo_pago_id' => "",
        'grupo_id' => "",
        'dolar_id' => "",
        'numero_id' => "",
        'categoria_habilitada_id' => null,
        'mesa_id' => null,
        'datos' => [],
        'monto_pagado_bs' =>"",
        'ip' => null,
        'nomenclatura' => "",
        'recorrido_id' =>"",
        'created_at' =>""

    ];
    public $participantes = null;
    public $estados;
    public $ciudad;
    protected $listeners = ['delete'];

    public function mount($id = null)
    {
        if (!is_null($id)) {
            $this->post_edit_id = $id;
            $post = inscripcion::select('inscripcions.*', 'eventos.nombre as evento_nombre','participantes.cedula as participante_cedula','tipo_pagos.nombre as tipo_pago','grupos.nombre as grupo_nombre','numeros.numero')->join('participantes','participantes.id','=','inscripcions.participante_id')->join('eventos', 'eventos.id', '=','inscripcions.evento_id')->join('metodo_pagos','metodo_pagos.tipo_pago_id','=','inscripcions.metodo_pago_id')->join('grupos', 'grupos.id', '=', 'inscripcions.grupo_id')->join('numeros','numeros.id', '=','inscripcions.numero_id')->join('tipo_pagos','tipo_pagos.id','=','metodo_pagos.tipo_pago_id')->find($this->post_edit_id);
            $this->post_update["evento_id"] = $post->evento_nombre;
            $this->post_update["participante_id"] = $post->participante_cedula;
            $this->post_update["metodo_pago_id"] = $post->tipo_pago;
            $this->post_update["grupo_id"] = $post->grupo_nombre;
            $this->post_update["dolar_id"] = $post->dolar_id;
            $this->post_update["numero_id"] = $post->numero;
            if (is_null($this->post_update["categoria_habilitada_id"])) {
                $this->post_update["categoria_habilitada_id"] = "Sin categoria";
            }else{
            $this->post_update["categoria_habilitada_id"] = $post->categoria_habilitada_id;
            }
            $this->post_update["mesa_id"] = $post->mesa_id;
            $this->post_update["datos"] = json_decode($post->datos, true);
            $this->post_update["monto_pagado_bs"] = $post->monto_pagado_bs;
            $this->post_update["ip"] = $post->ip;
            $this->post_update["nomenclatura"] = $post->nomenclatura;
            $this->post_update["recorrido_id"] = $post->recorrido_id;
            $this->post_update["created_at"] = \Carbon\Carbon::parse($post->created_at)->format('Y-m-d');


        }
    }
    public function render()
    {
        return view('livewire.vista-inscripcion');
    }
}
