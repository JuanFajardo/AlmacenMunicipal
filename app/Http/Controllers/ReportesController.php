<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests;
use App\Gestiones;

class ReportesController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');

      if( \Auth::guest() )
        return redirect('index.php/login');
      elseif(\Auth::user()->grupo != 1 &&  \Auth::user()->grupo != 2 && \Auth::user()->grupo != 3 && \Auth::user()->grupo != 4)
      $this->logNavegation();
    }

    public function logNavegation(){
        if(\Request::method() == "POST"){
          $acion = "INSERCION";
        }elseif(\Request::method() == "GET"){
          $acion = "LISTAR/VER";
        }elseif(\Request::method() == "PUT"){
          $acion = "ACTUALIZAR";
        }elseif(\Request::method() == "DELETE"){
          $acion = "ELMINAR";
        }
        $dato = array('direccion'=>\Request::url(), 'accion'=>$acion.' -> '.\Request::method(), 'ip'=>\Request::getClientIp(), 'navegador'=>\Request::header('User-Agent'), 'usuario'=>\Auth::user()->name );
        \App\LogNavegaciones::create($dato);
    }


    ////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////
    /**
     * Formulario del reporte General
     * Link: index.php/Reportes/ | get
     */
    public function index(){
      try{
        return view('reporte.index');
      }catch (Exception $e) {
        return "<script> alert('Error R0001: Formulario del reporte General \n".$e->getMessage()."'); location.href='".asset('index.php/Reportes')."'; </script>";
      }
    }

    /**
     * Generacion del reporte General
     * Link: index.php/Reportes/ | post
     */
    public function store(Request $request){
      try{
        $movimientos = "";
        if( $request->movimientos != '' ) {
          if($request->movimientos == "1" ) $consulta = "INGRESO";
          if($request->movimientos == "2" ) $consulta = "SALIDA";
          if($request->movimientos == "4" ) $consulta = "INGRESO STOCK";
          if($request->movimientos == "5" ) $consulta = "SALIDA STOCK";

          if($request->movimientos == "1" || $request->movimientos == "2" || $request->movimientos == "4"  || $request->movimientos == "5" )
                $movimientos = " movimientos.movimiento = '".$consulta."' ";
          if($request->movimientos == "3" )
                $movimientos = " movimientos.movimiento = 'INGRESO' or  movimientos.movimiento = 'SALIDA' ";
          if($request->movimientos == "6" )
                $movimientos = " movimientos.movimiento = 'INGRESO STOCK' or  movimientos.movimiento = 'SALIDA STOCK' ";
        }else{
          $movimientos = ' 1=1 ';
        }

        $almacenes = "";
        if($request->almacenes != '' ){
          $almacenes = "movimientos.id_almacen = '".$request['almacenes']."' ";
        }else{
          $almacenes = ' 1=1 ';
        }

        $conceptos = "";
        if( $request->conceptos  != '' ){
          $conceptos = "movimientos.id_concepto = '".$request['conceptos']."' ";
        }else{
          $conceptos = ' 1=1 ';
        }

        $funcionarios = "";
        if( $request->funcionarios  != '' ){
          $funcionarios = "movimientos.id_funcionario = '".$request['funcionarios']."' ";
        }else{
          $funcionarios = ' 1=1 ';
        }

        $proveedores = "";
        if( $request->proveedores != '' ){
          $proveedores = "movimientos.id_proveedor = '".$request['proveedores']."' ";
        }else{
          $proveedores = ' 1=1 ';
        }



        $aperturas = "";
        if( $request->aperturas != ''){
          $aperturas = "clasificadores_movimientos.id = '".$request['aperturas']."'";
        }else{
          $aperturas = ' 1=1 ';
        }

        $clasificadores = "";
        if( $request->clasificadores != ''){
          $clasificadores = "clasificadores_movimientos.id = '".$request['clasificadores']."'";
        }else{
          $clasificadores = ' 1=1 ';
        }

        if( $request->movimientos == "2" || $request->movimientos == "5" ){
          $movimientos = \DB::table('movimientos')->join('aperturas_movimientos', 'movimientos.id', '=', 'aperturas_movimientos.id_movimiento')
                                                  ->join('clasificadores_movimientos', 'movimientos.id', '=', 'clasificadores_movimientos.id_movimiento')
                                                  ->join('cambios', 'movimientos.id_cambio', '=', 'cambios.id')
                                                  ->join('conceptos', 'movimientos.id_concepto', '=', 'conceptos.id')
                                                  ->join('proveedores', 'movimientos.id_proveedor', '=', 'proveedores.id')
                                                  ->join('funcionarios', 'movimientos.id_funcionario', '=', 'funcionarios.id')
                                                  ->join('users', 'movimientos.id_usuario', '=', 'users.id')
                                                  ->whereRaw($movimientos)
                                                  ->whereRaw($almacenes)
                                                  ->whereRaw($conceptos)
                                                  ->whereRaw($funcionarios)
                                                  ->whereRaw($proveedores)
                                                  ->whereRaw($aperturas)
                                                  ->whereRaw($clasificadores)
                                                  ->where('movimientos.id_gestion', '=', Gestiones::gestion())
                                                  ->where('movimientos.created_at', '>=', Carbon::parse($request->fecha_inicio) )
                                                  ->orWhere('movimientos.created_at', '=', Carbon::parse($request->fecha_inicio) )
                                                  ->where('movimientos.created_at', '<', Carbon::parse($request->fecha_fin) )
                                                  ->orWhere('movimientos.created_at', '=', Carbon::parse($request->fecha_fin) )
                                                  ->select('movimientos.id as idMovimientoPrincipal', 'movimientos.*', 'aperturas_movimientos.*', 'clasificadores_movimientos.*', 'cambios.*', 'conceptos.*', 'proveedores.*', 'funcionarios.*','users.*')->get();
          $link = 'reporte.generalSalida';
        }elseif ($request->movimientos == "1" ||  $request->movimientos == "4" ) {  // INGRESO INGRESO STOCK
          $movimientos = \DB::table('movimientos')->join('aperturas_movimientos', 'movimientos.id', '=', 'aperturas_movimientos.id_movimiento')
                                                  ->join('clasificadores_movimientos', 'movimientos.id', '=', 'clasificadores_movimientos.id_movimiento')
                                                  ->join('cambios', 'movimientos.id_cambio', '=', 'cambios.id')
                                                  ->join('conceptos', 'movimientos.id_concepto', '=', 'conceptos.id')
                                                  ->join('proveedores', 'movimientos.id_proveedor', '=', 'proveedores.id')
                                                  ->join('users', 'movimientos.id_usuario', '=', 'users.id')
                                                  ->whereRaw($movimientos)
                                                  ->whereRaw($almacenes)
                                                  ->whereRaw($conceptos)
                                                  ->whereRaw($proveedores)
                                                  ->whereRaw($aperturas)
                                                  ->whereRaw($clasificadores)
                                                  ->where('movimientos.id_gestion', '=', Gestiones::gestion())
                                                  ->where('movimientos.created_at', '>=', Carbon::parse($request->fecha_inicio) )
                                                  ->orWhere('movimientos.created_at', '>=', Carbon::parse($request->fecha_inicio) )
                                                  ->where('movimientos.created_at', '<=', Carbon::parse($request->fecha_fin) )
                                                  ->orWhere('movimientos.created_at', '<=', Carbon::parse($request->fecha_fin) )
                                                  ->select('movimientos.id as idMovimientoPrincipal', 'movimientos.*', 'aperturas_movimientos.*', 'clasificadores_movimientos.*', 'cambios.*', 'conceptos.*', 'proveedores.*', 'users.*')->get();
          $link = 'reporte.generalIngreso';
        }

        $colspan=0;
        $movimiento       = NULL; if( isset($request->movimiento) )     { $movimiento= "Movimiento"; $colspan++; }
        $nro_moviento     = NULL; if( isset($request->nro_moviento) )   { $nro_moviento= "Nro. Movimiento"; $colspan++; }
        $fecha            = NULL; if( isset($request->fecha) )          { $fecha= "Fecha Transaccion"; $colspan++; }
        $apertura         = NULL; if( isset($request->apertura) )       { $apertura= "Apertura P."; $colspan++; }
        $clasificador     = NULL; if( isset($request->clasificador) )   { $clasificador= "P. Clasificador"; $colspan++; }
        $fecha            = NULL; if( isset($request->fecha) )          { $fecha= "Fecha Transaccion"; $colspan++; }
        $rupe             = NULL; if( isset($request->rupe) )           { $rupe= "Rupe"; $colspan++; }
        $codigo_pedido    = NULL; if( isset($request->codigo_pedido) )  { $codigo_pedido= "Codigo de Pedido"; $colspan++; }
        $orden_compra     = NULL; if( isset($request->orden_compra) )   { $orden_compra= "Orden Compra"; $colspan++; }
        $glosa            = NULL; if( isset($request->glosa) )          { $glosa= "Glosa"; $colspan++; }
        $tipo_factura     = NULL; if( isset($request->tipo_factura) )   { $tipo_factura= "Tipo Factura"; $colspan++; }
        $numero_factura   = NULL; if( isset($request->numero_factura) ) { $numero_factura= "Nro. Factura"; $colspan++; }
        $total_factura    = NULL; if( isset($request->total_factura) )  { $total_factura= "Total Factura"; $colspan++; }
        $otro_documento   = NULL; if( isset($request->otro_documento) ) { $otro_documento= "Otro Documento"; $colspan++; }
        $movimiento_ingreso   = NULL; if( isset($request->movimiento_ingreso) ) { $movimiento_ingreso= "Nro. Ingreso"; $colspan++; }
        $ufv              = NULL; if( isset($request->ufv) )            { $ufv= "UFV"; $colspan++; }
        $dolar            = NULL; if( isset($request->dolar) )          { $dolar= "Dolar"; $colspan++; }
        $id_concepto      = NULL; if( isset($request->id_concepto) )    { $id_concepto= "Concepto de Movimiento"; $colspan++; }
        $id_proveedor     = NULL; if( isset($request->id_proveedor) )   { $id_proveedor= "Proveedor"; $colspan++; }
        $id_funcionario   = NULL; if( isset($request->id_funcionario) ) { $id_funcionario= "Funcionario"; $colspan++; }
        $id_usuario       = NULL; if( isset($request->id_usuario) )     { $id_usuario= "Usuario"; $colspan++; }
        $unidad           = NULL; if( isset($request->unidad) )         { $unidad = "Tipo de medida"; $colspan++; }
        $articulo         = NULL; if( isset($request->articulo) )       { $articulo = "Articulo"; $colspan++; }

        $configuracion = \App\Configuraciones::find(1);
        $articulosLista = \DB::table('articulos_movimientos')->join('bienes', 'articulos_movimientos.id_bien', '=', 'bienes.id')
                                                             ->join('unidades', 'bienes.id_unidad', '=', 'unidades.id')
                                                             ->where('articulos_movimientos.id_gestion', '=', Gestiones::gestion())
                                                             ->get();
        $clas = \App\Clasificadores::Where('id_gestion', '=', Gestiones::gestion())->get();
        $aprs = \App\Aperturas::Where('id_gestion', '=', Gestiones::gestion())->get();
        $fechaInicio = isset($request->fecha_inicio) ? $request->fecha_inicio : date('Y-m-d');
        $fechaFin = isset($request->fecha_fin) ? $request->fecha_fin : date('Y-m-d');

        if($colspan < 10){
          //$pdf->setPaper('letter', 'portrait');
          $hoja = 'letter';
          $pocision = 'portrait';
        }elseif ($colspan <= 13) {
          //$pdf->setPaper('letter', 'landscape');
          $hoja = 'letter';
          $pocision = 'landscape';
        }elseif ($colspan > 13) {
          //$pdf->setPaper('legal', 'landscape');
          $hoja = 'letter';
          $pocision = 'landscape';
        }

        $pdf = \PDF::loadView($link, compact('movimientos', 'movimiento', 'clas', 'aprs', 'nro_moviento', 'fecha', 'apertura', 'clasificador', 'rupe', 'codigo_pedido', 'orden_compra', 'glosa', 'tipo_factura', 'numero_factura', 'total_factura', 'otro_documento', 'movimiento_ingreso', 'ufv', 'dolar', 'id_concepto', 'id_proveedor', 'id_funcionario', 'id_usuario', 'unidad', 'articulo', 'articulosLista', 'colspan', 'configuracion', 'fechaInicio', 'fechaFin') )
        ->setPaper($hoja)->setOrientation($pocision)->setOption('margin-bottom', 0);
        return $pdf->inline('ReporteGeneral'.date('Ymdhis').'.pdf');
      }catch (Exception $e) {
        return "<script> alert('Error R0002: Generacion del reporte General \n".$e->getMessage()."'); location.href='".asset('index.php/Reportes')."'; </script>";
      }
    }
    ////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////



    /**
     * Visualizacion de los reportes de Movimeintos INGRESO/SALIDA Inmediato/Stock
     * Link: index.php/Reportes/mostrar/{id} | get
     */
    public function show($id){
      try{

        if($id != "STOCK_SALIDA"){
          $movimiento = \App\Movimientos::find($id);
          if($movimiento->movimiento == 'SALIDA' || $movimiento->movimiento == 'SALIDA STOCK' ){
            $url = 'reporte.salida';
            $aperturasMovimientos = \DB::table('articulos_movimientos')->join('movimientos',          'articulos_movimientos.id_movimiento',   '=', 'movimientos.id')
                                                                          ->join('aperturas',            'articulos_movimientos.id_apertura',  '=', 'aperturas.id')
                                                                          ->where('articulos_movimientos.id_movimiento',                       '=', $id)
                                                                          ->where('articulos_movimientos.movimiento',                          '=', $movimiento->movimiento)
                                                                          ->where('articulos_movimientos.id_gestion',                          '=', Gestiones::gestion())
                                                                          ->select('aperturas.*')
                                                                          ->groupBy('aperturas.id')
                                                                          ->get();
            $clasificadoresMovimientos = \DB::table('articulos_movimientos')->join('movimientos',          'articulos_movimientos.id_movimiento',   '=', 'movimientos.id')
                                                                          ->join('clasificadores',       'articulos_movimientos.id_clasificador', '=', 'clasificadores.id')
                                                                          ->where('articulos_movimientos.id_movimiento',                          '=', $id)
                                                                          ->where('articulos_movimientos.movimiento',                             '=', $movimiento->movimiento)
                                                                          ->where('articulos_movimientos.id_gestion',                             '=', Gestiones::gestion())
                                                                          ->select('clasificadores.*')
                                                                          ->groupBy('clasificadores.id')
                                                                          ->orderBy('clasificadores.codigo')
                                                                          ->get();
            $datos = \DB::table('articulos_movimientos')->join('users',             'articulos_movimientos.id_usuario',      '=', 'users.id')
                                                     ->join('movimientos',          'articulos_movimientos.id_movimiento',   '=', 'movimientos.id')
                                                     ->join('proveedores',          'movimientos.id_proveedor',              '=', 'proveedores.id')
                                                     ->join('conceptos',            'movimientos.id_concepto',               '=', 'conceptos.id')
                                                     ->join('clasificadores',       'articulos_movimientos.id_clasificador', '=', 'clasificadores.id')
                                                     ->join('aperturas',            'articulos_movimientos.id_apertura',     '=', 'aperturas.id')
                                                     ->join('bienes',               'articulos_movimientos.id_bien',         '=', 'bienes.id')
                                                     ->join('unidades',             'bienes.id_unidad',                      '=', 'unidades.id')
                                                     ->join('funcionarios',         'movimientos.id_funcionario',            '=', 'funcionarios.id')
                                                     ->join('estructuras',          'funcionarios.id_estructura',            '=', 'estructuras.id')
                                                     ->where('articulos_movimientos.id_movimiento',                          '=', $id)
                                                     ->where('articulos_movimientos.movimiento',                             '=', $movimiento->movimiento)
                                                     ->where('articulos_movimientos.id_gestion',                             '=', Gestiones::gestion())
                                                     ->select('articulos_movimientos.id as Nely','movimientos.*',
                                                      'conceptos.concepto',
                                                      'proveedores.*',
                                                      'articulos_movimientos.cantidad', 'articulos_movimientos.costo', 'articulos_movimientos.total',  'articulos_movimientos.id_bien',
                                                      'unidades.unidad',
                                                      'bienes.*', 'unidades.unidad',
                                                      'users.nombreCompleto',
                                                      'aperturas.apertura',  'aperturas.codigo as aperturacodigo',
                                                      'clasificadores.clasificador', 'clasificadores.codigo as clasificadorcodigo',
                                                      'funcionarios.*',
                                                      'estructuras.*')
                                                     ->orderBy('clasificadores.codigo' , 'asc')
                                                     ->orderBy('bienes.codigo' , 'asc')
                                                     ->get();
          }elseif ($movimiento->movimiento == 'INGRESO' || $movimiento->movimiento == 'INGRESO STOCK' ){
            $url = 'reporte.ingreso';
            $aperturasMovimientos = \DB::table('articulos_movimientos')->join('movimientos',          'articulos_movimientos.id_movimiento',   '=', 'movimientos.id')
                                                                          ->join('aperturas',            'articulos_movimientos.id_apertura',      '=', 'aperturas.id')
                                                                          ->where('articulos_movimientos.id_movimiento',                          '=', $id)
                                                                          ->where('articulos_movimientos.movimiento',                             '=', $movimiento->movimiento)
                                                                          ->where('articulos_movimientos.id_gestion',                             '=', Gestiones::gestion())
                                                                          ->select('aperturas.*')
                                                                          ->groupBy('aperturas.id')
                                                                          ->get();
            $clasificadoresMovimientos = \DB::table('articulos_movimientos')->join('movimientos',          'articulos_movimientos.id_movimiento',   '=', 'movimientos.id')
                                                                          ->join('clasificadores',       'articulos_movimientos.id_clasificador', '=', 'clasificadores.id')
                                                                          ->where('articulos_movimientos.id_movimiento',                          '=', $id)
                                                                          ->where('articulos_movimientos.movimiento',                             '=', $movimiento->movimiento)
                                                                          ->where('articulos_movimientos.id_gestion',                             '=', Gestiones::gestion())
                                                                          ->select('clasificadores.*')
                                                                          ->groupBy('clasificadores.id')
                                                                          ->get();

             $datos = \DB::table('articulos_movimientos')->join('users',            'articulos_movimientos.id_usuario',       '=', 'users.id')
                                                     ->join('movimientos',          'articulos_movimientos.id_movimiento',    '=', 'movimientos.id')
                                                     ->join('proveedores',          'movimientos.id_proveedor',               '=', 'proveedores.id')
                                                     ->join('conceptos',            'movimientos.id_concepto',                '=', 'conceptos.id')
                                                     ->join('clasificadores',       'articulos_movimientos.id_clasificador',  '=', 'clasificadores.id')
                                                     ->join('aperturas',            'articulos_movimientos.id_apertura',      '=', 'aperturas.id')
                                                     ->join('bienes',               'articulos_movimientos.id_bien',          '=', 'bienes.id')
                                                     ->join('unidades',             'bienes.id_unidad',                       '=', 'unidades.id')
                                                     ->where('articulos_movimientos.movimiento',                              '=', $movimiento->movimiento)
                                                     ->where('articulos_movimientos.id_movimiento',                           '=', $id)
                                                     ->where('articulos_movimientos.id_gestion',                              '=', Gestiones::gestion())
                                                     ->select('articulos_movimientos.id as Nely','movimientos.*',
                                                      'conceptos.concepto',
                                                      'proveedores.*',
                                                      'articulos_movimientos.cantidad','articulos_movimientos.cantidad_actual', 'articulos_movimientos.costo', 'articulos_movimientos.total',  'articulos_movimientos.id_bien',
                                                      'unidades.unidad',
                                                      'bienes.*',
                                                      'users.nombreCompleto',
                                                      'aperturas.apertura',  'aperturas.codigo as aperturacodigo',
                                                      'clasificadores.clasificador', 'clasificadores.codigo as clasificadorcodigo')
                                                     ->orderBy('clasificadores.codigo' , 'asc')
                                                     ->orderBy('bienes.codigo' , 'asc')
                                                     ->get();

          }
        }else{
            $url = 'reporte.salida';
            $aperturasMovimientos = \DB::table('articulos_movimientos')->join('movimientos',          'articulos_movimientos.id_movimiento',   '=', 'movimientos.id')
                                                                          ->join('aperturas',            'articulos_movimientos.id_apertura',      '=', 'aperturas.id')
                                                                          ->where('articulos_movimientos.id_movimiento',                          '=', $id)
                                                                          ->where('articulos_movimientos.movimiento',                            '=','INGRESO')
                                                                          ->orWhere('articulos_movimientos.movimiento',                          '=','INGRESO STOCK')
                                                                          ->where('articulos_movimientos.id_gestion',                             '=', Gestiones::gestion())
                                                                          ->select('aperturas.*')
                                                                          ->groupBy('aperturas.id')
                                                                          ->get();
            $clasificadoresMovimientos = \DB::table('articulos_movimientos')->join('movimientos',          'articulos_movimientos.id_movimiento',   '=', 'movimientos.id')
                                                                          ->join('clasificadores',       'articulos_movimientos.id_clasificador', '=', 'clasificadores.id')
                                                                          ->where('articulos_movimientos.id_movimiento',                          '=', $id)
                                                                          ->where('articulos_movimientos.movimiento',                            '=','INGRESO')
                                                                          ->orWhere('articulos_movimientos.movimiento',                          '=','INGRESO STOCK')
                                                                          ->where('articulos_movimientos.id_gestion',                             '=', Gestiones::gestion())
                                                                          ->select('clasificadores.*')
                                                                          ->groupBy('clasificadores.id')
                                                                          ->get();
            $datos = \DB::table('articulos_movimientos')->join('users',             'articulos_movimientos.id_usuario',     '=', 'users.id')
                                                     ->join('movimientos',          'articulos_movimientos.id_movimiento',  '=', 'movimientos.id')
                                                     ->join('proveedores',          'movimientos.id_proveedor',             '=', 'proveedores.id')
                                                     ->join('conceptos',            'movimientos.id_concepto',              '=', 'conceptos.id')
                                                     ->join('clasificadores',       'articulos_movimientos.id_clasificador','=', 'clasificadores.id')
                                                     ->join('aperturas',            'articulos_movimientos.id_apertura',    '=', 'aperturas.id')
                                                     ->join('bienes',                    'articulos_movimientos.id_bien',   '=', 'bienes.id')
                                                     ->join('unidades',                  'bienes.id_unidad',                '=', 'unidades.id')
                                                     ->where('articulos_movimientos.id_movimiento',                         '=', $id)
                                                     ->where('articulos_movimientos.movimiento',                            '=','INGRESO')
                                                     ->orWhere('articulos_movimientos.movimiento',                          '=','INGRESO STOCK')
                                                     ->where('articulos_movimientos.id_gestion',                            '=', Gestiones::gestion())
                                                     ->select('articulos_movimientos.id as Nely','movimientos.*',
                                                      'conceptos.concepto',
                                                      'proveedores.*',
                                                      'articulos_movimientos.cantidad', 'articulos_movimientos.costo', 'articulos_movimientos.total',  'articulos_movimientos.id_bien',
                                                      'unidades.unidad',
                                                      'bienes.*', 'unidades.unidad',
                                                      'users.nombreCompleto',
                                                      'aperturas.apertura',  'aperturas.codigo as aperturacodigo',
                                                      'clasificadores.clasificador', 'clasificadores.codigo as clasificadorcodigo')
                                                     /*->orderBy('articulos_movimientos.id')*/
                                                     ->orderBy('clasificadores.codigo' , 'asc')
                                                     ->orderBy('bienes.codigo' , 'asc')
                                                     ->get();
                                                     return $datos;
        }

        $configuracion    = \DB::table('configuraciones')->get(); // \App\Configuraciones::first();
        $funcionarios   = \DB::table('funcionarios')->get();

        $movimientoDato   = \App\Movimientos::Where('id', '=', $id)->first();
        $eliminacion = $movimientoDato->eliminacion != '' ?  $movimientoDato->eliminacion : '';
        $name = 'Movimiento'.date('Ymdhis').'.pdf';

        //return Gestiones::gestion();
        return view($url, compact('datos', 'configuracion', 'movimientoDato','aperturasMovimientos', 'clasificadoresMovimientos', 'funcionarios', 'eliminacion'));

        $pdf = \PDF::loadView($url, compact('datos', 'configuracion', 'movimientoDato','aperturasMovimientos', 'clasificadoresMovimientos', 'funcionarios', 'eliminacion') )
        ->setOption('footer-html', asset('pie.php'))
        ->setPaper('letter')->setOrientation('portrait')
        ->setOption('page-width', '216mm')
        ->setOption('page-height', '279mm')
        ->setOption('margin-right', '10mm')
        ->setOption('margin-left', '15mm')
        ->setOption('margin-bottom', '10mm')
        ->setOption('header-spacing', 15)
        ->setOption('footer-spacing', 2)
        ->save($name);

        $tipoMovimiento = $movimiento->movimiento;
        return view('reporte.pdfView', compact('name', 'tipoMovimiento', 'id'));
      }catch (Exception $e) {
        return "<script> alert('Error R0003: Visualizacion de los reportes de Movimeintos INGRESO/SALIDA Inmediato/Stock \n".$e->getMessage()."'); location.href='".asset('index.php/Reportes')."'; </script>";
      }
    }

    /**
     * Formulario: Reporte de movimientos por funcionarios
     * Link: index.php/Reportes/funcionario | get
     */
    public function funcionairoIndex(){
      try{
        $datos = \DB::table('articulos_movimientos')->join('aperturas',       'articulos_movimientos.id_apertura',     '=', 'aperturas.id')
                                                    ->join('clasificadores',  'articulos_movimientos.id_clasificador', '=', 'clasificadores.id')
                                                    ->join('bienes',          'articulos_movimientos.id_bien',         '=', 'bienes.id')
                                                    ->join('movimientos',     'articulos_movimientos.id_movimiento',   '=', 'movimientos.id')
                                                    ->join('unidades',        'bienes.id_unidad',                      '=', 'unidades.id')
                                                    ->join('funcionarios',    'movimientos.id_funcionario',            '=', 'funcionarios.id')
                                                    ->whereIn('articulos_movimientos.movimiento', array('SALIDA', 'SALIDA STOCK'))
                                                    ->where('articulos_movimientos.id_gestion',                        '=', Gestiones::gestion())

                                                    ->select('aperturas.codigo as codigoApertura', 'articulos_movimientos.created_at as fechaM', 'articulos_movimientos.*',
                                                    'aperturas.*',
                                                    'clasificadores.codigo as codigoClasificador', 'clasificadores.*',
                                                    'bienes.codigo as codigoBien', 'bienes.*', 'unidades.*', 'funcionarios.*', 'movimientos.fecha', 'movimientos.nro_moviento', 'movimientos.movimiento')
                                                    ->get();
        $funcionarios = \App\Funcionarios::Where('id_gestion', '=', Gestiones::gestion())->get();
        //$almacenes    = \App\Almacenes::all();
        $almacenes    = \DB::table('almacenes')->get(); //\App\Almacenes::all();
        return view( 'reporte.funcionario', compact('datos', 'funcionarios', 'almacenes') );
      }catch (Exception $e) {
        return "<script> alert('Error R0004: Formulario: Reporte de movimientos por funcionarios  \n".$e->getMessage()."'); location.href='".asset('index.php/Reportes')."'; </script>";
      }
    }

    /**
    * Reporte de movimientos por funcionarios
    * Link: index.php/Reportes/funcionario | post
     */
    public function funcionario(Request $request){
      try{
        $idAlmacen = \App\Almacenes::Where('almacen', '=', $request->id_almacen)->first();
        $funcionario    = $request->funcionario == '' ? ' 1=1 ' : " movimientos.id_funcionario = '".trim(explode('-', $request->funcionario)[0])."'" ;
        $idFuncionario  = $request->funcionario == '' ? ' 1=1 ' : " funcionarios.id = '".trim(explode('-', $request->funcionario)[0])."'" ;
        $datos = \DB::table('articulos_movimientos')->join('users',                  'articulos_movimientos.id_usuario',          '=', 'users.id')
                                                 ->join('movimientos',               'articulos_movimientos.id_movimiento',       '=', 'movimientos.id')
                                                 ->join('almacenes',                 'articulos_movimientos.id_almacen',          '=', 'almacenes.id')
                                                 ->join('aperturas',                 'articulos_movimientos.id_apertura',         '=', 'aperturas.id')
                                                 ->join('clasificadores',            'articulos_movimientos.id_clasificador',     '=', 'clasificadores.id')
                                                 ->join('funcionarios',              'movimientos.id_funcionario',                '=', 'funcionarios.id')
                                                 ->join('proveedores',               'movimientos.id_proveedor',                  '=', 'proveedores.id')
                                                 ->join('conceptos',                 'movimientos.id_concepto',                   '=', 'conceptos.id')
                                                 ->join('bienes',                    'articulos_movimientos.id_bien',             '=', 'bienes.id')
                                                 ->join('unidades',                  'bienes.id_unidad',                          '=', 'unidades.id')
                                                 ->join('estructuras',               'funcionarios.id_estructura',                '=', 'estructuras.id')
                                                 ->where('articulos_movimientos.cantidad',      '>', '0')
                                                 ->where('articulos_movimientos.observacion',   '=', '')
                                                 ->where('movimientos.id_gestion',              '=', Gestiones::gestion())
                                                 ->where('movimientos.id_almacen',              '=', $idAlmacen->id)
                                                 ->where('articulos_movimientos.created_at',    '>=', Carbon::parse($request->fecha_inicio) )
                                                 ->where('articulos_movimientos.created_at',    '<=', Carbon::parse($request->fecha_fin) )
                                                 ->whereRaw($funcionario)
                                                 ->whereRaw($idFuncionario)
                                                 ->select('users.name','movimientos.*', 'conceptos.concepto', 'proveedores.proveedor',
                                                  'articulos_movimientos.observacion', 'articulos_movimientos.cantidad', 'articulos_movimientos.cantidad_actual', 'articulos_movimientos.costo',
                                                  'articulos_movimientos.total',  'articulos_movimientos.id_bien',
                                                  'movimientos.fecha as fechaMovimiento', 'movimientos.nro_moviento', 'movimientos.movimiento',
                                                  'unidades.unidad',
                                                  'funcionarios.id as idFuncionario', 'funcionarios.nombres', 'funcionarios.paterno', 'funcionarios.materno',
                                                  'estructuras.estructura',
                                                  'almacenes.*',
                                                  'bienes.bien',
                                                  'unidades.unidad',
                                                  'aperturas.apertura',  'aperturas.codigo as aperturacodigo',
                                                  'clasificadores.clasificador', 'clasificadores.codigo as clasificadorcodigo')
                                                 ->orderBy('funcionarios.id')
                                                 ->orderBy('bienes.bien')
                                                 ->get();

        $fechaInicio =  $request->fecha_inicio;
        $fechaFin    =  $request->fecha_fin;
        $configuracion = \DB::table('configuraciones')->first();
        $almacen = \DB::table('almacenes')->select('almacen')->first();
        /*
        $view =  \View::make('reporte.funcionarioReporte', compact('datos', 'configuracion') )->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('office', 'landscape');
        $pdf->loadHTML($view);
        return $pdf->stream('Codigo4060_Funcionario.pdf');
        */

        $pdf = \PDF::loadView('reporte.funcionarioReporte', compact('datos', 'configuracion', 'almacen','fechaInicio', 'fechaFin') )
        //->setPaper('letter')->setOrientation('landscape')
        ->setPaper('letter')->setOrientation('portrait')
        ->setOption('page-width', '216mm')
        ->setOption('page-height', '279mm')
        ->setOption('margin-right', '10mm')
        ->setOption('margin-left', '15mm')
        ->setOption('margin-bottom', '15mm')
        ->setOption('header-spacing', 15)
        ->setOption('footer-spacing', 1)
        ->setOption('footer-html', asset('pie.php'));

        return $pdf->inline('Funcionarios'.date('Ymdhis').'.pdf');
      }catch (Exception $e) {
        return "<script> alert('Error R0005: Reporte de movimientos por funcionarios \n".$e->getMessage()."'); location.href='".asset('index.php/Reportes')."'; </script>";
      }
    }

    /**
     * Formulario: Reporte de movimientos por Aperturas
     * Link: index.php/Reportes/apertura | get
     */
    public function aperturaIndex(){
      try{
        $datos = \DB::table('articulos_movimientos')->join('aperturas',       'articulos_movimientos.id_apertura',     '=', 'aperturas.id')
                                                    ->join('clasificadores',  'articulos_movimientos.id_clasificador', '=', 'clasificadores.id')
                                                    ->join('bienes',          'articulos_movimientos.id_bien',         '=', 'bienes.id')
                                                    ->join('movimientos',     'articulos_movimientos.id_movimiento',   '=', 'movimientos.id')
                                                    ->join('unidades',        'bienes.id_unidad',                      '=', 'unidades.id')
                                                    ->where('articulos_movimientos.id_gestion',                        '=', Gestiones::gestion())
                                                    ->select('aperturas.codigo as codigoApertura', 'aperturas.*',
                                                    'clasificadores.codigo as codigoClasificador', 'clasificadores.*',
                                                    'bienes.codigo as codigoBien', 'bienes.*',
                                                    'unidades.*',
                                                    'articulos_movimientos.*',
                                                    'movimientos.fecha', 'movimientos.nro_moviento', 'movimientos.movimiento')
                                                    ->get();
        $almacenes    = \DB::table('almacenes')->get(); //\App\Almacenes::all();
        $aperturas = \App\Aperturas::Where('id_gestion', '=', Gestiones::gestion())->get();
        return view( 'reporte.apertura', compact('datos', 'almacenes', 'aperturas') );
      }catch (Exception $e) {
        return "<script> alert('Error R0006: Formulario: Reporte de movimientos por Aperturas \n".$e->getMessage()."'); location.href='".asset('index.php/Reportes')."'; </script>";
      }
    }

    /**
    * Reporte de movimientos por Aperturas
    * Link: index.php/Reportes/apertura | post
     */
    public function apertura(Request $request){
      try{
        $idAlmacen = \App\Almacenes::Where('almacen', '=', $request->id_almacen)->first();
        $idApertura = \App\Aperturas::where('codigo', '=', explode('-', $request->id_apertura)[0] )->first();
        $apertura = $request->id_apertura != '' ? "articulos_movimientos.id_apertura = '".$idApertura->id."'" : ' 1=1 ' ;
        $datos = \DB::table('articulos_movimientos')->join('users',              'articulos_movimientos.id_usuario',      '=', 'users.id')
                                                    ->join('movimientos',        'articulos_movimientos.id_movimiento',   '=', 'movimientos.id')
                                                    ->join('almacenes',          'articulos_movimientos.id_almacen',      '=', 'almacenes.id')
                                                    ->join('conceptos',          'movimientos.id_concepto',               '=', 'conceptos.id')
                                                    ->join('bienes',             'articulos_movimientos.id_bien',         '=', 'bienes.id')
                                                    ->join('unidades',           'bienes.id_unidad',                      '=', 'unidades.id')
                                                    ->join('aperturas',          'articulos_movimientos.id_apertura',     '=', 'aperturas.id')
                                                    ->join('clasificadores',     'articulos_movimientos.id_clasificador', '=', 'clasificadores.id')
                                                    //->where('articulos_movimientos.id_apertura',    '=', $idApertura->id )
                                                    ->whereRaw($apertura)
                                                    ->where('articulos_movimientos.id_almacen',     '=', $idAlmacen->id )
                                                    ->where('articulos_movimientos.eliminacion',    '=', '' )
                                                    ->where('articulos_movimientos.created_at',     '>', Carbon::parse($request->fecha_inicio) )
                                                    ->orWhere('articulos_movimientos.created_at',   '=', Carbon::parse($request->fecha_inicio) )
                                                    ->where('articulos_movimientos.created_at',     '<', Carbon::parse($request->fecha_fin) )
                                                    ->orWhere('articulos_movimientos.created_at',   '=', Carbon::parse($request->fecha_fin) )
                                                    ->where('articulos_movimientos.id_gestion',     '=', Gestiones::gestion())
                                                    ->select('articulos_movimientos.id', 'articulos_movimientos.*',
                                                    'movimientos.fecha as movimientoFecha', 'movimientos.movimiento as movimientoTipo', 'movimientos.nro_moviento',
                                                    'conceptos.tipo', 'conceptos.concepto',
                                                    'users.name', 'bienes.bien', 'bienes.codigo as bienCodigo',
                                                    'aperturas.codigo as aperturaCodigo',
                                                    'clasificadores.codigo as clasificadorCodigo')
                                                    ->orderBy('bienes.bien', 'asc')
                                                    ->orderBy('articulos_movimientos.id_bien', 'asc')
                                                    ->orderBy('articulos_movimientos.movimiento', 'asc')
                                                    ->get();

        $aperturas = \DB::table('aperturas')->join('articulos_movimientos', 'aperturas.id',                         '=', 'articulos_movimientos.id_apertura')
                                            ->join('bienes',                'articulos_movimientos.id_bien',        '=', 'bienes.id')
                                            ->join('movimientos',           'articulos_movimientos.id_movimiento',  '=', 'movimientos.id')
                                            //->where('articulos_movimientos.id_apertura',    '=', $idApertura->id )
                                            ->whereRaw($apertura)
                                            ->where('articulos_movimientos.id_almacen',     '=', $idAlmacen->id )
                                            ->where('articulos_movimientos.eliminacion',    '=', '')
                                            ->where('articulos_movimientos.created_at',     '>', Carbon::parse($request->fecha_inicio) )
                                            ->orWhere('articulos_movimientos.created_at',   '=', Carbon::parse($request->fecha_inicio) )
                                            ->where('articulos_movimientos.created_at',     '<', Carbon::parse($request->fecha_fin) )
                                            ->orWhere('articulos_movimientos.created_at',   '=', Carbon::parse($request->fecha_fin) )
                                            ->where('articulos_movimientos.created_at',     '=', Gestiones::gestion() )
                                            ->select('aperturas.id', 'aperturas.codigo', 'aperturas.apertura', 'bienes.bien')
                                            ->orderBy('articulos_movimientos.id_apertura')
                                            ->groupBy('aperturas.id')
                                            ->orderBy('aperturas.id')
                                            ->get();
        $fechaInicio =  $request->fecha_inicio;
        $fechaFin    =  $request->fecha_fin;
        $apertura = $request->id_apertura;
        $configuracion = \DB::table('configuraciones')->first();
        $almacen = \DB::table('almacenes')->select('almacen')->first();

        if($request->button == 'pdfStock'){
          $link = "reporte.aperturaReporte";
        }elseif ($request->button == 'pdfInmediato'){
          $link = "reporte.aperturaReporteIn";
        }
        $pdf = \PDF::loadView($link, compact('datos', 'configuracion',  'aperturas', 'fechaInicio', 'fechaFin', 'idAlmacen','almacen') )
        ->setPaper('letter')->setOrientation('portrait')
        ->setOption('page-width', '216mm')
        ->setOption('page-height', '279mm')
        ->setOption('margin-right', '10mm')
        ->setOption('margin-left', '14mm')
        ->setOption('margin-bottom', '25mm')
        ->setOption('header-spacing', 15)
        ->setOption('footer-spacing', 1)
        ->setOption('footer-html', asset('pie.php'));
        return $pdf->inline('Aperturas'.date('Ymdhis').'.pdf');
      }catch (Exception $e) {
        return "<script> alert('Error R0007: Reporte de movimientos por Aperturas \n".$e->getMessage()."'); location.href='".asset('index.php/Reportes')."'; </script>";
      }
    }

    public function deshusoIndex(){
      try{
        $datos = \DB::table('articulos_movimientos')->join('users',             'articulos_movimientos.id_usuario',     '=', 'users.id')
                                                    ->join('bienes',            'articulos_movimientos.id_bien',        '=', 'bienes.id')
                                                    ->join('movimientos',       'articulos_movimientos.id_movimiento',  '=', 'movimientos.id')
                                                    ->join('almacenes',         'articulos_movimientos.id_almacen',     '=', 'almacenes.id')
                                                    ->join('aperturas',         'articulos_movimientos.id_apertura',    '=', 'aperturas.id')
                                                    ->join('clasificadores',    'articulos_movimientos.id_clasificador','=', 'clasificadores.id')
                                                    ->join('conceptos',         'movimientos.id_concepto',              '=', 'conceptos.id')
                                                    ->where('articulos_movimientos.observacion',                          '!=', '' )
                                                    ->where('articulos_movimientos.id_gestion',                           '=', \App\Gestiones::gestion())
                                                    ->where('articulos_movimientos.id_almacen',                           '=', '1')
                                                    ->select('articulos_movimientos.id', 'articulos_movimientos.*', 'articulos_movimientos.updated_at as actualizado',
                                                      'movimientos.fecha as movimientoFecha', 'movimientos.movimiento as movimientoTipo',
                                                      'conceptos.tipo', 'conceptos.concepto', 'users.name', 'movimientos.nro_moviento',
                                                      'clasificadores.codigo as clasificadorCodigo',
                                                      'aperturas.codigo as aperturaCodigo',
                                                      'almacenes.*', 'bienes.*')
                                                    ->orderBy('articulos_movimientos.id_almacen', 'asc')
                                                    ->get();

        //$almacenes = \App\Almacenes::all();
        $almacenes    = \DB::table('almacenes')->get(); //\App\Almacenes::all();
        //$gestiones = \App\Gestiones::all();
        $gestiones    = \DB::table('gestiones')->get(); //\App\Almacenes::all();

        return view('reporte.deshuso', compact('datos', 'almacenes', 'gestiones') );

      }catch(\Exception $e){
        return "<script> alert('Error R0008: Bienes en deshuso \n".$e->getMessage()."'); location.href='".asset('index.php/Reportes')."'; </script>";
      }
    }

    /**
      * Reporte de bienes en deshuso
      * Link: index.php/Reporte/deshuso | get
     */
    public function deshuso(){
      try{
        $gestion = isset($_GET['gestion']) ? $_GET['gestion'] : date('Y');
        $almacen = isset($_GET['almacen']) ? $_GET['almacen'] : 0;
        $datos = \DB::table('articulos_movimientos')->join('users',               'articulos_movimientos.id_usuario',     '=', 'users.id')
                                                    ->join('movimientos',         'articulos_movimientos.id_movimiento',  '=', 'movimientos.id')
                                                    ->join('almacenes',           'articulos_movimientos.id_almacen',     '=', 'almacenes.id')
                                                    ->join('aperturas',           'articulos_movimientos.id_apertura',    '=', 'aperturas.id')
                                                    ->join('clasificadores',      'articulos_movimientos.id_clasificador','=', 'clasificadores.id')
                                                    ->join('conceptos',           'movimientos.id_concepto',              '=', 'conceptos.id')
                                                    ->where('articulos_movimientos.observacion',                          '!=', '' )
                                                    ->where('articulos_movimientos.id_gestion',                           '=', $gestion)
                                                    ->where('articulos_movimientos.id_almacen',                           '=', $almacen)
                                                    ->select('articulos_movimientos.id', 'articulos_movimientos.*', 'movimientos.fecha as movimientoFecha', 'movimientos.movimiento as movimientoTipo',
                                                      'conceptos.tipo', 'conceptos.concepto', 'users.name', 'movimientos.nro_moviento',
                                                      'clasificadores.codigo as clasificadorCodigo',
                                                      'aperturas.codigo as aperturaCodigo',
                                                      'almacenes.*')
                                                    ->orderBy('articulos_movimientos.id_almacen', 'asc')
                                                    ->get();

        $bienes = \DB::table('bienes')->join('users',                 'bienes.id_usuario',                    '=', 'users.id')
                                      ->join('unidades',              'bienes.id_unidad',                     '=', 'unidades.id')
                                      ->join('articulos_movimientos', 'bienes.id',                            '=', 'articulos_movimientos.id_bien')
                                      ->join('clasificadores',        'articulos_movimientos.id_clasificador','=', 'clasificadores.id')
                                      ->where('articulos_movimientos.observacion',                            '!=', '' )
                                      ->where('bienes.id_gestion',                                            '=', $gestion)
                                      ->select('bienes.id', 'bienes.codigo', 'bienes.bien', 'unidades.unidad', 'users.name',
                                                'clasificadores.codigo as clasificadorCodigo', 'articulos_movimientos.id_almacen')
                                      ->groupBy('bienes.id')->get();

        $configuracion = \DB::table('configuraciones')->first();
        $almacenes = \App\Almacenes::find($almacen);
        $gestion = Gestiones::find($gestion);

        $pdf = \PDF::loadView('reporte.deshusoReporte', compact('datos', 'configuracion', 'bienes', 'apertura', 'almacenes', 'gestion') )
        ->setPaper('letter')->setOrientation('portrait')
        ->setOption('page-width', '216mm')
        ->setOption('page-height', '279mm')
        ->setOption('margin-right', '10mm')
        ->setOption('margin-left', '14mm')
        ->setOption('margin-bottom', '25mm')
        ->setOption('header-spacing', 15)
        ->setOption('footer-spacing', 1)
        ->setOption('footer-html', asset('pie.php'));

        return $pdf->inline('Codigo4060_Apertura'.date('Ymdhis').'.pdf');
      }catch(\Exception $e){
        return "<script> alert('Error R0008: Reporte de bienes en deshuso \n".$e->getMessage()."'); location.href='".asset('index.php/Reportes')."'; </script>";
      }
    }


    /**
      * Formulario: Reporte de los bienes
      * Link: index.php/Reporte/deshuso | get
     */
    public function catalogoIndex(){
      try{
        $datos = \DB::table('articulos_movimientos')
                                                 ->join('users',                  'articulos_movimientos.id_usuario',          '=', 'users.id')
                                                 ->join('movimientos',            'articulos_movimientos.id_movimiento',       '=', 'movimientos.id')
                                                 ->join('bienes',                 'articulos_movimientos.id_bien',             '=', 'bienes.id')
                                                 ->join('aperturas',              'articulos_movimientos.id_apertura',         '=', 'aperturas.id')
                                                 ->join('clasificadores',         'articulos_movimientos.id_clasificador',     '=', 'clasificadores.id')
                                                 ->join('unidades',               'bienes.id_unidad',                          '=', 'unidades.id')
                                                 ->where('articulos_movimientos.movimiento',                                   '=', 'INGRESO STOCK')
                                                 ->where('articulos_movimientos.cantidad',                                     '>', '0')
                                                 ->where('articulos_movimientos.observacion',                                     '=', '')
                                                 ->where('articulos_movimientos.id_gestion',                                   '=', Gestiones::gestion())
                                                 ->select('users.name',
                                                 'movimientos.fecha as fechaMovimiento','movimientos.id_almacen','movimientos.nro_moviento',
                                                 'articulos_movimientos.observacion', 'articulos_movimientos.cantidad_actual', 'articulos_movimientos.cantidad', 'articulos_movimientos.costo', 'articulos_movimientos.total',  'articulos_movimientos.id_bien',
                                                 'unidades.unidad', 'bienes.bien',
                                                 'aperturas.id as idApertura', 'aperturas.apertura',  'aperturas.codigo as codigoApertura ',
                                                 'clasificadores.clasificador', 'clasificadores.codigo as clasificadorcodigo')
                                                 ->get();
        $configuracion = \DB::table('configuraciones')->first();

        $aperturas = \DB::table('aperturas')->get(); //\App\Aperturas::all();
        /*$aperturas = \DB::table('aperturas')->join('articulos_movimientos', 'aperturas.id', '=', 'articulos_movimientos.id_apertura')
                                            //->where('articulos_movimientos.movimiento', '=', 'INGRESO STOCK')
                                            ->whereIn('articulos_movimientos.movimiento', array('SALIDA STOCK', 'INGRESO STOCK'))
                                            ->groupBy('aperturas.codigo')
                                            ->orderBy('aperturas.codigo')
                                            ->select('aperturas.*')
                                            ->get();*/

        //$bienes = \App\Bienes::all();
        $bienes = \DB::table('bienes')->get(); //\App\Aperturas::all();
        //$almacenes = \App\Almacenes::all();
        $almacenes = \DB::table('almacenes')->get(); //\App\Aperturas::all();
        return view('reporte.catalogo', compact('datos', 'configuracion', 'almacenes', 'bienes', 'aperturas'));
      }catch (Exception $e) {
        return "<script> alert('Error R0009: Formulario: Reporte de los bienes \n".$e->getMessage()."'); location.href='".asset('index.php/Reportes')."'; </script>";
      }
    }


    /**
      * Reporte de los bienes
      * Link: index.php/Reportes/catalogo | post
     */
    public function catalogo(Request $request){
      try{
        $idAlmacen = \App\Almacenes::Where('almacen', '=', $request->id_almacen)->first();
        $almacen  = $request->id_almacen != '' ? "articulos_movimientos.id_almacen = '".$idAlmacen->id."'" : ' 1=1 ' ;
        $bien     = $request->id_bien     != '' ? "articulos_movimientos.id_bien = '".explode('-', $request->id_bien)[0]."'" : ' 1=1 ' ;
        $apertura = $request->id_apertura != '' ? "articulos_movimientos.id_apertura = '".explode('-', $request->id_apertura)[0]."'" : ' 1=1 ' ;

        if($request->button =='stock'){
          $reporteMovimiento = 'INGRESO STOCK';
        }else{
          $reporteMovimiento = 'INGRESO';
        }

        $datos = \DB::table('articulos_movimientos')->join('users',                  'articulos_movimientos.id_usuario',          '=', 'users.id')
                                                 ->join('movimientos',               'articulos_movimientos.id_movimiento',       '=', 'movimientos.id')
                                                 ->join('almacenes',                 'articulos_movimientos.id_almacen',          '=', 'almacenes.id')
                                                 ->join('proveedores',               'movimientos.id_proveedor',                  '=', 'proveedores.id')
                                                 ->join('conceptos',                 'movimientos.id_concepto',                   '=', 'conceptos.id')
                                                 ->join('bienes',                    'articulos_movimientos.id_bien',             '=', 'bienes.id')
                                                 ->join('unidades',                  'bienes.id_unidad',                          '=', 'unidades.id')
                                                 ->join('aperturas',                 'articulos_movimientos.id_apertura',         '=', 'aperturas.id')
                                                 ->join('clasificadores',            'articulos_movimientos.id_clasificador',     '=', 'clasificadores.id')
                                                 //->where('articulos_movimientos.movimiento',                                      '=', 'INGRESO STOCK')
                                                 ->whereIn('articulos_movimientos.movimiento', array('INGRESO STOCK', 'INGRESO') )
                                                 ->where('articulos_movimientos.cantidad',                                        '>', '0')
                                                 ->where('articulos_movimientos.observacion',                                     '=', '')
                                                 ->whereRaw($almacen)
                                                 ->whereRaw($bien)
                                                 ->whereRaw($apertura)
                                                 ->where('articulos_movimientos.created_at',                                      '>', Carbon::parse($request->fecha_inicio) )
                                                 ->orWhere('articulos_movimientos.created_at',                                    '=', Carbon::parse($request->fecha_inicio) )
                                                 ->where('articulos_movimientos.created_at',                                      '<', Carbon::parse($request->fecha_fin) )
                                                 ->orWhere('articulos_movimientos.created_at',                                    '=', Carbon::parse($request->fecha_fin) )
                                                 ->where('articulos_movimientos.id_gestion',                                      '=', Gestiones::gestion())
                                                 ->select('users.name',
                                                 'movimientos.*', 'movimientos.fecha as fechaMovimiento', 'movimientos.nro_moviento',
                                                 'articulos_movimientos.observacion', 'articulos_movimientos.cantidad', 'articulos_movimientos.cantidad_actual', 'articulos_movimientos.costo', 'articulos_movimientos.total',  'articulos_movimientos.id_bien',
                                                 'conceptos.concepto', 'proveedores.proveedor', 'unidades.unidad','almacenes.almacen','bienes.bien', 'bienes.codigo as codBien',
                                                 'aperturas.id as idApertura', 'aperturas.apertura',  'aperturas.codigo as codigoApertura',
                                                 'clasificadores.clasificador', 'clasificadores.codigo as clasificadorcodigo')
                                                 ->orderBy('aperturas.id')
                                                 ->orderBy('bienes.bien')
                                                 ->get();
          $aperturas = \DB::table('articulos_movimientos')
                                                 ->join('aperturas',                 'articulos_movimientos.id_apertura',         '=', 'aperturas.id')
                                                 ->where('articulos_movimientos.movimiento',                                      '=', 'INGRESO STOCK')
                                                 ->where('articulos_movimientos.cantidad',                                        '>', '0')
                                                 ->where('articulos_movimientos.observacion',                                     '=', '')
                                                 ->whereRaw($almacen)
                                                 ->whereRaw($apertura)
                                                 ->where('articulos_movimientos.created_at',                                      '>', Carbon::parse($request->fecha_inicio) )
                                                 ->orWhere('articulos_movimientos.created_at',                                    '=', Carbon::parse($request->fecha_inicio) )
                                                 ->where('articulos_movimientos.created_at',                                      '<', Carbon::parse($request->fecha_fin) )
                                                 ->orWhere('articulos_movimientos.created_at',                                    '=', Carbon::parse($request->fecha_fin) )
                                                 ->where('articulos_movimientos.id_gestion',                                      '=', Gestiones::gestion())
                                                 ->select('aperturas.*')
                                                 ->groupBy('aperturas.id')
                                                 ->orderBy('aperturas.id')
                                                 ->get();
        $fechaInicio =  $request->fecha_inicio;
        $fechaFin    =  $request->fecha_fin;
        $configuracion = \DB::table('configuraciones')->first();
        /*$view =  \View::make('reporte.catalogoReporte', compact('datos', 'configuracion', 'fechaInicio', 'fechaFin') )->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('office', 'landscape');
        $pdf->loadHTML($view);
        return $pdf->stream('Codigo4060_Catalogo.pdf');*/

        $almacen = \DB::table('almacenes')->select('almacen')->first();

        $pdf = \PDF::loadView('reporte.catalogoReporte', compact('datos', 'configuracion', 'fechaInicio', 'fechaFin', 'almacen', 'aperturas', 'reporteMovimiento') )
        ->setPaper('letter')->setOrientation('portrait')
        ->setOption('page-width', '216mm')
        ->setOption('page-height', '279mm')
        ->setOption('margin-right', '10mm')
        ->setOption('margin-left', '15mm')
        ->setOption('margin-bottom', '15mm')
        ->setOption('header-spacing', 15)
        ->setOption('footer-spacing', 1)
        ->setOption('footer-html', asset('pie.php'));

        return $pdf->inline('Codigo4060_Catalogo'.date('Ymdhis').'.pdf');
      }catch (Exception $e) {
        return "<script> alert('Error R0010: Reporte de los bienes \n".$e->getMessage()."'); location.href='".asset('index.php/Reportes')."'; </script>";
      }
    }


    /**
      * Formulario : Reporte de movimientos por bien
      * Link: index.php/Reportes/peps | get
     */
    public function pepsIndex(){
      try{
        $almacenes = \DB::table('almacenes')->get(); //\App\Almacenes::all();
        $almacenes = \DB::table('almacenes')->get(); //\App\Almacenes::all();
        $bienes = \App\Bienes::Where('id_gestion', '=', Gestiones::gestion())->get();

        $datos = \DB::table('articulos_movimientos')->join('users',                  'articulos_movimientos.id_usuario',          '=', 'users.id')
                                                 ->join('movimientos',               'articulos_movimientos.id_movimiento',       '=', 'movimientos.id')
                                                 ->join('almacenes',                 'articulos_movimientos.id_almacen',          '=', 'almacenes.id')
                                                 ->join('proveedores',               'movimientos.id_proveedor',                  '=', 'proveedores.id')
                                                 ->join('conceptos',                 'movimientos.id_concepto',                   '=', 'conceptos.id')
                                                 ->join('bienes',                    'articulos_movimientos.id_bien',             '=', 'bienes.id')
                                                 ->join('unidades',                  'bienes.id_unidad',                          '=', 'unidades.id')
                                                 ->join('aperturas',                 'articulos_movimientos.id_apertura',         '=', 'aperturas.id')
                                                 ->join('clasificadores',            'articulos_movimientos.id_clasificador',     '=', 'clasificadores.id')
                                                 ->where('articulos_movimientos.movimiento',                                      '=', 'INGRESO STOCK')
                                                 ->where('articulos_movimientos.observacion',                                     '=', '')
                                                 ->where('articulos_movimientos.id_gestion',                                      '=',  Gestiones::gestion())
                                                 ->select('users.name',
                                                 'movimientos.*', 'movimientos.fecha as fechaMovimiento',  'movimientos.nro_moviento',
                                                 'articulos_movimientos.observacion', 'articulos_movimientos.cantidad', 'articulos_movimientos.cantidad_actual', 'articulos_movimientos.costo', 'articulos_movimientos.total',  'articulos_movimientos.id_bien', 'articulos_movimientos.*',
                                                 'conceptos.concepto', 'proveedores.proveedor', 'unidades.unidad','almacenes.almacen','bienes.bien', 'bienes.codigo as BienCod',
                                                 'aperturas.id as idApertura', 'aperturas.apertura',  'aperturas.codigo as codigoApertura',
                                                 'clasificadores.clasificador', 'clasificadores.codigo as clasificadorcodigo', 'unidades.unidad')
                                                 ->orderBy('clasificadores.codigo' , 'asc')
                                                 ->orderBy('bienes.codigo' , 'asc')
                                                 ->get();
          $aperturas = \DB::table('articulos_movimientos')
                                                 ->join('aperturas',                 'articulos_movimientos.id_apertura',         '=', 'aperturas.id')
                                                 ->where('articulos_movimientos.movimiento',                                      '=', 'INGRESO STOCK')
                                                 ->where('articulos_movimientos.cantidad',                                        '>', '0')
                                                 ->where('articulos_movimientos.observacion',                                     '=', '')
                                                 ->where('articulos_movimientos.id_gestion',                                      '=',  Gestiones::gestion())
                                                 ->select('aperturas.*')
                                                 ->groupBy('aperturas.id')
                                                 ->orderBy('aperturas.id')
                                                 ->get();


        return view( 'reporte.peps', compact('almacenes', 'bienes', 'datos', 'aperturas') );
      }catch (Exception $e) {
        return "<script> alert('Error R0011: Reporte de movimientos por bien \n".$e->getMessage()."'); location.href='".asset('index.php/Reportes')."'; </script>";
      }
    }

    /**
      * Reporte de movimientos por bien
      * Link: index.php/Reportes/peps | post
     */
    public function peps(Request $request){
      try{
        $idAlmacen = \App\Almacenes::Where('almacen', '=', $request->id_almacen)->first();

        $idBien = \App\Bienes::Where('id_gestion', '=', Gestiones::gestion())->where('bien', '=', $request->id_articulo )->first();
        $bien =  $request->id_articulo  != '' ? "articulos_movimientos.id_bien = '".$idBien->id."'" : ' 1=1 ' ;
        $bett0 = $bien;
        $bienes =  $request->id_articulo  != '' ? "bienes.id = '".$idBien->id."'" : ' 1=1 ' ;

        if($request->button == 'inmediato'){
          $link = "reporte.pepsReporteInmediato";
          $movimiento = " articulos_movimientos.movimiento = 'INGRESO' or articulos_movimientos.movimiento = 'SALIDA'"  ;
        }elseif ($request->button == 'stock'){
          $link = "reporte.pepsReporteStock";
          $movimiento = " articulos_movimientos.movimiento = 'INGRESO STOCK' or articulos_movimientos.movimiento = 'SALIDA STOCK'"  ;
        }elseif ($request->button == 'fisicoValorado'){
          $link = "reporte.pepsReporteFisicoValorado";
        }

        $aperturas = \DB::table('articulos_movimientos')
                                               ->join('aperturas',                 'articulos_movimientos.id_apertura',         '=', 'aperturas.id')
                                               ->where('articulos_movimientos.movimiento',                                      '=', 'INGRESO STOCK')
                                               ->where('articulos_movimientos.observacion',                                     '=', '')
                                               ->where('articulos_movimientos.id_gestion',                                      '=', $request->gestion)
                                               ->select('aperturas.*')
                                               ->groupBy('aperturas.id')
                                               ->orderBy('aperturas.id')
                                               ->get();


        $bienes = \DB::table('bienes')->join('users',                    'bienes.id_usuario',      '=', 'users.id')
                                        ->join('unidades',               'bienes.id_unidad',       '=', 'unidades.id')
                                        ->join('clasificadores',         'bienes.id_clasificador', '=', 'clasificadores.id')
                                        ->join('articulos_movimientos',  'bienes.id',              '=', 'articulos_movimientos.id_bien')
                                        ->whereRaw($bien)
                                        //->whereRaw($movimiento)
                                        ->where('bienes.id_gestion',                               '=', Gestiones::gestion())
                                        ->select('bienes.id as idBien', 'bienes.codigo', 'bienes.bien', 'unidades.unidad', 'users.name',
                                          'clasificadores.codigo as clasificadorCodigo', 'articulos_movimientos.id_almacen', 'articulos_movimientos.movimiento')
                                        ->groupBy('bienes.id')
                                        ->orderBy('bienes.id')
                                        ->get();


        $datos = \DB::table('articulos_movimientos')->join('users',               'articulos_movimientos.id_usuario',     '=', 'users.id')
                                                    ->join('movimientos',         'articulos_movimientos.id_movimiento',  '=', 'movimientos.id')
                                                    ->join('almacenes',           'articulos_movimientos.id_almacen',     '=', 'almacenes.id')
                                                    ->join('conceptos',           'movimientos.id_concepto',              '=', 'conceptos.id')
                                                    ->join('aperturas',           'articulos_movimientos.id_apertura',    '=', 'aperturas.id')
                                                    ->join('clasificadores',      'articulos_movimientos.id_clasificador','=', 'clasificadores.id')
                                                    ->join('bienes',              'articulos_movimientos.id_bien',        '=', 'bienes.id')
                                                    ->whereRaw($bien)
                                                    ->where('articulos_movimientos.eliminacion',             '=', "")
                                                    ->where('articulos_movimientos.observacion',             '=', "")
                                                    ->where('articulos_movimientos.id_almacen',              '=', $idAlmacen->id)
                                                    ->where('movimientos.created_at',                        '>=', Carbon::parse($request->fecha_inicio) )
                                                    ->where('movimientos.created_at',                        '<=', Carbon::parse($request->fecha_fin) )
                                                    ->where('articulos_movimientos.id_gestion',              '=', Gestiones::gestion())
                                                    ->select( 'articulos_movimientos.id', 'articulos_movimientos.*',
                                                    'movimientos.fecha as movimientoFecha', 'movimientos.movimiento as movimientoTipo', 'movimientos.nro_moviento',
                                                    'conceptos.tipo', 'conceptos.concepto',
                                                    'users.name', 'bienes.bien', 'bienes.codigo as bienCodigo',
                                                    'almacenes.*','aperturas.codigo as aperturaCodigo','clasificadores.codigo as clasificadorCodigo')
                                                    ->orderBy('bienes.bien', 'asc')
                                                    ->orderBy('articulos_movimientos.id_bien', 'asc')
                                                    ->orderBy('articulos_movimientos.movimiento', 'asc')
                                                    ->get();

        if ($request->button == 'fisicoValorado'){
        $datos = \DB::table('articulos_movimientos')->join('users',                  'articulos_movimientos.id_usuario',          '=', 'users.id')
                                                 ->join('movimientos',               'articulos_movimientos.id_movimiento',       '=', 'movimientos.id')
                                                 ->join('almacenes',                 'articulos_movimientos.id_almacen',          '=', 'almacenes.id')
                                                 ->join('proveedores',               'movimientos.id_proveedor',                  '=', 'proveedores.id')
                                                 ->join('conceptos',                 'movimientos.id_concepto',                   '=', 'conceptos.id')
                                                 ->join('bienes',                    'articulos_movimientos.id_bien',             '=', 'bienes.id')
                                                 ->join('unidades',                  'bienes.id_unidad',                          '=', 'unidades.id')
                                                 ->join('aperturas',                 'articulos_movimientos.id_apertura',         '=', 'aperturas.id')
                                                 ->join('clasificadores',            'articulos_movimientos.id_clasificador',     '=', 'clasificadores.id')
                                                 ->where('articulos_movimientos.movimiento',                                      '=', 'INGRESO STOCK')
                                                 ->where('articulos_movimientos.observacion',                                     '=', '')
                                                 ->where('articulos_movimientos.id_gestion',                                      '=', $request->gestion)
                                                 ->select('users.name',
                                                 'movimientos.*', 'movimientos.fecha as fechaMovimiento',  'movimientos.nro_moviento',
                                                 'articulos_movimientos.observacion', 'articulos_movimientos.cantidad', 'articulos_movimientos.cantidad_actual', 'articulos_movimientos.costo', 'articulos_movimientos.total',  'articulos_movimientos.id_bien', 'articulos_movimientos.*',
                                                 'conceptos.concepto', 'proveedores.proveedor', 'unidades.unidad','almacenes.almacen','bienes.bien','bienes.codigo as BienCod',
                                                 'aperturas.id as idApertura', 'aperturas.apertura',  'aperturas.codigo as codigoApertura',
                                                 'clasificadores.clasificador', 'clasificadores.codigo as clasificadorcodigo','unidades.unidad')
                                                 ->orderBy('aperturas.id')
                                                 ->orderBy('bienes.bien')
                                                 ->get();
          $aperturas = \DB::table('articulos_movimientos')
                                                 ->join('aperturas',                 'articulos_movimientos.id_apertura',         '=', 'aperturas.id')
                                                 ->where('articulos_movimientos.movimiento',                                      '=', 'INGRESO STOCK')
                                                 ->where('articulos_movimientos.observacion',                                     '=', '')
                                                 ->where('articulos_movimientos.id_gestion',                                      '=', $request->gestion)
                                                 ->select('aperturas.*')
                                                 ->groupBy('aperturas.id')
                                                 ->orderBy('aperturas.id')
                                                 ->get();


        }

        $gestion = \App\Gestiones::find($request->gestion);
        $fechaInicio = $request->fecha_inicio;
        $fechafinal  = $request->fecha_fin;
        $configuracion = \DB::table('configuraciones')->first();
        $almacen = \DB::table('almacenes')->select('almacen')->first();

        return view($link, compact('bienes', 'configuracion', 'fechaInicio', 'fechafinal', 'almacen', 'bett0', 'gestion', 'aperturas', 'datos'));
        
        $pdf = \PDF::loadView($link, compact('bienes', 'configuracion', 'fechaInicio', 'fechafinal', 'almacen', 'bett0', 'gestion', 'aperturas', 'datos') )
        ->setPaper('letter')->setOrientation('portrait')
        ->setOption('page-width', '216mm')
        ->setOption('page-height', '279mm')
        ->setOption('margin-right', '10mm')
        ->setOption('margin-left', '15mm')
        ->setOption('margin-bottom', '15mm')
        ->setOption('header-spacing', 15)
        ->setOption('footer-spacing', 1)
        ->setOption('footer-html', asset('pie.php'));

        return $pdf->inline('Codigo4060_GlovalFisicoValorado'.date('Ymdhis').'.pdf');
      }catch (Exception $e) {
        return "<script> alert('Error R0012: Reporte de movimientos por bien \n".$e->getMessage()."'); location.href='".asset('index.php/Reportes')."'; </script>";
      }
    }


    /**
      * Generacion del Respaldo de base de datos
      * Link: index.php/Reportes/backup | get
     */
    public function backup(){
      try{
        $date = \Carbon\Carbon::now()->toW3cString();
        $exitCode = \Artisan::call('db:backup', [
              '--database'=> 'mysql', '--destination'=>'local', '--destinationPath'=>'sisfa_'.date('YmdHis'), '--compression'=>'null'
        ]);
        \DB::table('log_navegaciones')->delete();
        \DB::table('log_sesiones')->delete();
        return redirect('/');
      }catch (Exception $e) {
        return "<script> alert('Error R0013: Generacion del Respaldo de base de datos \n".$e->getMessage()."'); location.href='".asset('index.php/Reportes')."'; </script>";
      }

    }


    /**
      * Reporte del Cierre de Gestion
      * Link: index.php/Reportes/cierre/{id} | get
     */
    public function cierreGestion($id){
      try{
        $datos = \DB::table('articulos_movimientos')->join('bienes',         'articulos_movimientos.id_bien',         '=', 'bienes.id')
                                                    ->join('movimientos',    'articulos_movimientos.id_movimiento',   '=', 'movimientos.id')
                                                    ->join('clasificadores', 'articulos_movimientos.id_clasificador', '=', 'clasificadores.id')
                                                    ->where('articulos_movimientos.eliminacion', '=', '')
                                                    ->where('articulos_movimientos.movimiento', '=', 'INGRESO STOCK')
                                                    ->where('articulos_movimientos.cerrado_gestion', 'like', explode(' ', $id)[0].'%')
                                                    //->where('id_gestion', '=', Gestiones::gestion()-1)
                                                    ->select('articulos_movimientos.id as idArticuloMoviento', 'articulos_movimientos.*', 'movimientos.fecha','movimientos.nro_moviento',
                                                    'bienes.*', 'bienes.codigo as codigoBien', 'clasificadores.codigo', 'clasificadores.clasificador')
                                                    ->orderBy('movimientos.nro_moviento')
                                                    ->get();
        //return $datos;
        $clasificadores = \DB::table('clasificadores')->where('id_gestion', '=', Gestiones::gestion())->get();
        $articulosMovimientos = \DB::table('movimientos')->where('cerrado_gestion', 'like', '%'.explode(' ', $id)[0].'%')->where('movimiento','=', 'INGRESO STOCK')  ->orderBy('movimientos.nro_moviento')->get();
        $movimientos = \DB::table('movimientos')->where('cerrado_gestion', 'like', '%'.$id.'%')->where('movimiento','=', 'INGRESO STOCK')->orderBy('movimientos.nro_moviento')->get();

        $ufv = \DB::table('cambios')->where('fecha', '=', $articulosMovimientos[0]->fecha )->first();
        $ufv = \DB::table('cambios')->orderBy('id', 'desc')->first();
        $ufvFinal = $ufv->ufv;
        $fechaFinal = $ufv->fecha;
        $configuracion = \DB::table('configuraciones')->first();

        //return view('reporte.cierreGestion', compact('datos', 'ufvFinal',  'fechaFinal', 'configuracion', 'clasificadores', 'movimientos'));

         $pdf = \PDF::loadView('reporte.cierreGestion', compact('datos', 'ufvFinal',  'fechaFinal', 'configuracion', 'clasificadores', 'movimientos'))
         ->setPaper('letter')->setOrientation('landscape')->setOption('margin-bottom', 0);
         return $pdf->inline('Codigo4060CierreGestion'.date('Ymdhis').'.pdf');
      }catch (Exception $e) {
        return "<script> alert('Error R0014: Reporte del Cierre de Gestion  \n".$e->getMessage()."'); location.href='".asset('index.php/Reportes')."'; </script>";
      }
    }


    /**
      * Formulario de Cierre de Gestion
      * Link: index.php/Reportes/gestion | get
     */
    public function gestion(Request $request){
      $gestion = "";
      $bett0 = "";
      try{
        if( !isset($request->gestion) ){
          $datos = \DB::table('movimientos')->join('users', 'movimientos.id_usuario', '=', 'users.id')
                                          ->where('movimientos.deleted_at', '=', NULL)
                                          ->where('movimientos.cerrado_gestion', '=', 'NO')
                                          ->where('id_gestion', '=', Gestiones::gestion())
                                          ->select('movimientos.*', 'users.name as username')
                                          ->get();
        }else{
          $bett0 = "Bett0";
          $gestion = Gestiones::find($request->gestion);
          $datos = \DB::table('movimientos')->join('users', 'movimientos.id_usuario', '=', 'users.id')
                                          ->where('movimientos.deleted_at', '=', NULL)
                                          ->where('movimientos.id_gestion', '=', $request->gestion)
                                          ->select('movimientos.*', 'users.name as username')
                                          ->get();
        }
        return view('reporte.gestion', compact('datos', 'gestion', 'bett0'));
      }catch (Exception $e) {
        return "<script> alert('Error R0015: Formulario de Cierre de Gestion \n".$e->getMessage()."'); location.href='".asset('index.php/Reportes')."'; </script>";
      }
    }


        /**
         * Formulario: Reporte de bienes por clasificadores Stock/Inmediato
         * Link: index.php/Reportes/clasificador | get
         */
        public function clasificadorIndex(){
          try{
            $datos = \DB::table('articulos_movimientos')->join('clasificadores',  'articulos_movimientos.id_clasificador', '=', 'clasificadores.id')
                                                        ->join('bienes',          'articulos_movimientos.id_bien',         '=', 'bienes.id')
                                                        ->join('movimientos',     'articulos_movimientos.id_movimiento',   '=', 'movimientos.id')
                                                        ->join('unidades',        'bienes.id_unidad',                      '=', 'unidades.id')
                                                        ->where('articulos_movimientos.id_gestion',                        '=', Gestiones::gestion())
                                                        ->select('clasificadores.codigo as codigoClasificador', 'clasificadores.*',
                                                         'bienes.codigo as codigoBien', 'bienes.*', 'unidades.*', 'articulos_movimientos.*', 'movimientos.fecha', 'movimientos.nro_moviento')
                                                         ->orderBy('clasificadores.codigo')
                                                        ->get();
            //$almacenes = \App\Almacenes::all();
            $almacenes   = \DB::table('almacenes')->get();

            $clasificadores = \App\Clasificadores::Where('id_gestion', '=', Gestiones::gestion())->get();
            return view( 'reporte.clasificador', compact('datos', 'almacenes', 'clasificadores') );
          }catch (Exception $e) {
            return "<script> alert('Error R0016: Formulario: Reporte de bienes por clasificadores Stock/Inmediato \n".$e->getMessage()."'); location.href='".asset('index.php/Reportes')."'; </script>";
          }
        }

        /**
        * Reporte de bienes por clasificadores Stock/Inmediato
        * Link: index.php/Reportes/clasificador | post
         */
        public function clasificador(Request $request){
          try{
            $idAlmacen = \App\Almacenes::Where('almacen', '=', $request->id_almacen)->first();
            $idClasificador = \App\Clasificadores::where('codigo', '=', explode('-', $request->id_clasificador)[0] )->where('id_gestion', '=', Gestiones::gestion())->first();

            $clasificador = $request->id_clasificador != '' ? "articulos_movimientos.id_clasificador = '".$idClasificador->id."'" : ' 1=1 ' ;

            $datos = \DB::table('articulos_movimientos')->join('users',              'articulos_movimientos.id_usuario',      '=', 'users.id')
                                                        ->join('movimientos',        'articulos_movimientos.id_movimiento',   '=', 'movimientos.id')
                                                        ->join('almacenes',          'articulos_movimientos.id_almacen',      '=', 'almacenes.id')
                                                        ->join('conceptos',          'movimientos.id_concepto',               '=', 'conceptos.id')
                                                        ->join('bienes',             'articulos_movimientos.id_bien',         '=', 'bienes.id')
                                                        ->join('unidades',           'bienes.id_unidad',                      '=', 'unidades.id')
                                                        ->join('aperturas',          'articulos_movimientos.id_apertura',     '=', 'aperturas.id')
                                                        ->join('clasificadores',     'articulos_movimientos.id_clasificador', '=', 'clasificadores.id')
                                                        ->whereRaw($clasificador)
                                                        ->where('articulos_movimientos.id_almacen',     '=', $idAlmacen->id )
                                                        ->where('articulos_movimientos.eliminacion',    '=', '' )
                                                        ->where('articulos_movimientos.created_at',     '>', Carbon::parse($request->fecha_inicio) )
                                                        ->orWhere('articulos_movimientos.created_at',   '=', Carbon::parse($request->fecha_inicio) )
                                                        ->where('articulos_movimientos.created_at',     '<', Carbon::parse($request->fecha_fin) )
                                                        ->orWhere('articulos_movimientos.created_at',   '=', Carbon::parse($request->fecha_fin) )
                                                        ->where('articulos_movimientos.id_gestion',     '=', Gestiones::gestion())
                                                        ->select('articulos_movimientos.id', 'articulos_movimientos.*',
                                                        'movimientos.fecha as movimientoFecha', 'movimientos.movimiento as movimientoTipo', 'movimientos.nro_moviento',
                                                        'conceptos.tipo', 'conceptos.concepto',
                                                        'users.name', 'bienes.bien', 'bienes.codigo as bienCodigo',
                                                        'aperturas.codigo as aperturaCodigo',
                                                        'clasificadores.codigo as clasificadorCodigo')
                                                        ->orderBy('clasificadores.id')
                                                        ->orderBy('bienes.bien', 'asc')
                                                        ->orderBy('articulos_movimientos.id_bien', 'asc')
                                                        ->orderBy('articulos_movimientos.movimiento', 'asc')
                                                        ->get();

            $clasificadores = \DB::table('clasificadores')->join('articulos_movimientos', 'clasificadores.id',                  '=', 'articulos_movimientos.id_clasificador')
                                                        ->join('bienes',                'articulos_movimientos.id_bien',        '=', 'bienes.id')
                                                        ->join('movimientos',           'articulos_movimientos.id_movimiento',  '=', 'movimientos.id')
                                                        ->whereRaw($clasificador)
                                                        ->where('articulos_movimientos.id_almacen',     '=', $idAlmacen->id )
                                                        ->where('articulos_movimientos.eliminacion',    '=', '')
                                                        ->where('articulos_movimientos.created_at',     '>', Carbon::parse($request->fecha_inicio) )
                                                        ->orWhere('articulos_movimientos.created_at',   '=', Carbon::parse($request->fecha_inicio) )
                                                        ->where('articulos_movimientos.created_at',     '<', Carbon::parse($request->fecha_fin) )
                                                        ->orWhere('articulos_movimientos.created_at',   '=', Carbon::parse($request->fecha_fin) )
                                                        ->where('articulos_movimientos.created_at',     '=', Gestiones::gestion() )
                                                        ->select('clasificadores.id', 'clasificadores.codigo', 'clasificadores.clasificador', 'bienes.bien')
                                                        ->orderBy('articulos_movimientos.id_clasificador')
                                                        ->groupBy('clasificadores.id')
                                                        ->orderBy('clasificadores.id')
                                                        ->get();
            $fechaInicio =  $request->fecha_inicio;
            $fechaFin    =  $request->fecha_fin;
            $apertura = $request->id_apertura;
            $configuracion = \DB::table('configuraciones')->first();
            $almacen = \DB::table('almacenes')->select('almacen')->first();
            /*$view =  \View::make('reporte.aperturaReporte', compact('datos', 'configuracion', 'bienes', 'aperturas', 'fechaInicio', 'fechaInicio', 'fechaFin'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->setPaper('office', 'landscape');
            $pdf->loadHTML($view);
            return $pdf->stream('Codigo4060_Apertura.pdf');*/
            if($request->button == 'pdfStock'){
              $link = "reporte.clasificadorReporteStock";
            }elseif ($request->button == 'pdfInmediato'){
              $link = "reporte.clasificadorReporteIn";
            }
            $pdf = \PDF::loadView($link, compact('datos', 'clasificadores',  'configuracion', 'fechaInicio', 'fechaFin', 'almacen') )
            //->setPaper('letter')->setOrientation('landscape')
            ->setPaper('letter')->setOrientation('portrait')
            ->setOption('page-width', '216mm')
            ->setOption('page-height', '279mm')
            ->setOption('margin-right', '10mm')
            ->setOption('margin-left', '15mm')
            ->setOption('margin-bottom', '15mm')
            ->setOption('header-spacing', 15)
            ->setOption('footer-spacing', 1)
            ->setOption('footer-html', asset('pie.php'));

            return $pdf->inline('Clasificadores_'.date('Ymdhis').'.pdf');
          }catch (Exception $e) {
            return "<script> alert('Error R0017: Reporte de movimientos por Aperturas \n".$e->getMessage()."'); location.href='".asset('index.php/Reportes')."'; </script>";
          }
        }


        /**
         * Formulario: Reporte de Unidad Administrativa
         * Link: index.php/Reportes/funcionario | get
         */
        public function estructuraIndex(){
          try{
            $datos = \DB::table('articulos_movimientos')->join('aperturas',       'articulos_movimientos.id_apertura',     '=', 'aperturas.id')
                                                        ->join('clasificadores',  'articulos_movimientos.id_clasificador', '=', 'clasificadores.id')
                                                        ->join('bienes',          'articulos_movimientos.id_bien',         '=', 'bienes.id')
                                                        ->join('movimientos',     'articulos_movimientos.id_movimiento',   '=', 'movimientos.id')
                                                        ->join('unidades',        'bienes.id_unidad',                      '=', 'unidades.id')
                                                        ->join('funcionarios',    'movimientos.id_funcionario',            '=', 'funcionarios.id')
                                                        ->join('estructuras',     'funcionarios.id_estructura',            '=', 'estructuras.id')
                                                        ->where('articulos_movimientos.id_gestion',                        '=', Gestiones::gestion())
                                                        ->where('articulos_movimientos.movimiento',                        '=', 'SALIDA')
                                                        ->orWhere('articulos_movimientos.movimiento', '=', 'SALIDA STOCK')
                                                        ->select(
                                                                'aperturas.codigo as codigoApertura', 'aperturas.*',
                                                                'articulos_movimientos.created_at as fechaM', 'articulos_movimientos.*',
                                                                'clasificadores.codigo as codigoClasificador',
                                                                'clasificadores.*', 'estructuras.estructura', 'estructuras.codigoEstructura',
                                                                'bienes.codigo as codigoBien', 'bienes.*',
                                                                'unidades.*',  'funcionarios.*', 'movimientos.fecha'
                                                                )->get();
            $estructuras = \App\Estructuras::Where('id_gestion', '=', Gestiones::gestion())->get();
            //$almacenes    = \App\Almacenes::all();
            $almacenes   = \DB::table('almacenes')->get();
            return view( 'reporte.estructura', compact('datos', 'estructuras', 'almacenes') );
          }catch (Exception $e) {
            return "<script> alert('Error R0018: Formulario: Reporte de Unidad Administrativa \n".$e->getMessage()."'); location.href='".asset('index.php/Reportes')."'; </script>";
          }
        }

        /**
        * Reporte de Unidad Administrativa Global|Resumen
        * Link: index.php/Reportes/funcionario | post
         */
        public function estructura(Request $request){
          try{
            $idAlmacen = \App\Almacenes::Where('almacen', '=', $request->id_almacen)->first();
            $estructura   = $request->id_estructura == '' ? ' 1=1 ' : " estructuras.id = '".trim(explode('-', $request->id_estructura)[0])."'" ;

            if($request->button == 'resumen'){
              $link = 'reporte.estructuraReporteResumen';
              $datos = \DB::table('articulos_movimientos')->join('users',                  'articulos_movimientos.id_usuario',          '=', 'users.id')
                                                     ->join('movimientos',               'articulos_movimientos.id_movimiento',       '=', 'movimientos.id')
                                                     ->join('almacenes',                 'articulos_movimientos.id_almacen',          '=', 'almacenes.id')
                                                     ->join('aperturas',                 'articulos_movimientos.id_apertura',         '=', 'aperturas.id')
                                                     ->join('clasificadores',            'articulos_movimientos.id_clasificador',     '=', 'clasificadores.id')
                                                     ->join('funcionarios',              'movimientos.id_funcionario',                '=', 'funcionarios.id')
                                                     ->join('proveedores',               'movimientos.id_proveedor',                  '=', 'proveedores.id')
                                                     ->join('conceptos',                 'movimientos.id_concepto',                   '=', 'conceptos.id')
                                                     ->join('bienes',                    'articulos_movimientos.id_bien',             '=', 'bienes.id')
                                                     ->join('unidades',                  'bienes.id_unidad',                          '=', 'unidades.id')
                                                     ->join('estructuras',               'funcionarios.id_estructura',                '=', 'estructuras.id')
                                                     ->where('articulos_movimientos.cantidad',      '>', '0')
                                                     ->where('articulos_movimientos.observacion',   '=', '')
                                                     ->where('movimientos.id_gestion',              '=', Gestiones::gestion())
                                                     ->where('movimientos.id_almacen',              '=', $idAlmacen->id)
                                                     ->where('articulos_movimientos.created_at',    '>=', Carbon::parse($request->fecha_inicio) )
                                                     ->where('articulos_movimientos.created_at',    '<=', Carbon::parse($request->fecha_fin) )
                                                     ->where('articulos_movimientos.movimiento',    '=', 'SALIDA' )
                                                     ->orWhere('articulos_movimientos.movimiento',    '=', 'SALIDA STOCK' )
                                                     ->select('users.name',
                                                      'estructuras.id', 'estructuras.estructura', 'estructuras.codigoEstructura',
                                                      \DB::raw('sum(articulos_movimientos.cantidad) as cantidad') ,
                                                      \DB::raw('sum(articulos_movimientos.total) as total')
                                                      )
                                                     ->groupBy('estructuras.id')
                                                     ->orderBy('estructuras.id')
                                                     ->get();
            }else{
              $link = 'reporte.estructuraReporte';
              $datos = \DB::table('articulos_movimientos')->join('users',                  'articulos_movimientos.id_usuario',          '=', 'users.id')
                                                     ->join('movimientos',               'articulos_movimientos.id_movimiento',       '=', 'movimientos.id')
                                                     ->join('almacenes',                 'articulos_movimientos.id_almacen',          '=', 'almacenes.id')
                                                     ->join('aperturas',                 'articulos_movimientos.id_apertura',         '=', 'aperturas.id')
                                                     ->join('clasificadores',            'articulos_movimientos.id_clasificador',     '=', 'clasificadores.id')
                                                     ->join('funcionarios',              'movimientos.id_funcionario',                '=', 'funcionarios.id')
                                                     ->join('proveedores',               'movimientos.id_proveedor',                  '=', 'proveedores.id')
                                                     ->join('conceptos',                 'movimientos.id_concepto',                   '=', 'conceptos.id')
                                                     ->join('bienes',                    'articulos_movimientos.id_bien',             '=', 'bienes.id')
                                                     ->join('unidades',                  'bienes.id_unidad',                          '=', 'unidades.id')
                                                     ->join('estructuras',               'funcionarios.id_estructura',                '=', 'estructuras.id')
                                                     ->whereRaw($estructura)
                                                     ->where('articulos_movimientos.cantidad',      '>', '0')
                                                     ->where('articulos_movimientos.observacion',   '=', '')
                                                     ->where('movimientos.id_gestion',              '=', Gestiones::gestion())
                                                     ->where('movimientos.id_almacen',              '=', $idAlmacen->id)
                                                     ->where('articulos_movimientos.created_at',    '>=', Carbon::parse($request->fecha_inicio) )
                                                     ->where('articulos_movimientos.created_at',    '<=', Carbon::parse($request->fecha_fin) )
                                                     ->whereIn('articulos_movimientos.movimiento', array('SALIDA', 'SALIDA STOCK') )
                                                     ->select('users.name','movimientos.*', 'conceptos.concepto', 'proveedores.proveedor',
                                                      'articulos_movimientos.observacion', 'articulos_movimientos.cantidad', 'articulos_movimientos.cantidad_actual', 'articulos_movimientos.costo',
                                                      'articulos_movimientos.total',  'articulos_movimientos.id_bien', 'movimientos.fecha as fechaMovimiento',
                                                      'unidades.unidad',
                                                      'funcionarios.id as idFuncionario', 'funcionarios.nombres', 'funcionarios.paterno', 'funcionarios.materno',
                                                      'estructuras.id','estructuras.estructura','estructuras.codigoEstructura',
                                                      'almacenes.*',
                                                      'bienes.bien',
                                                      'unidades.unidad',
                                                      'aperturas.apertura',  'aperturas.codigo as aperturacodigo',
                                                      'clasificadores.clasificador', 'clasificadores.codigo as clasificadorcodigo')
                                                     ->orderBy('estructuras.id')
                                                     ->orderBy('bienes.bien')
                                                     ->get();
            }
            $fechaInicio =  $request->fecha_inicio;
            $fechaFin    =  $request->fecha_fin;
            $configuracion = \DB::table('configuraciones')->first();
            $almacen = \DB::table('almacenes')->select('almacen')->first();

            $pdf = \PDF::loadView($link, compact('datos', 'configuracion', 'almacen','fechaInicio', 'fechaFin') )
            ->setPaper('letter')->setOrientation('landscape')
            //->setPaper('letter')->setOrientation('portrait')
            ->setOption('page-width', '216mm')
            ->setOption('page-height', '279mm')
            ->setOption('margin-right', '10mm')
            ->setOption('margin-left', '14mm')
            ->setOption('margin-bottom', '15mm')
            ->setOption('header-spacing', 15)
            ->setOption('footer-spacing', 1)
            ->setOption('footer-html', asset('pie.php'));

            return $pdf->inline('UnidadAdministrativa_'.date('Ymdhis').'.pdf');
          }catch (Exception $e) {
            return "<script> alert('Error R0019: Reporte de Unidad Administrativa Global|Resumen \n".$e->getMessage()."'); location.href='".asset('index.php/Reportes')."'; </script>";
          }
        }


        public function automovilIndex(){
          try{
            $datos = \DB::table('movimientos')->join('autos',       'movimientos.rupe',     '=', 'autos.id')
                                              ->where('movimientos.id_gestion',   '=', Gestiones::gestion())
                                              ->where('movimientos.eliminacion',  '=', '')
                                              ->whereIn('movimientos.movimiento',   array('INGRESO','INGRESO STOCK') )
                                              ->where('movimientos.rupe', '!=', null )
                                              ->select('movimientos.*', 'autos.*')
                                              ->orderBy('autos.placa', 'asc')
                                              ->get();
            $autos = \App\Auto::all();
            $almacenes   = \DB::table('almacenes')->get();
            return view( 'reporte.automovil', compact('datos', 'autos', 'almacenes') );
          }catch (Exception $e) {
            return "<script> alert('Error R0020: Formulario: Reporte por Combustible \n".$e->getMessage()."'); location.href='".asset('index.php/Reportes')."'; </script>";
          }
        }

        public function automovil(Request $request){
          try{
            $idAlmacen = \App\Almacenes::Where('almacen', '=', $request->id_almacen)->first();
            $proveedor   = $request->id_proveedor == '' ? ' 1=1 ' : " autos.id = '".trim(explode('-', $request->id_proveedor)[0])."'" ;
            $link = 'reporte.proveedorReporte';
            $datos = \DB::table('movimientos')->join('autos',       'movimientos.rupe',     '=', 'autos.id')
                                              ->whereIn('movimientos.movimiento',   array('INGRESO','INGRESO STOCK') )
                                              ->where('movimientos.id_gestion',   '=', Gestiones::gestion())
                                              ->where('movimientos.eliminacion',  '=', '')
                                              ->where('movimientos.id_almacen',   '=', $idAlmacen->id)
                                              ->where('movimientos.created_at',   '>=', Carbon::parse($request->fecha_inicio) )
                                              ->where('movimientos.created_at',   '<=', Carbon::parse($request->fecha_fin) )
                                              ->whereRaw($proveedor)
                                              ->select('movimientos.*', 'autos.*')
                                              ->orderBy('autos.placa', 'asc')
                                              ->get();
            $fechaInicio =  $request->fecha_inicio;
            $fechaFin    =  $request->fecha_fin;
            $configuracion = \DB::table('configuraciones')->first();
            $almacen = \DB::table('almacenes')->select('almacen')->first();

            $pdf = \PDF::loadView($link, compact('datos', 'configuracion', 'almacen','fechaInicio', 'fechaFin') )
            ->setPaper('letter')->setOrientation('landscape')
            ->setOption('page-width', '216mm')
            ->setOption('page-height', '279mm')
            ->setOption('margin-right', '10mm')
            ->setOption('margin-left', '15mm')
            ->setOption('margin-bottom', '15mm')
            ->setOption('header-spacing', 15)
            ->setOption('footer-spacing', 1)
            ->setOption('footer-html', asset('pie.php'));

            return $pdf->inline('UnidadAdministrativa_'.date('Ymdhis').'.pdf');
          }catch (Exception $e) {
            return "<script> alert('Error R0019: Reporte de Unidad Administrativa Global|Resumen \n".$e->getMessage()."'); location.href='".asset('index.php/Reportes')."'; </script>";
          }
        }


        /**
        * Formulario: Reporte por proveedores
        * Link: index.php/Reportes/funcionario | get
        */
        public function proveedorIndex(){
                  try{
                    $datos = \DB::table('movimientos')->join('proveedores',       'movimientos.id_proveedor',     '=', 'proveedores.id')
                                                      ->where('movimientos.id_gestion',   '=', Gestiones::gestion())
                                                      ->where('movimientos.eliminacion',  '=', '')
                                                      ->whereIn('movimientos.movimiento',   array('INGRESO','INGRESO STOCK') )
                                                      ->select('movimientos.*', 'proveedores.*')
                                                      ->orderBy('proveedores.proveedor', 'asc')
                                                      ->get();
                    $proveedores = \App\Proveedores::Where('id_gestion', '=', Gestiones::gestion())->get();
                    //$almacenes    = \App\Almacenes::all();
                    $almacenes   = \DB::table('almacenes')->get();
                    return view( 'reporte.proveedor', compact('datos', 'proveedores', 'almacenes') );
                  }catch (Exception $e) {
                    return "<script> alert('Error R0020: Formulario: Reporte por proveedores \n".$e->getMessage()."'); location.href='".asset('index.php/Reportes')."'; </script>";
                  }
                }

                /**
                * Reporte por proveedores
                * Link: index.php/Reportes/funcionario | post
                 */
                public function proveedor(Request $request){
                  try{
                    $idAlmacen = \App\Almacenes::Where('almacen', '=', $request->id_almacen)->first();
                    $proveedor   = $request->id_proveedor == '' ? ' 1=1 ' : " proveedores.id = '".trim(explode('-', $request->id_proveedor)[0])."'" ;
                    $link = 'reporte.proveedorReporte';
                    $datos = \DB::table('movimientos')->join('proveedores',       'movimientos.id_proveedor',     '=', 'proveedores.id')
                                                      ->whereIn('movimientos.movimiento',   array('INGRESO','INGRESO STOCK') )
                                                      ->where('movimientos.id_gestion',   '=', Gestiones::gestion())
                                                      ->where('movimientos.eliminacion',  '=', '')
                                                      ->where('movimientos.id_almacen',   '=', $idAlmacen->id)
                                                      ->where('movimientos.created_at',   '>=', Carbon::parse($request->fecha_inicio) )
                                                      ->where('movimientos.created_at',   '<=', Carbon::parse($request->fecha_fin) )
                                                      ->whereRaw($proveedor)
                                                      ->select('movimientos.*', 'proveedores.*')
                                                      ->orderBy('proveedores.proveedor', 'asc')
                                                      ->get();
                    $fechaInicio =  $request->fecha_inicio;
                    $fechaFin    =  $request->fecha_fin;
                    $configuracion = \DB::table('configuraciones')->first();
                    $almacen = \DB::table('almacenes')->select('almacen')->first();

                    $pdf = \PDF::loadView($link, compact('datos', 'configuracion', 'almacen','fechaInicio', 'fechaFin') )
                    ->setPaper('letter')->setOrientation('landscape')
                    //->setPaper('letter')->setOrientation('portrait')
                    ->setOption('page-width', '216mm')
                    ->setOption('page-height', '279mm')
                    ->setOption('margin-right', '10mm')
                    ->setOption('margin-left', '15mm')
                    ->setOption('margin-bottom', '15mm')
                    ->setOption('header-spacing', 15)
                    ->setOption('footer-spacing', 1)
                    ->setOption('footer-html', asset('pie.php'));

                    return $pdf->inline('UnidadAdministrativa_'.date('Ymdhis').'.pdf');
                  }catch (Exception $e) {
                    return "<script> alert('Error R0019: Reporte de Unidad Administrativa Global|Resumen \n".$e->getMessage()."'); location.href='".asset('index.php/Reportes')."'; </script>";
                  }
                }

}
