<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login',['as'=>'login','uses'=>'APIAuthController@login']);
Route::post('usuario','APIAuthController@nuevoUsuario')->name('usuario.nuevo');

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::get('/usuario', 'APIAuthController@me');//Obtener los datos del usuario en sesion
    Route::delete('usuario/{plataforma}', 'APIAuthController@logout');//Cerrar sesion del usuario actual
    Route::post('usuario/registroPush', 'APIAuthController@registroPush');//Cerrar sesion del usuario actual

    
    Route::get('alumno/imagen/{id}','Institucion\AlumnoController@imagen');

    
    Route::group(['prefix' => 'institucion'], function() {
        Route::get('alumnos/{id}','Institucion\AlumnoController@alumnosData')->name('institucion.alumnos');

        Route::get('refrigerio','Institucion\RefrigerioController@refrigeriosData')->name('institucion.refrigerio.data');


        Route::get('alumno/transacciones/{id}','Institucion\AlumnoController@transacciones');
        Route::get('alumno/tarjetas/{id}','Institucion\AlumnoController@tarjetas');
        Route::get('alumno/refrigerios/{id}','Institucion\RefrigerioController@refrigerios');
    });
    
    
    
    
    Route::group(['prefix' => 'payment'], function() {
        Route::post('alumno/saldo/{completo?}','Transacciones\PaymentController@saldo');
        Route::post('valida/tarjeta','Transacciones\PaymentController@validaTarjeta');
        Route::post('cobrar','Transacciones\PaymentController@cobrar');
        Route::post('recargar','Transacciones\PaymentController@recargar');
        Route::get('forma_pago','Transacciones\PaymentController@forma_pago');
        Route::get('transacciones','Transacciones\PaymentController@transacciones');
        Route::get('transacciones/hoy','Transacciones\PaymentController@transacciones_hoy');
    });
    
    
});