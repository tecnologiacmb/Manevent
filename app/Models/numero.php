<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\inscripcion;
use Illuminate\Database\Eloquent\SoftDeletes;


class numero extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'numero',
        'estado',
        'disponible',

    ];

    public function inscripcion(){
        return $this->hasOne(inscripcion::class);
    }
}
