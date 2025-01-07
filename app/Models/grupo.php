<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\recorrido;
use App\Models\inscripcion;
use Illuminate\Database\Eloquent\SoftDeletes;

class grupo extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'recorrido_id',
        'nombre',
        'precio',
        'cantidad',
        'estado'
    ];

    protected $table = 'grupos';

    public function recorrido()
    {
        return $this->belongsTo(recorrido::class, 'recorrido_id', 'id');
    }

    public function inscripcion()
    {
        return $this->belongsToMany(inscripcion::class);
    }
}
