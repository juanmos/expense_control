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

Route::post('login', ['as'=>'login','uses'=>'APIAuthController@login']);
Route::post('usuario', 'APIAuthController@nuevoUsuario')->name('usuario.nuevo');

Route::post('password/email','Auth\ForgotPasswordController@sendResetLinkEmail');
Route::post('register','Auth\RegisterController@register');

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::get('/usuario', 'APIAuthController@me');//Obtener los datos del usuario en sesion
    Route::delete('usuario/{plataforma}', 'APIAuthController@logout');//Cerrar sesion del usuario actual
    Route::post('usuario/registroPush', 'APIAuthController@registroPush');//Cerrar sesion del usuario actual

    Route::post('register/institucion','HomeController@registerInstitucion');
    

    
    Route::group(['prefix' => 'institucion'], function () {
        Route::get('alumnos/{id}', 'Institucion\AlumnoController@alumnosData')->name('institucion.alumnos');
        Route::get('alumno/datos_facturacion/{id}', 'Institucion\AlumnoController@datosFacturacion');
        Route::post('alumno/store', 'Institucion\AlumnoController@store');
        Route::put('alumno/update/{id}', 'Institucion\AlumnoController@update');

        Route::get('refrigerio', 'Institucion\RefrigerioController@refrigeriosData')->name('institucion.refrigerio.data');


        Route::get('alumno/transacciones/{id}', 'Institucion\AlumnoController@transacciones');
        
        Route::get('alumno/refrigerios/{id}', 'Institucion\RefrigerioController@refrigerios');
        Route::post('alumno/refrigerio/store', 'Institucion\RefrigerioController@store');
        Route::put('alumno/refrigerio/update/{id}', 'Institucion\RefrigerioController@update');
        Route::delete('alumno/refrigerio/destroy/{id}', 'Institucion\RefrigerioController@destroy');
        Route::get('alumno/refrigerios/historial/{id}', 'Institucion\RefrigerioController@historialPagos');
        Route::post('/pagar/refrigerio', 'Transacciones\PaymentController@refrigerio');
        Route::post('facturar/refrigerio', 'Institucion\FacturacionController@store');

        Route::get('alumno/imagen/{id}', 'Institucion\AlumnoController@imagen');
        
        Route::get('alumno/tarjetas/{id}', 'Institucion\AlumnoController@tarjetas');
        Route::get('alumno/tarjeta/{id}', 'Institucion\TarjetaController@imagen');
        Route::put('alumno/tarjeta/perdida/{id}', 'Institucion\TarjetaController@perdida');
        Route::post('alumno/tarjeta/store/{id}', 'Institucion\TarjetaController@store');

        Route::post('menu/{institucion_id}/{id}', 'Institucion\MenuController@menus');
        Route::post('menu/{institucion_id}', 'Institucion\MenuController@store');
        Route::put('menu/{institucion_id}/{id}', 'Institucion\MenuController@update');
    });
    
    
    
    
    Route::group(['prefix' => 'payment'], function () {
        Route::post('alumno/saldo/{completo?}', 'Transacciones\PaymentController@saldo');
        Route::post('valida/tarjeta', 'Transacciones\PaymentController@validaTarjeta');
        Route::post('cobrar', 'Transacciones\PaymentController@cobrar');
        Route::post('recargar', 'Transacciones\PaymentController@recargar');
        Route::get('forma_pago', 'Transacciones\PaymentController@forma_pago');
        Route::get('transacciones', 'Transacciones\PaymentController@transacciones');
        Route::get('transacciones/hoy', 'Transacciones\PaymentController@transaccionesHoy');
    });

    Route::group(['prefix' => 'naturales'], function () {
        Route::get('dashboard','Naturales\InstitucionController@dashboard');
        Route::get('dashboard/grafico/ventas-compras','Naturales\InstitucionController@graficoComprasVentas');
        Route::get('dashboard/grafico/gastos','Naturales\InstitucionController@graficoGastos');
        Route::get('dashboard/grafico/top/ventas','Naturales\InstitucionController@topVentas');
        Route::get('dashboard/grafico/top/compras','Naturales\InstitucionController@topCompras');

        Route::get('clientes/', 'Naturales\ClienteController@index');
        Route::post('cliente/by/cedula', 'Naturales\ClienteController@findCedula');
        Route::post('cliente/buscar', 'Naturales\ClienteController@buscar');
        Route::post('clientes/store', 'Naturales\ClienteController@store');
        Route::put('clientes/update/{id}', 'Naturales\ClienteController@update');

        Route::post('compras', 'Naturales\ComprasController@comprasData');
        Route::get('compras/pdf/{pdf}/{id}', 'Naturales\ComprasController@pdf');
        Route::put('compras/update/{id}','Naturales\ComprasController@update');
        Route::get('compras/cliente/{id}','Naturales\ComprasController@comprasCliente');
        Route::get('compras/actualizar/sri','Naturales\ComprasController@actualziarSRI');

        Route::post('facturas', 'Naturales\FacturacionController@facturasData');
        Route::post('facturar/store/{id}','Naturales\FacturacionController@store');
        Route::get('facturas/cliente/{id}','Naturales\FacturacionController@ventasCliente');
        Route::get('factura/pdf/{pdf}/{factura_id}', 'Institucion\FacturacionController@pdf');
        Route::put('factura/anular/{id}/{factura_id}', 'Institucion\FacturacionController@anular');

        Route::get('categorias/{tipo}', 'Naturales\CategoriaController@categoriaData');
        Route::post('categorias/store/{tipo}', 'Naturales\CategoriaController@store');
        Route::put('categorias/update/{tipo}/{id}', 'Naturales\CategoriaController@update');
        Route::delete('categorias/destroy/{tipo}/{id}', 'Naturales\CategoriaController@destroy');

        Route::put('configuracion/sri/{id}', 'Institucion\InstitucionController@configuracionUpdate');

        Route::put('perfil/editar/{id}','Naturales\UsuarioController@update');

        Route::post('documentos/{tipo}','Naturales\DocumentoFisicoController@index');
        Route::post('documentos/{tipo}/store','Naturales\DocumentoFisicoController@store');
        Route::delete('documento/eliminar/compra/{documento}','Naturales\DocumentoFisicoController@destroy');
    });
});
