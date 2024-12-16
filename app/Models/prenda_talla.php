<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\prenda;

class prenda_talla extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'estado',

    ];
    public function prendas()
    {
        return $this->hasMany(prenda::class);
    }
}
