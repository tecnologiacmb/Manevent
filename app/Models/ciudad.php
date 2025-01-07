<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\estado;
use App\Models\participante;
use Illuminate\Database\Eloquent\SoftDeletes;

class ciudad extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable=[
        'estado_id',
        'ciudad',

    ];

    public function estado(){
        return $this->hasOne(estado::class);
    }

    public function participante(){
        return $this->belongsTo(participante::class);
    }
}
