<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\inscripcion;
class mesa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'estado'
    ];

    public function inscripcion(){
        return $this->belongsTo(inscripcion::class);
    }
}
