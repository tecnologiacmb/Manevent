<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\recorrido;
use App\Models\inscripcion;


class grupo extends Model
{
    use HasFactory;

    protected $fillable = [
        'recorrido_id',
        'name',
        'costo',
        'valor',
        'status'
    ];

    protected $table = 'grupos';

    public function recorrido()
    {
        return $this->belongsTo(recorrido::class, 'recorrido_id', 'id');
    }

    public function inscripcion(){
        return $this->belongsToMany(inscripcion::class);
    }
}
