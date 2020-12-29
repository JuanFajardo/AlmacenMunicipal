<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Http\Controllers;
use App\Http\Requests;
use App\Movimientos;
use App\ArticulosMovimientos;
use App\Cambios;
use Carbon\Carbon;
use App\Gestiones;


class CierreGestionController extends Controller
{
  public function __construct(){
    $this->middleware('cors');
    $this->middleware('auth');

    if( \Auth::guest() )
      return redirect('index.php/login');
    elseif(\Auth::user()->grupo != 2 && \Auth::user()->grupo != 3)
      return abort(503);
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

  public function index(){
    $datos = \DB::table('movimientos')->where('cerrado_gestion', '!=', 'NO')->groupBy('cerrado_gestion')->get();
    $dato = Cambios::where('fecha', '=', date('Y-m-d'))->count();
    return view('cierregestion.index', compact('datos', 'dato'));
  }

  public function create(Request $request){
    $fecha_inicio = $request->fecha_inicio;
    $numero = \DB::table('cambios')->where('fecha', '=', $fecha_inicio)->count();
    $fecha_fin = $request->fecha_fin;
    if($numero > 0){
      $fecha1 = ""; $fecha2 = "";
    }else{
      $numero = \DB::table('cambios')->where('fecha', '<', Carbon::parse($fecha_inicio) )->get();
      $fecha1 = $numero[0]->fecha;
      $numero = \DB::table('cambios')->where('fecha', '>', Carbon::parse($fecha_inicio) )->get();
      $fecha2 = $numero[0]->fecha;
    }
    return view('cierregestion.create', compact('fecha_inicio', 'fecha_fin', 'fecha1', 'fecha2'));
  }

  public function store(Request $request){
    /*/////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////
    $estructurasTabla = array();
    $estructuras = \App\Estructuras::Where('id_gestion', '=', Gestiones::gestion() )->get();
    foreach ($estructuras as $estructura) {
      $estructurasTabla[] = ['id'=>$estructura->id, 'codigoEstructura'=>$estructura->codigoEstructura, 'estructura'=>$estructura->estructura, 'id_estructura'=>$estructura->id_estructura, 'id_usuario'=>\Auth::user()->id, 'id_gestion'=>'1' ];
    }

    $conceptosTabla = array();
    $conceptos = \App\Conceptos::Where('id_gestion', '=', Gestiones::gestion() )->get();
    foreach ($conceptos as $concepto) {
      $conceptosTabla[] = ['id'=>$concepto->id, 'tipo'=>$concepto->tipo, 'concepto'=>$concepto->concepto, 'id_usuario'=>\Auth::user()->id, 'id_gestion'=>'1'];
    }

    $funcionariosTabla = array();
    $funcionarios = \App\Funcionarios::Where('id_gestion', '=', Gestiones::gestion())->get();
    foreach ($funcionarios as $funcionario) {
      $funcionariosTabla[] = ['id'=>$funcionario->id, 'fech_nacimiento'=>$funcionario->fech_nacimiento, 'nombres'=>$funcionario->nombres, 'paterno'=>$funcionario->paterno, 'materno'=>$funcionario->materno, 'ci'=>$funcionario->ci, 'telefono'=>$funcionario->telefono, 'zona'=>$funcionario->zona, 'direccion'=>$funcionario->direccion, 'id_estructura'=>$funcionario->id_estructura, 'id_usuario'=>\Auth::user()->id, 'id_gestion'=>'1'];
    }

    $clasificadoresTabla = array();
    $clasificadores = \App\Clasificadores::Where('id_gestion', '=', Gestiones::gestion() )->get();
    foreach ($clasificadores as $clasificador) {
      $clasificadoresTabla[] = ['id'=>$clasificador->id, 'id_clasificador'=>'0', 'codigo'=>$clasificador->codigo, 'clasificador'=>$clasificador->clasificador, 'descripcion'=>$clasificador->descripcion, 'id_usuario'=>\Auth::user()->id, 'id_gestion'=>'1'];
    }

    $aperturasTabla = array();
    $aperturas = \App\Aperturas::Where('id_gestion', '=', Gestiones::gestion())->get();
    foreach ($aperturas as $apertura) {
      $aperturasTabla[] = ['id'=>$apertura->id, 'codigo'=>$apertura->codigo, 'apertura'=>$apertura->apertura, 'id_usuario'=>\Auth::user()->id, 'id_gestion'=>'1'];
    }

    $proveedoresTabla = array();
    $proveedores = \App\Proveedores::Where('id_gestion', '=', Gestiones::gestion())->get();
    foreach ($proveedores as $proveedores) {
      $proveedoresTabla[] = ['id'=>$proveedores->id, 'proveedor'=>$proveedores->proveedor, 'rubro'=>$proveedores->rubro, 'entidad'=>$proveedores->entidad, 'responsable'=>$proveedores->responsable, 'ciudad'=>$proveedores->ciudad, 'direccion'=>$proveedores->direccion, 'telefono'=>$proveedores->telefono, 'correo_electronico'=>$proveedores->correo_electronico, 'nit'=>$proveedores->nit, 'id_usuario'=>\Auth::user()->id, 'id_gestion'=>'1'];
    }

    $unidadesTabla = array();
    $unidades = \App\Unidades::Where('id_gestion', '=', Gestiones::gestion())->get();
    foreach ($unidades as $unidad) {
      $unidadesTabla = ['id'=>$unidad->id, 'unidad'=>$unidad->unidad, 'id_usuario'=>\Auth::user()->id, 'id_gestion'=>'1'];
    }

    $bienesTabla = array();
    $bienes = \App\Bienes::Where('id_gestion', '=', Gestiones::gestion())->get();
    foreach ($bienes as $bien) {
      $bienesTabla = ['id'=>$bien->id, 'codigo'=>$bien->codigo, 'bien'=>$bien->bien, 'id_unidad'=>$bien->id_unidad, 'id_clasificador'=>$bien->id_clasificador, 'id_almacen'=>$bien->id_almacen, 'id_usuario'=>\Auth::user()->id, 'id_gestion'=>'1'];
    }
    /////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////
    */

    $array    = array();
    $sumaTotal= 0;
    $ufv      = \DB::table('cambios')->orderBy('id', 'desc')->first();
    $ufvFinal = $ufv->ufv;
    $idMovimiento = \DB::table('movimientos')->max('id');
    $idMovimiento = $idMovimiento+1;

    $movimientos = \DB::table('movimientos')->where('movimientos.created_at', '>', Carbon::parse($request->fecha_inicio) )
                                            ->where('movimientos.created_at', '<', Carbon::parse($request->fecha_fin) )
                                            ->where('movimientos.cerrado_gestion', '=', 'NO' )
                                            ->where('movimientos.eliminacion', '=', '' )
                                            ->get();

    foreach ($movimientos as $movimiento ) {
      $articulos = \DB::table('articulos_movimientos')->where('id_movimiento', '=',  $movimiento->id)->get();

      foreach($articulos as $articulo){
        $ufv = \DB::table('cambios')->where('fecha', '=', $movimiento->fecha)->first();
        $ufvInicio = $ufv->ufv;
        $costo = ($ufvFinal/$ufvInicio) * $articulo->costo;
        $total = $articulo->cantidad * $costo;
        //$sumaTotal = $sumaTotal + $total;

        if($articulo->cantidad > 0 && $articulo->movimiento == "INGRESO STOCK"){
          $sumaTotal = $sumaTotal + $total;
          $array[] = array( 'cantidad'=>$articulo->cantidad,
                            'cantidad_actual'=>$articulo->cantidad,
                            'costo'=>$costo,
                            'total'=>$total,
                            'costo_actual'=>$articulo->costo_actual,
                            'total_actual'=>$articulo->total_actual,
                            'observacion'=>$articulo->observacion,
                            'id_movimiento'=>$movimiento->id,
                            'id_apertura' =>$articulo->id_apertura,
                            'id_clasificador' =>$articulo->id_clasificador ,
                            'id_bien'=>$articulo->id_bien,
                            'id_usuario'=>\Auth::user()->id, 'movimiento'=>$articulo->movimiento);
        }
        $cambio = ArticulosMovimientos::find($articulo->id);
        $cambio->cerrado_gestion = "SI|".date('Y-m-d');
        $cambio->save();
      }
      $cambio = Movimientos::find($movimiento->id);
      $cambio->cerrado_gestion = "SI|".date('Y-m-d');
      $cambio->save();
    }

    $id_ufv  = Cambios::where('fecha', '=', date('Y-m-d'))->max('id');
    $gestion = Gestiones::gestion() + 1;

    $conceptosCont   = \DB::table('conceptos')->max('id');
    $proveedoresCont = \DB::table('proveedores')->max('id');

    $dato = new Movimientos;
    $fechas = explode('-', date('Y-m-d'));
    $dato->movimiento      = 'INGRESO STOCK';
    $dato->nro_moviento    = '1';
    $dato->fecha           = date('Y-m-d');
    $dato->anio            = $fechas[0];
    $dato->mes             = $fechas[1];
    $dato->dia             = $fechas[2];
    $dato->cerrado_gestion = 'NO';
    $dato->rupe            = '';
    $dato->codigo_pedido   = '1';
    $dato->codigo_pedido   = '1';
    $dato->codigo_informe  = '1';
    $dato->codigo_pedido   = '1';
    $dato->codigo_tramite  = '1';
    $dato->auxiliar        = 'SI';
    $dato->orden_compra    = '';
    $dato->glosa_entrada   = 'Cierre de Gestion en fecha - '.date('Y-m-d H:i:s');
    $dato->glosa_salida    = '';
    $dato->motivo          = '';
    $dato->tipo_factura    = 'Cierre';
    $dato->numero_factura  = '0';
    $dato->total_factura   = $sumaTotal;
    $dato->otro_documento  = '';
    $dato->id_cambio       = $id_ufv;
    $dato->id_almacen      = 1; //\Auth::user()->id_almacen;
    $dato->id_concepto     = $conceptosCont   + 1;
    $dato->id_proveedor    = $proveedoresCont + 1;
    $dato->id_funcionario  = '0';
    $dato->movimiento_ingreso   = '';
    $dato->id_usuario      = \Auth::user()->id;
    $dato->eliminacion     = '';
    $dato->fecha_eliminacion = '0000-00-00';
    $dato->id_gestion      = $gestion;
    $dato->save();


    $idMovimiento = \DB::table('movimientos')->max('id');
    for($i=0; $i<count($array); $i++){
      $articulo = new ArticulosMovimientos;
      $articulo->movimiento     = $array[$i]['movimiento'];
      $articulo->cerrado_gestion= 'NO';
      $articulo->cantidad       = $array[$i]['cantidad'];
      $articulo->cantidad_actual= $array[$i]['cantidad'];
      $articulo->costo          = $array[$i]['costo'];
      $articulo->total          = $array[$i]['total'];
      $articulo->costo_actual   = $array[$i]['costo_actual'];
      $articulo->total_actual   = $array[$i]['total_actual'];
      $articulo->observacion    = $array[$i]['observacion'];
      $articulo->id_movimiento  = $idMovimiento;

      $articulo->id_apertura    = $array[$i]['id_apertura']     ;//+ $aperturasCont;
      $articulo->id_clasificador= $array[$i]['id_clasificador'] ;//+ $clasificadoresCont;
      $articulo->id_bien        = $array[$i]['id_bien']         ;//+ $bienesCont;

      $articulo->id_usuario     = \Auth::user()->id;;
      $articulo->eliminacion    = '';
      $articulo->fecha_eliminacion  = '0000-00-00';
      $articulo->id_gestion     = $gestion;
      $articulo->save();
    }

    $gestion = new Gestiones;
    $gestion->gestion = date('Y')+1;
    $gestion->save();

    return redirect('CierreGestion');
  }


  public function cambiarGet(){
    $link   = '../config/DB/bds.txt';
    $archivo= fopen($link, 'r');
    $leer   = fread($archivo, filesize($link));
    fclose($archivo);
    $leer   = explode("\n", $leer);
    $gestiones = array();
    foreach ($leer as $db) {
      $gestiones[] = array( "gestion" => trim($db, "\r") );
    }
    return view('cierregestion.cambiar', compact('gestiones') );
  }

  public function cambiarPost(Request $request){
    $dsn = $request->DB_CONNECTION.':dbname='.$request->DB_DATABASE.';host='.$request->DB_HOST;
    $user = $request->DB_USERNAME;
    $password = $request->DB_PASSWORD;

    try {
        $dbh = new \PDO($dsn, $user, $password);

        $conexion = "<?php ";
        $conexion = $conexion . "return ['fetch' => PDO::FETCH_CLASS, 'default' => env('DB_CONNECTION', '".$request->DB_CONNECTION."'), ";
        $conexion = $conexion . "'connections' => [ ";
        $conexion = $conexion . "'mysql' => [ ";
        $conexion = $conexion . "'driver' => 'mysql', ";
        $conexion = $conexion . "'host' => '".$request->DB_HOST."', ";
        $conexion = $conexion . "'port' => '".$request->DB_PORT."', ";
        $conexion = $conexion . "'database' => '".$request->DB_DATABASE."', ";
        $conexion = $conexion . "'username' => '".$request->DB_USERNAME."', ";
        $conexion = $conexion . "'password' => '".$request->DB_PASSWORD."', ";
        $conexion = $conexion . "'charset' => 'utf8', ";
        $conexion = $conexion . "'collation' => 'utf8_unicode_ci', ";
        $conexion = $conexion . "'prefix' => '', ";
        $conexion = $conexion . "'strict' => false, ";
        $conexion = $conexion . "'engine' => null, ";
        $conexion = $conexion . "], ";
        $conexion = $conexion . "'pgsql' => [ ";
        $conexion = $conexion . "'driver' => 'pgsql', ";
        $conexion = $conexion . "'host' => '".$request->DB_HOST."', ";
        $conexion = $conexion . "'port' => '".$request->DB_PORT."', ";
        $conexion = $conexion . "'database' => '".$request->DB_DATABASE."', ";
        $conexion = $conexion . "'username' => '".$request->DB_USERNAME."', ";
        $conexion = $conexion . "'password' => '".$request->DB_PASSWORD."', ";
        $conexion = $conexion . "'charset' => 'utf8', ";
        $conexion = $conexion . "'prefix' => '', ";
        $conexion = $conexion . "'schema' => 'public', ";
        $conexion = $conexion . "], ";
        $conexion = $conexion . "], ";
        $conexion = $conexion . "'migrations' => 'migrations', ";
        $conexion = $conexion . "'redis' => [ ";
        $conexion = $conexion . "'cluster' => false, ";
        $conexion = $conexion . "'default' => [ ";
        $conexion = $conexion . "'host' => env('REDIS_HOST', 'localhost'), ";
        $conexion = $conexion . "'password' => env('REDIS_PASSWORD', null), ";
        $conexion = $conexion . "'port' => env('REDIS_PORT', 6379), ";
        $conexion = $conexion . "'database' => 0, ";
        $conexion = $conexion . "], ";
        $conexion = $conexion . "], ";
        $conexion = $conexion . "]; ";

        $archivo = fopen('../config/database.php', 'w');
        fwrite($archivo, $conexion);
        fclose($archivo);
        //return view('instalador.dos');
        $db = $request->DB_DATABASE;
        return view('cierregestion.mostrar', compact('db'));
    } catch (\PDOException $e) {
        return back()->withErrors(['Uno de los datos de conexion es INCORRECTO Intente nuevamente.']);
    }
  }

}
