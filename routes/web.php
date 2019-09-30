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


Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['prefix' => 'admin'], function () {
        Route::resource('institucion','Admin\InstitucionController');
        
    });

    
    Route::group(['prefix' => 'institucion'], function() {
        Route::get('/{id}/alumnos','Institucion\AlumnoController@index')->name('alumnos.institucion');
        Route::get('/alumno/crear','Institucion\AlumnoController@create')->name('alumno.create');
        Route::get('/{id}/alumno/cargar','Institucion\AlumnoController@cargar')->name('alumno.cargar');
        Route::post('/alumno/import','Institucion\AlumnoController@import')->name('alumno.import');
        Route::get('/alumno/{id}','Institucion\AlumnoController@show')->name('alumno.show');
        Route::get('/alumno/codificar/{id}','Institucion\AlumnoController@codificar')->name('alumno.codificar');
    });
    
    
    
});