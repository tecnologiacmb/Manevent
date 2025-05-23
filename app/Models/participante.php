<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ciudad;
use App\Models\inscripcion;
use Illuminate\Database\Eloquent\SoftDeletes;

class participante extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ciudad_id',
        'cedula',
        'nombre',
        'apellido',
        'telefono',
        'correo',
        'direccion',
        'fecha_nacimiento',
        'genero_id'
    ];

    public function ciudades(){
        return $this->hasMany(ciudad::class);
    }

    public function genero(){
        return $this->belongsTo(genero::class);
    }
    public function inscripcion(){
        return $this->hasOne(inscripcion::class);
    }
}
