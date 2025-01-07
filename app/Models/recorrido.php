<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\grupo;
use Illuminate\Database\Eloquent\SoftDeletes;

class recorrido extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'estado',

    ];
    protected $table = 'recorridos';

    public function grupos()
    {
        return $this->hasMany(grupo::class, 'id_recorrido', 'id');
    }
}
