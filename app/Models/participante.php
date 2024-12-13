<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ciudad;
use App\Models\inscripcion;
class participante extends Model
{
    use HasFactory;
    protected $fillable = [
        'ciudad_id',
        'cedula',
        'nombre',
        'apellido',
        'telefono',
        'correo',
        'direccion',
        'fecha_nacimiento',
    ];

    public function ciudades(){
        return $this->hasMany(ciudad::class);
    }

    public function inscripcion(){
        return $this->belongsTo(inscripcion::class);
    }
}
