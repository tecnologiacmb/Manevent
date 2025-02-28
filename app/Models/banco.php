<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\metodo_pago;
use Illuminate\Database\Eloquent\SoftDeletes;

class banco extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'nombre',
        'codigo',
        'estado'
    ];

    public function metodo_pago()
    {
        return $this->hasMany(metodo_pago::class);
    }
}
