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

    Route::post('alumno/saldo','Bares\PaymentController@saldo');
    Route::get('alumno/imagen/{id}','Institucion\AlumnoController@imagen');

    Route::post('bares/cobrar','Bares\PaymentController@cobrar');
    Route::post('bares/recargar','Bares\PaymentController@recargar');
    Route::get('bares/forma_pago','Bares\PaymentController@forma_pago');
    Route::get('bares/transacciones','Bares\PaymentController@transacciones');
    Route::get('bares/transacciones/hoy','Bares\PaymentController@transacciones_hoy');
});