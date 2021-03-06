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
Route::get('/', 'PublicController@index');
// Route::get('/', 'HomeController@index')->middleware('auth');
Auth::routes();
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('notificacion', function () {
    $user = App\Models\User::find(97);

    return $user->notify(new App\Notifications\NuevaRetencionNotification());
});



// Route::get('carga','Bares\PaymentController@carga');
Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('ayuda', 'AyudaController');

    Route::get('register/institucion', 'HomeController@register')->name('register.institucion');
    Route::post('register/institucion', 'HomeController@registerInstitucion')->name('register.institucion');

    Route::get('exportar/{id}', function ($id) {
        return (new \App\Exports\DocumentosMesExport($id, '2019-11-01', '2019-11-30'))->download('documentos.xlsx');
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::get('institucion', 'Admin\InstitucionController@index')->name('admin.institucion.index');
        Route::get('institucion/create', 'Admin\InstitucionController@create')->name('admin.institucion.create');
        Route::post('institucion/store', 'Admin\InstitucionController@store')->name('admin.institucion.store');
        Route::get('institucion/show/{id}/{pest?}', 'Admin\InstitucionController@show')->name('admin.institucion.show');
        Route::get('institucion/{institucion}/edit', 'Admin\InstitucionController@edit')->name('admin.institucion.edit');
        Route::put('institucion/{institucion}/update', 'Admin\InstitucionController@update')->name('admin.institucion.update');
    });

    
    Route::group(['prefix' => 'institucion'], function () {
        Route::resource('institucion', 'Institucion\InstitucionController');
        Route::resource('institucion.facturacion', 'Institucion\FacturacionController');
        Route::resource('institucion.menus', 'Institucion\MenuController');
        
        Route::get('/institucion/{id}/{pest?}', 'Institucion\InstitucionController@show')->name('institucion.show');
        Route::get('/{id}/alumnos', 'Institucion\AlumnoController@index')->name('institucion.alumnos');
        Route::get('/{id}/alumnos/data', 'Institucion\AlumnoController@alumnosData')->name('institucion.alumnos.data');
        Route::get('/{id}/alumno/crear', 'Institucion\AlumnoController@create')->name('institucion.alumno.create');
        Route::post('/alumno/store', 'Institucion\AlumnoController@store')->name('institucion.alumno.store');
        Route::get('/{id}/alumno/cargar', 'Institucion\AlumnoController@cargar')->name('institucion.alumno.cargar');
        Route::post('/alumno/import', 'Institucion\AlumnoController@import')->name('institucion.alumno.import');
        Route::get('/{id}/alumno/exportar', 'Institucion\AlumnoController@exportar')->name('institucion.alumno.exportar');
        Route::get('/{id}/alumno/{alumno_id}', 'Institucion\AlumnoController@show')->name('institucion.alumno.show');
        Route::get('/{id}/alumno/codificar/{alumno_id}', 'Institucion\AlumnoController@codificar')->name('institucion.alumno.codificar');
        Route::get('/{id}/alumno/edit/{alumno_id}', 'Institucion\AlumnoController@edit')->name('institucion.alumno.edit');
        Route::put('/alumno/update/{alumno_id}', 'Institucion\AlumnoController@update')->name('institucion.alumno.update');
        Route::get('/{id}/alumno/datos/factura/{alumno_id}', 'Institucion\AlumnoController@datosFacturacion')->name('institucion.alumno.datos.facturacion');

        Route::get('/alumno/{id}/tarjeta/crear', 'Institucion\TarjetaController@create')->name('institucion.alumno.tarjeta.create');
        Route::post('/alumno/{id}/tarjeta/store', 'Institucion\TarjetaController@store')->name('institucion.alumno.tarjeta.store');
        Route::post('/alumno/{id}/tarjeta/perdida', 'Institucion\TarjetaController@perdida')->name('institucion.alumno.tarjeta.perdida');
        Route::delete('/alumno/{id}/tarjeta/destroy', 'Institucion\TarjetaController@destroy')->name('institucion.alumno.tarjeta.eliminar');

        Route::get('usuario/', 'Institucion\UsuarioController@index')->name('institucion.usuario.index');
        Route::get('usuario/{id}', 'Institucion\UsuarioController@show')->name('institucion.usuario.show');
        Route::get('{id}/usuario/crear/', 'Institucion\UsuarioController@create')->name('institucion.usuario.crear');
        Route::post('/usuario/store/', 'Institucion\UsuarioController@store')->name('institucion.usuario.store');
        Route::get('{id}/usuario/editar/{usuario_id}', 'Institucion\UsuarioController@edit')->name('institucion.usuario.edit');
        Route::put('/usuario/{id}/update/', 'Institucion\UsuarioController@update')->name('institucion.usuario.update');
        Route::delete('usuario/{id}', 'Institucion\UsuarioController@destroy')->name('institucion.usuario.destroy');

        Route::get('refrigerio', 'Institucion\RefrigerioController@index')->name('institucion.refrigerio.index');
        Route::get('refrigerio/{id}', 'Institucion\RefrigerioController@show')->name('institucion.refrigerio.show');
        Route::get('refrigerios/data', 'Institucion\RefrigerioController@refrigeriosData')->name('institucion.refrigerio.data');
        Route::get('refrigerio/crear/{id}', 'Institucion\RefrigerioController@create')->name('institucion.refrigerio.crear');
        Route::post('refrigerio/store', 'Institucion\RefrigerioController@store')->name('institucion.refrigerio.store');
        Route::get('refrigerio/editar/{id}', 'Institucion\RefrigerioController@edit')->name('institucion.refrigerio.editar');
        Route::put('refrigerio/update/{id}', 'Institucion\RefrigerioController@update')->name('institucion.refrigerio.update');
        Route::delete('refrigerio/{id}', 'Institucion\RefrigerioController@destroy')->name('institucion.refrigerio.eliminar');
        Route::get('refrigerio/historial/pagos/{id}', 'Institucion\RefrigerioController@historialPagos')->name('institucion.refrigerio.historial');

        Route::get('refrigerios/tipos', 'Institucion\TipoRefrigerioController@index')->name('institucion.refrigerios.tipos.index');
        Route::get('refrigerios/tipos/crear', 'Institucion\TipoRefrigerioController@create')->name('institucion.refrigerios.tipos.crear');
        Route::post('refrigerios/tipos/store', 'Institucion\TipoRefrigerioController@store')->name('institucion.refrigerios.tipos.store');
        Route::get('refrigerios/tipos/editar/{id}', 'Institucion\TipoRefrigerioController@edit')->name('institucion.refrigerios.tipos.editar');
        Route::put('refrigerios/tipos/update/{id}', 'Institucion\TipoRefrigerioController@update')->name('institucion.refrigerios.tipos.update');
        Route::delete('refrigerios/tipos/{id}', 'Institucion\TipoRefrigerioController@destroy')->name('institucion.refrigerios.tipos.destroy');

        Route::get('{id}/factura/pdf/{factura_id}', 'Institucion\FacturacionController@pdf')->name('institucion.facturacion.pdf');
        Route::get('{id}/factura/xml/{factura_id}', 'Institucion\FacturacionController@xml')->name('institucion.facturacion.xml');
        Route::get('{id}/factura/email/{factura_id}', 'Institucion\FacturacionController@email')->name('institucion.facturacion.email');
        Route::put('{id}/factura/anular/{factura_id}', 'Institucion\FacturacionController@anular')->name('institucion.facturacion.anular');

        Route::post('/pagar/refrigerio', 'Transacciones\PaymentController@refrigerio')->name('institucion.refrigerio.pagar');

        Route::get('configuracion/editar', 'Institucion\InstitucionController@configuracion')->name('institucion.configuracion.edit');
        Route::put('configuracion/update/{id}', 'Institucion\InstitucionController@configuracionUpdate')->name('institucion.configuracion.update');

        Route::get('institucion/{id}/menus/menus/{tipo}', 'Institucion\MenuController@menus')->name('institucion.menus.menus');
    });
    
    
    Route::group(['prefix' => 'naturales'], function () {
        Route::resource('naturales', 'Naturales\InstitucionController');
        Route::get('/persona/{id}/{pest?}', 'Naturales\InstitucionController@show')->name('naturales.show');
        Route::get('configuracion/editar', 'Institucion\InstitucionController@configuracion')->name('naturales.configuracion.edit');
        Route::put('configuracion/update/{id}', 'Institucion\InstitucionController@configuracionUpdate')->name('naturales.configuracion.update');

        Route::resource('naturales.clientes', 'Naturales\ClienteController');
        Route::get('naturales/{institucion?}/cliente/data', 'Naturales\ClienteController@clientesData')->name('naturales.clientes.data');
        Route::get('naturales/{institucion}/clientes/upload', 'Naturales\ClienteController@upload')->name('naturales.clientes.upload');
        Route::get('naturales/{institucion}/clientes/id/{id}', 'Naturales\ClienteController@findById')->name('naturales.clientes.find.id');
        Route::get('naturales/clientes/search/ruc', 'Naturales\ClienteController@findCedula')->name('naturales.clientes.find.cedula');
        Route::get('naturales/clientes/search/texto', 'Naturales\ClienteController@buscar')->name('naturales.clientes.buscar');
        
        Route::resource('naturales.categoria', 'Naturales\CategoriaController');
        Route::get('naturales/{tipo}/categoria/data/tablas', 'Naturales\CategoriaController@categoriaData')->name('naturales.categoria.data');
        

        Route::resource('naturales.producto', 'Naturales\ProductoController');
        Route::resource('naturales.servicio', 'Naturales\ProductoController');

        Route::resource('naturales.compras', 'Naturales\ComprasController');
        Route::get('naturales/{institucion}/compras/data/table', 'Naturales\ComprasController@comprasData')->name('naturales.compras.data');
        Route::get('naturales/{institucion}/compras/pdf/{id}', 'Naturales\ComprasController@pdf')->name('naturales.compras.pdf');
        Route::get('compras/cliente/{id}', 'Naturales\ComprasController@comprasCliente')->name('naturales.compras.cliente');
        
        Route::resource('naturales.facturas', 'Naturales\FacturacionController');
        Route::get('naturales/{institucion}/facturas/data/table', 'Naturales\FacturacionController@facturasData')->name('naturales.facturas.data');
        Route::get('facturas/cliente/{id}', 'Naturales\FacturacionController@ventasCliente')->name('naturales.facturas.cliente');
        Route::get('facturas/importar', 'Naturales\FacturacionController@import')->name('naturales.facturas.importar');
        Route::post('facturas/importar', 'Naturales\FacturacionController@uploadXML')->name('naturales.facturas.importar');
        Route::post('facturas/reenviar/{factura}', 'Naturales\FacturacionController@reenviarMail')->name('naturales.facturas.reenviar');

        Route::resource('naturales.retenciones', 'Naturales\RetencionController');
        Route::get('naturales/{institucion}/retenciones/data/table', 'Naturales\RetencionController@retencionesData')->name('naturales.retenciones.data');

        Route::get('naturales/documentos/{tipo}', 'Naturales\DocumentoFisicoController@index')->name('naturales.documentos.index');
        Route::get('naturales/{institucion}/documento/{tipo}/create', 'Naturales\DocumentoFisicoController@create')->name('naturales.documentos.create');
        Route::post('naturales/{institucion}/documento/store', 'Naturales\DocumentoFisicoController@store')->name('naturales.documentos.store');
        Route::get('naturales/{institucion}/documento/{documento}', 'Naturales\DocumentoFisicoController@show')->name('naturales.documentos.show');
        Route::delete('naturales/documento/{documento}', 'Naturales\DocumentoFisicoController@destroy')->name('naturales.documentos.eliminar');
        Route::put('naturales/documento/{documento}/clasificar/', 'Naturales\DocumentoFisicoController@update')->name('naturales.documentos.update');

        Route::get('usuario/', 'Naturales\UsuarioController@index')->name('naturales.usuario.index');
        Route::get('usuario/{id}', 'Naturales\UsuarioController@show')->name('naturales.usuario.show');
        Route::get('{id}/usuario/crear/', 'Naturales\UsuarioController@create')->name('naturales.usuario.crear');
        Route::post('/usuario/store/', 'Naturales\UsuarioController@store')->name('naturales.usuario.store');
        Route::get('{id}/usuario/editar/{usuario_id}', 'Naturales\UsuarioController@edit')->name('naturales.usuario.edit');
        Route::put('/usuario/{id}/update/', 'Naturales\UsuarioController@update')->name('naturales.usuario.update');
        Route::delete('usuario/{id}', 'Naturales\UsuarioController@destroy')->name('naturales.usuario.destroy');

        Route::post('exportar', 'Naturales\InstitucionController@exportar')->name('naturales.documentos.exportar');
    });
});
