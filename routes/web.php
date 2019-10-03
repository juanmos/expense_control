<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');
Auth::routes();
Route::get('logout','Auth\LoginController@logout')->name('logout');

Route::get('carga','Bares\PaymentController@carga');
Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['prefix' => 'admin'], function () {
        Route::resource('institucion','Admin\InstitucionController');
        
    });

    
    Route::group(['prefix' => 'institucion'], function() {
        Route::get('/{id}/alumnos','Institucion\AlumnoController@index')->name('institucion.alumnos');
        Route::get('/{id}/alumno/crear','Institucion\AlumnoController@create')->name('institucion.alumno.create');
        Route::post('/alumno/store','Institucion\AlumnoController@store')->name('institucion.alumno.store');
        Route::get('/{id}/alumno/cargar','Institucion\AlumnoController@cargar')->name('institucion.alumno.cargar');
        Route::post('/alumno/import','Institucion\AlumnoController@import')->name('institucion.alumno.import');
        Route::get('/{id}/alumno/exportar','Institucion\AlumnoController@exportar')->name('institucion.alumno.exportar');
        Route::get('/{id}/alumno/{alumno_id}','Institucion\AlumnoController@show')->name('institucion.alumno.show');
        Route::get('/{id}/alumno/codificar/{alumno_id}','Institucion\AlumnoController@codificar')->name('institucion.alumno.codificar');
        Route::get('/{id}/alumno/edit/{alumno_id}','Institucion\AlumnoController@edit')->name('institucion.alumno.edit');
        Route::put('/alumno/update/{alumno_id}','Institucion\AlumnoController@update')->name('institucion.alumno.update');

        Route::get('/alumno/{id}/tarjeta/crear','Institucion\TarjetaController@create')->name('institucion.alumno.tarjeta.create');
        Route::post('/alumno/{id}/tarjeta/store','Institucion\TarjetaController@store')->name('institucion.alumno.tarjeta.store');
        Route::post('/alumno/{id}/tarjeta/perdida','Institucion\TarjetaController@perdida')->name('institucion.alumno.tarjeta.perdida');
        Route::delete('/alumno/{id}/tarjeta/destroy','Institucion\TarjetaController@destroy')->name('institucion.alumno.tarjeta.eliminar');
    });
    
    
    
});