<?php

use App\Http\Controllers\Caminata_controller;
use App\Http\Controllers\Carrera_controller;
use App\Http\Controllers\Mixto_controller;
use App\Http\Controllers\Categoria_Controller;
use App\Http\Controllers\ExportPDF;
use App\Http\Controllers\Grupo_Controller;
use App\Http\Controllers\Inscrippcion_Controller;
use App\Http\Controllers\Metodo_pago_Controller;
use App\Http\Controllers\Registro_Usuario;
use App\Http\Controllers\Usuarios_Controller;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/tasaDolar', function () {
        return view('tasaDolar');
    })->name('tasaDolar');

    Route::get('/franelas', function () {
        return view('franelas');
    })->name('franelas');

    Route::get('/evento', function () {
        return view('evento');
    })->name('evento');
    Route::get('/banco', function () {
        return view('banco');
    })->name('banco');


    Route::controller(ExportPDF::class)->group(function () {
        Route::group(['prefix' => 'reportes/reporte_fondo'], function () {
            Route::get('', 'index')->name('reporte_fondo');
            Route::get('/detalle/', 'reportPDF')->name('reportes.ReporteFondoPDF.detalle');
            Route::get('/Excel/', 'reportExcel')->name('reportes.ReporteExcel.Excel');
            Route::get('/ExcelGlobal/', 'reportGlobalExcel')->name('reportes.ReporteGlobalExcel.ExcelGlobal');
            Route::get('/reporte_global', 'reportGlobalPDF')->name('reportes.ReporteGlobalPDF.reporte_global');
        });
    });
    Route::controller(Registro_Usuario::class)->group(function () {
        Route::group(['prefix' => 'registro_usuario',], function () {
            Route::get('',  "index")->name('registro_usuario');
        });
    });
    Route::controller(Usuarios_Controller::class)->group(function () {
        Route::group(['prefix' => 'vista_usuarios',], function () {
            Route::get('',  "index")->name('vista_usuarios');
            Route::get('/detalle/{id}',  "create")->name('vista_usuarios/detalle/{id}');
        });
    });
    Route::controller(Inscrippcion_Controller::class)->group(function () {
        Route::group(['prefix' => 'incripcion',], function () {
            Route::get('',  "index")->name('incripcion');
            Route::get('/vista_inscripcion/{id}',  "create")->name('incripcion/vista_inscripcion/{id}');
        });
    });
    Route::controller(Categoria_Controller::class)->group(function () {
        Route::group(['prefix' => 'categoria',], function () {
            Route::get('',  "index")->name('categoria');
        });
    });
    Route::controller(Metodo_pago_Controller::class)->group(function () {
        Route::group(['prefix' => 'metodo-pago',], function () {
            Route::get('',  "index")->name('metodo-pago');
        });
    });
    Route::controller(Grupo_Controller::class)->group(function () {
        Route::group(['prefix' => 'grupo',], function () {
            Route::get('',  "index")->name('grupo');
        });
    });

    Route::controller(Caminata_controller::class)->group(function () {
        Route::group(['prefix' => 'caminata',], function () {
            Route::get('',  "index")->name('caminata');
            Route::get('/inscripcion/{id}',  "create")->name('caminata/inscripcion/{id}');
            Route::get('/editar/{id}', "edit")->name('inmobiliaria/editar/{id}');
        });
    });
    Route::controller(Carrera_controller::class)->group(function () {
        Route::group(['prefix' => 'carrera',], function () {
            Route::get('',  "index")->name('carrera');
            Route::get('/inscripcion/{id}',  "create")->name('carrera/inscripcion/{id}');
            Route::get('/editar/{id}', "edit")->name('inmobiliaria/editar/{id}');
        });
    });
    Route::controller(Mixto_controller::class)->group(function () {
        Route::group(['prefix' => 'mixto',], function () {
            Route::get('',  "index")->name('mixto');
            Route::get('/inscripcion/{id}/{cantidad_carrera}/{cantidad_caminata}',  "create")->name('mixto/inscripcion/{id}/{cantidad_carrera}/{cantidad_caminata}');
        });
    });
});
