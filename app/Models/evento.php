<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\prenda;
use App\Models\inscripcion;
use Illuminate\Database\Eloquent\SoftDeletes;

class evento extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [

        'nombre',
        'fecha_inicio',
        'fecha_finalizacion',
        'lugar_evento',
        'fecha_evento',
        'estado',
    ];

    public function prendas()
    {
        return $this->belongsToMany(prenda::class);
    }

    public function inscripcion()
    {
        return $this->belongsToMany(inscripcion::class);
    }
}
