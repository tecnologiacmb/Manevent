<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\inscripcion;
use Illuminate\Database\Eloquent\SoftDeletes;

class categoriaHabilitada extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'edad_min',
        'edad_max',
    ];

    public function inscripcion(){
        return $this->belongsTo(inscripcion::class);
    }
}
