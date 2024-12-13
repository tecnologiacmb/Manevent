<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\inscripcion;

class numero extends Model
{
    use HasFactory;
    protected $fillable = [
        'numero',
        'estado',
        'disponible',

    ];

    public function inscripcion(){
        return $this->belongsTo(inscripcion::class);
    }
}
