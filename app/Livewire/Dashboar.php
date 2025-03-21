<?php

namespace App\Livewire;

use App\Models\dolar;
use App\Models\inscripcion;
use App\Models\prenda;
use Carbon\Carbon;
use Livewire\Component;

class Dashboar extends Component
{
    public $totalMontoPagado;
    public $ParticipanteEvento;
    public $EventoCarrera;
    public $EventoCaminata;
    public $Franelas_S;
    public $Franelas_M;
    public $Franelas_L;
    public $Franelas_XL;

    public $dolars;
    public $total;
    public $porcentaje;
    public $PorcentajeCarrera;
    public $PorcentajeCaminata;
    public $PorcentaFranelas_S;
    public $PorcentaFranelas_M;
    public $PorcentaFranelas_L;
    public $PorcentaFranelas_XL;


    public $totalCarrera = 500;
    public $totalCaminata = 298;

    public $totalParticipantes = 999;

    public function mount()
    {
        $this->calcularTotalMontoPagado();
        $this->calcularParticipanteEvento();
        $this->calcularEventoCarrera();
        $this->calcularEventoCaminata();
        $this->calcularFranelas();



        $this->dolars = dolar::select('id', 'precio')->whereDate('created_at', Carbon::today())->latest()->first();
        if (!$this->dolars) {
            $this->dolars = dolar::latest()->first();
        }
    }

    public function calcularTotalMontoPagado()
    {
        $this->totalMontoPagado = inscripcion::join('eventos', 'inscripcions.evento_id', '=', 'eventos.id')->where('eventos.estado', true)->sum('monto_pagado_bs');
    }
    public function calcularParticipanteEvento()
    {
        $this->ParticipanteEvento = inscripcion::join('eventos', 'inscripcions.evento_id', '=', 'eventos.id')->where('eventos.estado', true)->count('participante_id');
        $this->porcentaje = round(($this->ParticipanteEvento / $this->totalParticipantes) * 100, 3);
    }
    public function calcularEventoCarrera()
    {
        $this->EventoCarrera = inscripcion::join('eventos', 'inscripcions.evento_id', '=', 'eventos.id')->where('eventos.estado', true)->where('inscripcions.recorrido_id', 2)->count('participante_id');
        $this->PorcentajeCarrera = round(($this->EventoCarrera / $this->totalCarrera) * 100, 3);
    }
    public function calcularEventoCaminata()
    {
        $this->EventoCaminata = inscripcion::join('eventos', 'inscripcions.evento_id', '=', 'eventos.id')->where('eventos.estado', true)->where('inscripcions.recorrido_id', 1)->count('participante_id');
        $this->PorcentajeCaminata = round(($this->EventoCaminata / $this->totalCaminata) * 100, 3);
    }
    public function calcularFranelas()
    {
        $this->Franelas_S = prenda::join('eventos', 'prendas.evento_id', '=', 'eventos.id')->where('eventos.estado', true)->where('prendas.prenda_category_id', 1)->where('prendas.prenda_talla_id', 1)->sum('restadas');

        $this->Franelas_M = prenda::join('eventos', 'prendas.evento_id', '=', 'eventos.id')->where('eventos.estado', true)->where('prendas.prenda_category_id', 1)->where('prendas.prenda_talla_id', 2)->sum('restadas');

        $this->Franelas_L = prenda::join('eventos', 'prendas.evento_id', '=', 'eventos.id')->where('eventos.estado', true)->where('prendas.prenda_category_id', 1)->where('prendas.prenda_talla_id', 3)->sum('restadas');

        $this->Franelas_XL = prenda::join('eventos', 'prendas.evento_id', '=', 'eventos.id')->where('eventos.estado', true)->where('prendas.prenda_category_id', 1)->where('prendas.prenda_talla_id', 4)->sum('restadas');

    }
    public function calculo($num)
    {
        $this->total = 0;


        $this->total = $this->totalMontoPagado / $ultimoDolar->precio;

        return $this->total;
    }

    public function render()
    {
        return view('livewire.dashboar');
    }
}
