<?php


Route::get('/Instalador', 'InstaladorController@uno');
Route::post('/Instalador', 'InstaladorController@dos');
Route::post('/Instalador/finalizar', 'InstaladorController@tres');


Route::group(['middleware' => 'web'], function () {

    Route::get('/', function () {
        if (Auth::guest())
          return redirect('/login');
        else
          return view('index');
    });

    Route::get('/ufv', 'ParametrosController@insertarUFV');
    //Route::auth();
    Route::get('login', 'Auth\AuthController@showLoginForm');
    Route::post('login', 'Auth\AuthController@login');
    Route::get('logout', 'Auth\AuthController@logout');

    Route::resource('Almacenes', 'AlmacenesController');
    Route::resource('Automovil', 'AutoController');

    Route::resource('Cambios', 'CambiosController');
    Route::resource('Gestiones', 'GestionesController');
    Route::resource('Conceptos', 'ConceptosController');
    Route::resource('Estructuras', 'EstructurasController');
    Route::resource('Funcionarios', 'FuncionariosController');
    Route::resource('Clasificadores', 'ClasificadoresController');


    Route::get('Clasificadores/{id}/buscar', 'ClasificadoresController@buscar');
    Route::get('Clasificadores/ver/JSON/list', 'ClasificadoresController@ver');
    Route::get('Clasificadores/ver/JSON/list/{id}', 'ClasificadoresController@verSalida');

    Route::resource('ArticulosMovimientos', 'ArticulosMovimientosController');



    Route::resource('Aperturas', 'AperturasController');
    Route::get('Aperturas/{id}/buscar', 'AperturasController@buscar');
    Route::get('Aperturas/ver/JSON/list', 'AperturasController@ver');
    Route::get('Aperturas/ver/JSON/list/Salir', 'AperturasController@verSalida');

    Route::resource('Proveedores', 'ProveedoresController');
    Route::resource('Unidades', 'UnidadesController');
    Route::resource('Bienes', 'BienesController');
    Route::get('Bienes/buscar/{id}', 'BienesController@buscar');
    Route::get('Bienes/ver/JSON/list/{id}', 'BienesController@ver');
    Route::get('Bienes/ver/JSON/listStock/{id}', 'BienesController@verStock');
    Route::get('Bienes/apertura/lista/{id}', 'BienesController@catalogoApertura');
    Route::resource('Configuraciones', 'ConfiguracionesController');

    Route::get('CierreGestion/', 'CierreGestionController@index');
    Route::post('CierreGestion/create', 'CierreGestionController@create');
    Route::post('CierreGestion/', 'CierreGestionController@store');

    Route::get('CambiarGestion/', 'CierreGestionController@cambiarGet');
    Route::post('CambiarGestion/', 'CierreGestionController@cambiarPost');


    Route::get('Movimientos/{id}/edit', 'MovimientosController@editar');
    Route::put('Movimientos/{id}', 'MovimientosController@actualizar');

    Route::get('Movimientos/{id}/salir', 'MovimientosController@salir');
    Route::post('Movimientos/salir', 'MovimientosController@salirStore');
    Route::get('Movimientos/auxiliar', 'MovimientosController@auxiliar');

    Route::get('Movimientos/{id}', 'MovimientosController@show');
    Route::get('Movimientos', 'MovimientosController@index');
    Route::get('Movimientos/ver/Maximo/{id}', 'MovimientosController@ver');

    Route::get('Movimientos/{id}/articulo', 'MovimientosController@articulosShow');
    Route::get('Movimientos/{id}/fecha', 'MovimientosController@fecha');

    Route::get('Movimiento/salidaStock/{id}', 'MovimientosController@salidaStockNuevo');
    Route::post('Movimiento/salidaStock', 'MovimientosController@salidaStock');

    Route::post('Movimiento/salidaStockS', 'MovimientosController@salidaStockStore');
    Route::post('Movimiento/salidaCombustibleS', 'MovimientosController@salidaCombustibleStore')->name('salida.combustible');

    Route::get('Movimiento/confirmar/{id}', 'MovimientosController@confirmar');
    Route::get('Movimiento/eliminar/{id}', 'MovimientosController@eliminar');
    Route::post('Movimiento/eliminar/{id}', 'MovimientosController@eliminarStore');
    Route::get('Movimiento/nuevo', 'MovimientosController@nuevo');
    Route::post('Movimiento/create', 'MovimientosController@create');
    Route::post('Movimiento', 'MovimientosController@store');
    Route::get('Movimiento/create', function(){
    return redirect('Movimiento/nuevo');
    });

    ///Reportes
    //Route::get('Reportes/', 'ReportesController@index');
    //Route::post('Reportes/', 'ReportesController@store');

    Route::get('Reportes/deshuso', 'ReportesController@deshusoIndex');
    Route::get('Reportes/gestion', 'ReportesController@gestion');
    Route::post('Reportes/gestion', 'ReportesController@gestion');

    Route::get('Reportes/mostrar/{id}', 'ReportesController@show');
    Route::get('Reportes/apertura', 'ReportesController@aperturaIndex');
    Route::post('Reportes/apertura', 'ReportesController@apertura');

    Route::get('Reportes/combustible', 'ReportesController@combustibleIndex');
    Route::post('Reportes/combustible', 'ReportesController@combustible');

    Route::get('Reportes/clasificador', 'ReportesController@clasificadorIndex');
    Route::post('Reportes/clasificador', 'ReportesController@clasificador');

    Route::get('Reportes/estructura', 'ReportesController@estructuraIndex');
    Route::post('Reportes/estructura', 'ReportesController@estructura');

    Route::get('Reportes/automovil', 'ReportesController@automovilIndex');
    Route::post('Reportes/automovil', 'ReportesController@automovil');

    Route::get('Reportes/proveedor', 'ReportesController@proveedorIndex');
    Route::post('Reportes/proveedor', 'ReportesController@proveedor');

    Route::get('Reportes/catalogo', 'ReportesController@catalogoIndex');
    Route::post('Reportes/catalogo', 'ReportesController@catalogo');
    Route::get('Reporte/deshuso', 'ReportesController@deshuso');
    Route::get('Reportes/funcionario', 'ReportesController@funcionairoIndex');
    Route::post('Reportes/funcionario', 'ReportesController@funcionario');

    Route::get('Reportes/peps', 'ReportesController@pepsIndex');
    Route::post('Reportes/peps', 'ReportesController@peps');
    Route::get('Reportes/backup', 'ReportesController@backup');
    Route::get('Reportes/cierre/{id}', 'ReportesController@cierreGestion');

    Route::get('Reportes/estadisticas', function(){
      $datos=array();
      $dias=\App\Movimientos::where('dia','<=', date('d'))->groupBy('dia')->get();
      foreach ($dias as $dia) {
        $mv1 = \App\Movimientos::where('dia', '=', $dia->dia)
                              ->where('mes', '=', date('m'))
                              ->where('anio', '=', date('Y'))
                              ->where('cerrado_gestion', '=', 'NO')
                              ->where('movimiento', '=', 'INGRESO')
                              ->count();
        $mv2 = \App\Movimientos::where('dia', '=', $dia->dia)
                              ->where('mes', '=', date('m'))
                              ->where('anio', '=', date('Y'))
                              ->where('cerrado_gestion', '=', 'NO')
                              ->where('movimiento', '=', 'INGRESO STOCK')
                              ->count();
        $mv3 = \App\Movimientos::where('dia', '=', $dia->dia)
                              ->where('mes', '=', date('m'))
                              ->where('anio', '=', date('Y'))
                              ->where('cerrado_gestion', '=', 'NO')
                              ->where('movimiento', '=', 'SALIDA')
                              ->count();
        $mv4 = \App\Movimientos::where('dia', '=', $dia->dia)
                              ->where('mes', '=', date('m'))
                              ->where('anio', '=', date('Y'))
                              ->where('cerrado_gestion', '=', 'NO')
                              ->where('movimiento', '=', 'SALIDA STOCK')
                              ->count();
        $datos[] = ['State'=>'Dia '.$dia->dia, 'freq'=>['Ingreso'=>$mv1, 'IngresoStock'=>$mv2, 'Salida'=>$mv3, 'SalidaStock'=>$mv4] ]  ;
      }
      return    $datos;
    });
    ///Reportes
    Route::resource('Rutas', 'UserController');
    Route::resource('LogNavegaciones', 'LogNavegacionesController');
    Route::resource('LogSesiones', 'LogSesionesController');


});
