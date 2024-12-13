<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\prenda;
use App\Models\inscripcion;
class evento extends Model
{
    use HasFactory;

    protected $fillable=[

        'name',
        'inicio',
        'finalizacion',
        'lugar',
        'fecha_evento',
        'status',
    ];

    public function prendas(){
        return $this->belongsToMany(prenda::class);
    }

    public function inscripcion(){
        return $this->belongsToMany(inscripcion::class);
    }

}
