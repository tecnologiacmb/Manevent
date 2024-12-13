<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\inscripcion;
class dolar extends Model
{
    use HasFactory;
    protected $fillable=[
        'valor',

    ];

    public function inscripcion(){
        return $this->belongsToMany(inscripcion::class);
    }
}
