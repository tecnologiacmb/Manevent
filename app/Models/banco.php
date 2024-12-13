<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\metodo_pago;

class banco extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'codigo',
        'status'
    ];

    public function metodo_pago()
    {
        return $this->belongsTo(metodo_pago::class);
    }
}
