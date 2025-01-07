<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\inscripcion;
use Illuminate\Database\Eloquent\SoftDeletes;

class dolar extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'precio',

    ];

    public function inscripcion()
    {
        return $this->belongsToMany(inscripcion::class);
    }
}
