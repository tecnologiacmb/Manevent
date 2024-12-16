<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categoriaHabilitada extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'edad_min',
        'edad_max',
    ];
}
