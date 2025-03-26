<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class genero extends Model
{
    use HasFactory;

    protected $fillable = [
        'genero',
        'estado'
    ];

    protected $table = 'generos';

    public function participante()
    {
        return $this->hasMany(inscripcion::class);
    }
}
