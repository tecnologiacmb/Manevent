<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ciudad;



class estado extends Model
{
    use HasFactory;
    protected $fillable=[
        'estado',
        'iso_3166-2',

    ];

    public function ciudad(){
        return $this->belongsTo(ciudad::class);
    }



}
