<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tipo_pago;
use App\Models\banco;
use App\Models\inscripcion;

class metodo_pago extends Model
{
    use HasFactory;
    protected $fillable = [
        'tipo_pago_id',
        'banco_id',
        'n°_cuenta',
        'cedula',
        'telefono',
        'propietario',
        'ABA',
        'SWIT',
        'correo',
        'status'
    ];

    public function tipo_pago()
    {
        return $this->hasOne(tipo_pago::class);
    }
    public function bancos()
    {
        return $this->hasMany(banco::class);
    }

    public function inscripcion(){
        return $this->belongsToMany(inscripcion::class);
    }
}