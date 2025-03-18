<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\prenda_category;
use App\Models\prenda_talla;
use App\Models\evento;
use Illuminate\Database\Eloquent\SoftDeletes;

class prenda extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'evento_id',
        'prenda_category_id',
        'prenda_talla_id',
        'cantidad',
        'restadas',
        'sexo',
        'estado',
    ];

    public function prenda_category()
    {
        return $this->belongsTo(prenda_category::class);
    }
    public function prenda_talla()
    {
        return $this->belongsTo(prenda_talla::class);
    }
    public function eventos()
    {
        return $this->hasMany(evento::class);
    }
}
