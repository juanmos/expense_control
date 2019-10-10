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
        
        
    });

    
    Route::group(['prefix' => 'institucion'], function() {
        Route::resource('institucion','Institucion\InstitucionController');
        Route::get('/institucion/{id}/{pest?}','Institucion\InstitucionController@show')->name('institucion.show');
        Route::get('/{id}/alumnos','Institucion\AlumnoController@index')->name('institucion.alumnos');
        Route::get('/{id}/alumnos/data','Institucion\AlumnoController@alumnosData')->name('institucion.alumnos.data');
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

        Route::get('usuario/','Institucion\UsuarioController@index')->name('institucion.usuario.index');
        Route::get('usuario/{id}','Institucion\UsuarioController@show')->name('institucion.usuario.show');
        Route::get('{id}/usuario/crear/','Institucion\UsuarioController@create')->name('institucion.usuario.crear');
        Route::post('/usuario/store/','Institucion\UsuarioController@store')->name('institucion.usuario.store');
        Route::get('{id}/usuario/editar/{usuario_id}','Institucion\UsuarioController@edit')->name('institucion.usuario.edit');
        Route::put('/usuario/{id}/update/','Institucion\UsuarioController@update')->name('institucion.usuario.update');
        Route::delete('usuario/{id}','Institucion\UsuarioController@destroy')->name('institucion.usuario.destroy');

        Route::get('refrigerio','Institucion\RefrigerioController@index')->name('institucion.refrigerio.index');
        Route::get('refrigerio/data','Institucion\RefrigerioController@refrigeriosData')->name('institucion.refrigerio.data');
        Route::get('refrigerio/crear/{id}','Institucion\RefrigerioController@create')->name('institucion.refrigerio.crear');
        Route::post('refrigerio/store','Institucion\RefrigerioController@store')->name('institucion.refrigerio.store');
        Route::get('refrigerio/editar/{id}','Institucion\RefrigerioController@edit')->name('institucion.refrigerio.editar');
        Route::put('refrigerio/update/{id}','Institucion\RefrigerioController@update')->name('institucion.refrigerio.update');
        Route::delete('refrigerio/{id}','Institucion\RefrigerioController@destroy')->name('institucion.refrigerio.destroy');

        Route::get('refrigerios/tipos','Institucion\TipoRefrigerioController@index')->name('institucion.refrigerios.tipos.index');
        Route::get('refrigerios/tipos/crear','Institucion\TipoRefrigerioController@create')->name('institucion.refrigerios.tipos.crear');
        Route::post('refrigerios/tipos/store','Institucion\TipoRefrigerioController@store')->name('institucion.refrigerios.tipos.store');
        Route::get('refrigerios/tipos/editar/{id}','Institucion\TipoRefrigerioController@edit')->name('institucion.refrigerios.tipos.editar');
        Route::put('refrigerios/tipos/update/{id}','Institucion\TipoRefrigerioController@update')->name('institucion.refrigerios.tipos.update');
        Route::delete('refrigerios/tipos/{id}','Institucion\TipoRefrigerioController@destroy')->name('institucion.refrigerios.tipos.destroy');
    });
    
    
    
});