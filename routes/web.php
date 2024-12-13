<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/banco', function () {
        return view('banco');
    })->name('banco');

    Route::get('/metodo-pago', function () {
        return view('metodo-pago');
    })->name('metodo-pago');

    Route::get('/grupo', function () {
        return view('grupo');
    })->name('grupo');

    Route::get('/categoria', function () {
        return view('categoria');
    })->name('categoria');

    Route::get('/caminata', function () {
        return view('caminata');
    })->name('caminata');

    Route::get('/carrera', function () {
        return view('carrera');
    })->name('carrera');

    Route::get('/tasaDolar', function () {
        return view('tasaDolar');
    })->name('tasaDolar');

    Route::get('/franelas', function () {
        return view('franelas');
    })->name('franelas');

    Route::get('/evento', function () {
        return view('evento');
    })->name('evento');

    Route::get('/caminata-inscripcion', function () {
        return view('caminata-inscripcion');
    })->name('caminata-inscripcion');
});