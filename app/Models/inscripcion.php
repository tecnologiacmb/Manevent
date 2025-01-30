<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\evento;
use App\Models\participante;
use App\Models\metodo_pago;
use App\Models\grupo;
use App\Models\dolar;
use App\Models\numero;
use App\Models\mesa;
use App\Models\categoriaHabilitada;
use Illuminate\Database\Eloquent\SoftDeletes;

class inscripcion extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable=[

        'evento_id',
        'participante_id',
        'metodo_pago_id',
        'grupo_id',
        'dolar_id',
        'numero_id',
        'categoria_habilitada_id',
        'mesa_id',
        'datos',
        'monto_pagado_bs',
        'ip',
        'nomenclatura',
        'recorrido_id',


    ];

    public function evento(){
        return $this->hasOne(evento::class);
    }

    public function participante(){
        return $this->hasOne(participante::class);
    }
    public function categoriaHabilitada(){
        return $this->hasOne(categoriaHabilitada::class);
    }

    public function grupo(){
        return $this->hasOne(grupo::class);
    }

    public function metodo_pagos(){
        return $this->hasMany(metodo_pago::class);
    }
    public function dolar(){
        return $this->hasOne(dolar::class);
    }

    public function numero(){
        return $this->hasOne(numero::class);
    }

    public function mesa(){
        return $this->hasMany(mesa::class);
    }


}
