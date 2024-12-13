<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\grupo;

class recorrido extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'status',

    ];
    protected $table = 'recorridos';

    public function grupos()
    {
        return $this->hasMany(grupo::class, 'id_recorrido', 'id');
    }
}
