<?php

namespace App\Livewire;

use App\Models\dolar;
use App\Models\inscripcion;
use App\Models\participante;
use App\Models\prenda;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Dashboar extends Component
{
    public $totalMontoPagado;
    public $ParticipanteEvento;
    public $ParticipanteHombre;
    public $ParticipanteMujer;
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
    public $PorcentajeHombre;
    public $PorcentajeMujer;

    public $totalCarrera = 500;
    public $totalCaminata = 298;

    public $totalParticipantes = 999;

    public function mount()
    {
        $this->calcularTotalMontoPagado();
        $this->calcularParticipanteEvento();
        $this->calcularParticipanteHombre();
        $this->calcularParticipanteMujer();
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
        $this->totalMontoPagado = inscripcion::select(
            DB::raw('count(inscripcions.nomenclatura) as cantidad'),
            'inscripcions.nomenclatura',
            DB::raw('MIN(inscripcions.monto_a_pagar_bs) as monto_pagado_bs'),
        )->join('eventos', 'inscripcions.evento_id', '=', 'eventos.id')->where('eventos.estado', true)->groupBy('inscripcions.nomenclatura')->get()->sum('monto_pagado_bs');
    }
    public function calcularParticipanteEvento()
    {
        $this->ParticipanteEvento = inscripcion::join('eventos', 'inscripcions.evento_id', '=', 'eventos.id')->where('eventos.estado', true)->count('participante_id');
        $this->porcentaje = round(($this->ParticipanteEvento / $this->totalParticipantes) * 100, 3);
    }
    public function calcularParticipanteHombre()
    {
        $this->ParticipanteHombre = inscripcion::join('participantes', 'inscripcions.participante_id', '=', 'participantes.id')->join('eventos', 'inscripcions.evento_id', '=', 'eventos.id')->where('eventos.estado', true)->where('participantes.genero_id', 1)->count('participante_id');
        $this->PorcentajeHombre = round(($this->ParticipanteHombre / $this->totalParticipantes) * 100, 3);
    }
    public function calcularParticipanteMujer()
    {
        $this->ParticipanteMujer = inscripcion::join('participantes', 'inscripcions.participante_id', '=', 'participantes.id')->join('eventos', 'inscripcions.evento_id', '=', 'eventos.id')->where('eventos.estado', true)->where('participantes.genero_id', 2)->count('participante_id');
        $this->PorcentajeMujer = round(($this->ParticipanteMujer / $this->totalParticipantes) * 100, 3);
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
        $this->Franelas_S = prenda::join('eventos', 'prendas.evento_id', '=', 'eventos.id')->where('eventos.estado', true)->where('prendas.prenda_category_id', 2)->where('prendas.prenda_talla_id', 2)->sum('restadas');
        if ($this->Franelas_S == 0) {

            $this->Franelas_S = prenda::join('eventos', 'prendas.evento_id', '=', 'eventos.id')->where('eventos.estado', true)->where('prendas.prenda_category_id', 2)->where('prendas.prenda_talla_id', 2)->sum('cantidad');
        }
        $this->Franelas_M = prenda::join('eventos', 'prendas.evento_id', '=', 'eventos.id')->where('eventos.estado', true)->where('prendas.prenda_category_id', 2)->where('prendas.prenda_talla_id', 3)->sum('restadas');

        if (is_null($this->Franelas_M)) {
            $this->Franelas_M = prenda::join('eventos', 'prendas.evento_id', '=', 'eventos.id')->where('eventos.estado', true)->where('prendas.prenda_category_id', 2)->where('prendas.prenda_talla_id', 3)->sum('cantidad');
        }
        $this->Franelas_L = prenda::join('eventos', 'prendas.evento_id', '=', 'eventos.id')->where('eventos.estado', true)->where('prendas.prenda_category_id', 2)->where('prendas.prenda_talla_id', 4)->sum('restadas');
        if ($this->Franelas_L == 0) {
            $this->Franelas_L = prenda::join('eventos', 'prendas.evento_id', '=', 'eventos.id')->where('eventos.estado', true)->where('prendas.prenda_category_id', 2)->where('prendas.prenda_talla_id', 4)->sum('cantidad');
        }
        $this->Franelas_XL = prenda::join('eventos', 'prendas.evento_id', '=', 'eventos.id')->where('eventos.estado', true)->where('prendas.prenda_category_id', 2)->where('prendas.prenda_talla_id', 5)->sum('restadas');
        if ($this->Franelas_XL == 0) {
            $this->Franelas_XL = prenda::join('eventos', 'prendas.evento_id', '=', 'eventos.id')->where('eventos.estado', true)->where('prendas.prenda_category_id', 2)->where('prendas.prenda_talla_id', 5)->sum('cantidad');
        }
    }
    public function calculo($totalMontoPagado)
    {
        if (isset($this->dolars)) {
            $ultimoDolar = $this->dolars->latest()->first();
            if (isset($ultimoDolar)) {
                $this->total = $totalMontoPagado / $ultimoDolar->precio;
                return $this->total;
            }
        } else {
            $this->total = 0;
            return $this->total;
        }
    }

    public function render()
    {
        return view('livewire.dashboar');
    }
}
