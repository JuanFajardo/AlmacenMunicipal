<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Http\Controllers;
use App\Http\Requests;
use App\Movimientos;
use App\Funcionarios;
use App\ArticulosMovimientos;
use App\Cambios;
use App\Conceptos;
use App\Almacenes;
use App\Bienes;
use Carbon\Carbon;
use App\Gestiones;

class MovimientosController extends Controller
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

  public function find(Route $route){
    $this->data = Movimientos::find($route->getParameter('Movimientos') );
  }

  /**
   * Listado de los movimientos
   * Menu: Movimeintos -> Gestion Actual
   * Link: index.php/Movimientos
   */
  public function index(){
    try{
      $datos = \DB::table('movimientos')->join('users', 'movimientos.id_usuario', '=', 'users.id')
                                        ->where('movimientos.cerrado_gestion', '=', 'NO')
                                        ->where('movimientos.deleted_at', '=', NULL)
                                        ->where('id_gestion', '=', Gestiones::gestion() )
                                        ->select('movimientos.*', 'users.name as username')->get();
      return view('movimiento.index', compact('datos'));
    }catch (Exception $e) {
      return "<script> alert('Error M0001: Mal listado de informacion \n".$e->getMessage()."'); location.href='".asset('index.php/Movimientos')."'; </script>";
    }
  }

  /**
   * Confirmacion del movimento cuando es auxiliar
   * Menu:
   * Link: index.php/Movimiento/confirmar/{id}
   */
  public function confirmar($id){
    try{
      $dato = Movimientos::find($id);
      $numero = explode('/', $dato->nro_moviento);
      $dato->nro_moviento =  $numero[1];
      $dato->auxiliar =  'SI';
      $dato->save();
      return redirect('Movimientos');
    }catch (Exception $e) {
        return "<script> alert('Error M0002: No se confirmo adecuadamente \n".$e->getMessage()."'); location.href='".asset('index.php/Movimientos')."'; </script>";
    }

  }

  /**
  * Formulario para registrar la cantidad de aperturas que se tendra el ingreso, y el tipo de movivimeinto: Ingreso (Inmediado), Ingreso Stock (Stock)
  * Menu: Ingresar a almacen -> Ingresar
  * Link: index.php/Movimiento/nuevo
 */
  public function nuevo(){
    try{
      $dato = Cambios::where('fecha', '=', date('Y-m-d'))->count();
      return view('movimiento.nuevo', compact('dato'));
    }catch (Exception $e) {
      return "<script> alert('Error M0003: No se inicio movimiento nuevo \n".$e->getMessage()."'); location.href='".asset('index.php/Movimientos')."'; </script>";
    }
  }


  /**
  * Formulario para el ingreso Inmediato/Stock
  * Menu:
  * Link: index.php/Movimiento/create
 */
  public function create(Request $request){
    try{
      $movimiento =  $request->movimento;
      $nro =  $request->nro_moviento;
      $i = 0;
      if($movimiento == "1"){
        $movimiento = "INGRESO";
        $concepto = "Entrada";
      }elseif($movimiento == "2"){
        $movimiento = "INGRESO STOCK";
        $concepto = "Entrada";
      }elseif($movimiento == "3"){
        $movimiento = "SALIDA STOCK";
        $concepto = "Salida";
      }else{
        $movimiento = false;
      }

      if($movimiento == "INGRESO"){
        $nro_moviento = \DB::table('movimientos')->where('id_gestion', '=', Gestiones::gestion())->where('movimiento', '=', 'INGRESO')->where('cerrado_gestion', '=', 'NO')->count('nro_moviento');
      }elseif ($movimiento == "SALIDA") {
        $nro_moviento = \DB::table('movimientos')->where('id_gestion', '=', Gestiones::gestion())->where('movimiento', '=', 'SALIDA')->where('cerrado_gestion', '=', 'NO')->count('nro_moviento');
      }elseif ($movimiento == "INGRESO STOCK") {
        $nro_moviento = \DB::table('movimientos')->where('id_gestion', '=', Gestiones::gestion())->where('movimiento', '=', 'INGRESO STOCK')->where('cerrado_gestion', '=', 'NO')->count('nro_moviento');
      }elseif ($movimiento == "SALIDA STOCK") {
        $nro_moviento = \DB::table('movimientos')->where('id_gestion', '=', Gestiones::gestion())->where('movimiento', '=', 'SALIDA STOCK')->where('cerrado_gestion', '=', 'NO')->count ('nro_moviento');
      }

      $nro_moviento = $nro_moviento +1;

      $conceptos   = \DB::table('conceptos')->where('tipo', '=', $concepto)->where('id_gestion', '=', Gestiones::gestion())->get();
      $proveedores = \DB::table('proveedores')->where('id_gestion', '=', Gestiones::gestion())->get();
      $bienes = \DB::table('bienes')->where('id_gestion', '=', Gestiones::gestion())->get();

      $clasificadores =  \DB::table('clasificadores')->get(); //\App\Clasificador::all();
      $aperturas =  \DB::table('aperturas')->get(); //\App\Aperturas::all();

      if($movimiento){
        return view('movimiento.create', compact('movimiento','nro_moviento', 'nro', 'conceptos', 'proveedores', 'i', 'bienes', 'clasificadores', 'aperturas') );
      }else{
        return redirect('Movimiento');
      }
    }catch (Exception $e) {
      return "<script> alert('Error M0004: No se creo el formulario de Movimiento \n".$e->getMessage()."'); location.href='".asset('index.php/Movimientos')."'; </script>";
    }
  }


  /**
  * Listado de articulosMovimientos segun el id del Moviento respuesta JSON para
  * Menu:
  * Link: Movimientos/{id}/articulo
 */
  public function articulosShow($id){
    try{
      $datos = \DB::table('articulos_movimientos')->where('id_movimiento', '=', $id)
                                                  ->where('cerrado_gestion', '=', 'NO')
                                                  ->where('eliminacion', '=', '')
                                                  ->where('id_gestion', '=', Gestiones::gestion())
                                                  ->get();
      return response()->json($datos);
    }catch (Exception $e){
      return "<script> alert('Error M0005: No se visualiza los Movimientos de los Articulos \n".$e->getMessage()."'); location.href='".asset('index.php/Movimientos')."'; </script>";
    }
  }


  /**
  * Ver el bien segun su ID
  * Menu:
  * Link:
 */
  protected function codigoClasificador($dato){
    try{
      $codigo = Bienes::find($dato);
      return $codigo->id_clasificador;
    }catch (Exception $e) {
      return "<script> alert('Error M0006: No se visualiza el Codigo del Clasificador \n".$e->getMessage()."'); location.href='".asset('index.php/Movimientos')."'; </script>";
    }
  }


  /**
  * Creacion del formulario para la Salida Inmenidata
  * Menu:
  * Link: index.php/Movimientos/{id}/salir
  */
  public function salir($id){
    try{
      $verificar = Movimientos::find($id);

      if($verificar->auxiliar == "NO")
        return redirect('Movimientos');

      $nro_moviento = \DB::table('movimientos')->where('movimiento', '=', 'SALIDA')->where('cerrado_gestion', '=', 'NO')->count('nro_moviento');
      $nro_moviento = $nro_moviento + 1;

      $movimientos = \DB::table('movimientos')->join('proveedores',               'movimientos.id_proveedor',              '=', 'proveedores.id')
                                              ->join('conceptos',                 'movimientos.id_concepto',               '=', 'conceptos.id')
                                              ->where('movimientos.id', '=', $id)
                                              ->where('movimientos.cerrado_gestion', '=', 'NO')
                                              ->where('movimientos.eliminacion', '=', '')
                                              ->where('movimientos.id_gestion', '=', Gestiones::gestion() )
                                              ->select('movimientos.id as idMovimiento' , 'movimientos.*', 'conceptos.*', 'proveedores.*')
                                              ->get();

      $articulosmovimientos = \DB::table('articulos_movimientos')
                                               ->join('users',                  'articulos_movimientos.id_usuario',      '=', 'users.id')
                                               ->join('bienes',                 'articulos_movimientos.id_bien',         '=', 'bienes.id')
                                               ->join('unidades',               'bienes.id_unidad',                      '=', 'unidades.id')

                                               ->join('aperturas',              'articulos_movimientos.id_apertura',     '=', 'aperturas.id')
                                               ->join('clasificadores',         'articulos_movimientos.id_clasificador', '=', 'clasificadores.id')

                                               ->where('articulos_movimientos.id_movimiento',   '=', $id)
                                               ->where('articulos_movimientos.cerrado_gestion', '=', 'NO')
                                               ->where('articulos_movimientos.eliminacion',     '=', '')
                                               ->where('articulos_movimientos.id_gestion',      '=', Gestiones::gestion() )
                                               ->select( 'unidades.*','articulos_movimientos.*','bienes.*', 'bienes.codigo as codigoBien',
                                               'aperturas.*', 'aperturas.codigo as codigoApertura','clasificadores.*', 'clasificadores.codigo as codigoClasificador')
                                               ->get();

      $clasificadoresMovimientos = \DB::table('clasificadores')->join('articulos_movimientos', 'clasificadores.id', '=', 'articulos_movimientos.id_clasificador')
                                                    ->where('articulos_movimientos.id_movimiento', '=', $id)
                                                    ->select('clasificadores.*')->groupBy('clasificadores.id')->orderBy('clasificadores.id')->get();

      $aperturasMovimientos = \DB::table('aperturas')->join('articulos_movimientos', 'aperturas.id', '=', 'articulos_movimientos.id_apertura')
                                                  ->where('articulos_movimientos.id_movimiento', '=', $id)
                                                  ->select('aperturas.*')->groupBy('aperturas.id')->orderBy('aperturas.id')->get();

      $funcionarios = \DB::table('funcionarios')->join('estructuras', 'funcionarios.id_estructura', '=', 'estructuras.id') //Funcionarios::
                                                ->where('funcionarios.id_gestion', '=', Gestiones::gestion() )->select('funcionarios.*', 'estructuras.estructura')->get();
      $conceptos = Conceptos::Where('id_gestion', '=', Gestiones::gestion())->where('tipo', '=', 'Salida')->get();

      //return view('movimiento.salir', compact('aperturasMovimientos', 'clasificadoresMovimientos', 'funcionarios', 'conceptos', 'movimientos', 'articulosmovimientos', 'nro_moviento', 'calsificadorBienes'));
      return view('movimiento.salir', compact('aperturasMovimientos', 'clasificadoresMovimientos', 'funcionarios', 'conceptos', 'movimientos', 'articulosmovimientos', 'nro_moviento'));
    }catch (Exception $e) {
      return "<script> alert('Error M0008: Error de lo datos a cargar \n".$e->getMessage()."'); location.href='".asset('index.php/Movimientos')."'; </script>";
    }
  }


  /**
  * Guardado de datos de salida Inmediata
  * Menu:
  * Link:index.php/Movimientos/salir
 */
  public function salirStore(Request $request){
    try{
      $movimiento    = $request->movimiento;
      $id_movimiento = $request->id_movimiento;
      $id_usuario = \Auth::user()->id;
      $id_concepto  = Conceptos::where('id_gestion', '=', Gestiones::gestion())->where('concepto', '=', trim($request->id_concepto) )->first();
      $id_funcionario = explode(',', $request->id_funcionario);
      $id_funcionario = $id_funcionario[0];
      $id_funcionario = Funcionarios::find($id_funcionario);
      $key = Movimientos::find($id_movimiento);
      $dato = new Movimientos;
      $dato->movimiento       = $movimiento;
      $dato->nro_moviento     = \Auth::user()->grupo == '2' ? $key->nro_moviento : date('Ymd').'/'.$key->nro_moviento;
      $dato->fecha            = $key->fecha;
      $dato->anio             = $key->anio;
      $dato->mes              = $key->mes;
      $dato->dia              = $key->dia;
      $dato->cerrado_gestion  = 'NO';
      $dato->codigo_pedido    = $key->codigo_pedido;
      $dato->codigo_informe   = $key->codigo_informe;
      $dato->orden_compra     = $key->orden_compra;
      $dato->codigo_tramite   = $key->codigo_tramite;
      $dato->auxiliar         = \Auth::user()->grupo == '2' ? 'SI' : 'NO' ;
      $dato->rupe             = $key->rupe;
      $dato->orden_compra     = $key->orden_compra;
      $dato->glosa_entrada    = '';
      $dato->glosa_salida     = $request->glosa_salida;
      $dato->motivo           = 'salio';
      $dato->tipo_factura     = $key->tipo_factura;
      $dato->numero_factura   = $key->numero_factura;
      $dato->total_factura    = $key->total_factura;
      $dato->otro_documento   = $key->otro_documento;
      $dato->id_almacen       = $key->id_almacen;
      $dato->id_cambio        = $key->id;
      $dato->id_concepto      = $id_concepto->id;
      $dato->id_proveedor     = $key->id_proveedor;
      $dato->id_funcionario   = $id_funcionario->id;
      $dato->movimiento_ingreso = $id_movimiento;
      $dato->id_usuario       = $id_usuario;
      $dato->eliminacion      = '';
      $dato->fecha_eliminacion  = '0000-00-00';
      $dato->id_gestion       = Gestiones::gestion();
      $dato->save();

      $key->motivo            = 'salio';
      $key->save();

      $nro_movimiento = \DB::table('movimientos')->max('id');
      $articulos_movimientos = ArticulosMovimientos::where('id_movimiento', '=', $id_movimiento)->get();
      foreach ($articulos_movimientos as $key) {
        $dato = new ArticulosMovimientos;
        $dato->movimiento       = $movimiento;
        $dato->cantidad         = $key->cantidad;
        $dato->cantidad_actual  = $key->cantidad;
        $dato->cerrado_gestion  = 'NO';
        $dato->costo            = $key->costo;
        $dato->total            = $key->total;
        $dato->costo_actual     = $key->costo_actual;
        $dato->total_actual     = $key->total_actual;
        $dato->observacion      = $key->observacion;
        $dato->id_movimiento    = $nro_movimiento;
        $dato->id_apertura      = $key->id_apertura;
        $dato->id_clasificador  = $this->codigoClasificador($key->id_bien);
        $dato->id_bien          = $key->id_bien;
        $dato->id_usuario       = $id_usuario;
        $dato->id_almacen       = \Auth::user()->id_almacen;
        $dato->eliminacion      = '';
        $dato->fecha_eliminacion  = '0000-00-00';
        $dato->id_gestion       = Gestiones::gestion();
        $dato->save();
      }

      return redirect('Reportes/mostrar/'.$nro_movimiento);
    }catch (Exception $e) {
      return "<script> alert('Error M0007: Error al ingreso de la salida Inmediata  \n".$e->getMessage()."'); location.href='".asset('index.php/Movimientos')."'; </script>";
    }
  }


  /**
  * Formulario para el conteo de aperturas programaticas de una Salida Stock
  * Menu: Salida de almacen ->  Stock
  * Link: index.php/Movimiento/salidaStock | get
  */
  public function salidaStockNuevo(){
    try{
      $dato = Cambios::where('fecha', '=', date('Y-m-d'))->count();
      return view('movimiento.nuevoSalida', compact('dato') );
    }catch(\Exception $err){
      return "<script> alert('Error M0009: No se creo el formulario de Aperturas de Salida Stock \n".$e->getMessage()."'); location.href='".asset('index.php/Movimientos')."'; </script>";
    }
  }

  /**
  * Formulario para Salida Stock
  * Menu:
  * Link: index.php/Movimiento/salidaStock | post
 */
  public function salidaStock(Request $request){
    try{
      $n = isset($request->nro_moviento) ? $request->nro_moviento : 1;
      $nro_moviento = \DB::table('movimientos')
                    ->where('movimiento', '=', 'SALIDA STOCK')
                    ->where('cerrado_gestion', '=', 'NO')
                    ->count('nro_moviento');
      $nro_moviento = $nro_moviento + 1;
      $moviento = "SALIDA STOCK";
      $conceptos = Conceptos::Where('id_gestion', '=', Gestiones::gestion())->where('tipo', '=', 'Salida')->get();
      $funcionarios = \DB::table('funcionarios')->join('estructuras', 'funcionarios.id_estructura', '=', 'estructuras.id')
                                                ->where('funcionarios.id_gestion', '=', Gestiones::gestion() )->select('funcionarios.*', 'estructuras.estructura')->get();
      $aperturas = \DB::table('aperturas')->join('articulos_movimientos', 'aperturas.id', '=', 'articulos_movimientos.id_apertura')
                                          ->where('articulos_movimientos.movimiento', '=', 'INGRESO STOCK')
                                          ->select('aperturas.*')
                                          ->orderBy('aperturas.id')
                                          ->groupBy('aperturas.id')
                                          ->get();
      return view('movimiento.salirStock', compact('nro_moviento', 'moviento', 'conceptos', 'funcionarios', 'n', 'aperturas'));
    }catch(\Exception $err){
      return "<script> alert('Error M0010: No se creo el formulario de Salida Stock \n".$e->getMessage()."'); location.href='".asset('index.php/Movimientos')."'; </script>";
    }
  }

    /**
    * Guardad de los datos de Salida Stock
    * Menu:
    * Link: index.php/Movimiento/salidaStockS | post
   */
  public function salidaStockStore(Request $request){
    try{
      $codigo_pedido = \DB::table('movimientos')->where('movimiento', '=', 'SALIDA STOCK')
                                                ->where('cerrado_gestion', '=', 'NO')
                                                ->where('id_gestion', '=', Gestiones::gestion())
                                                ->count();
      $codigo_pedido = $codigo_pedido + 1;
      $concepto = explode('|', $request->id_concepto);
      $id_concepto = Conceptos::find($concepto[0]);
      $glosa_salida = $request->glosa_salida;
      $nombreCompleto = explode('|', $request->id_funcionario);
      $id_funcionario = Funcionarios::find($nombreCompleto[0]);
      $id_ufv = Cambios::where('fecha', '=', $request->fecha)->max('id');

      $dato = new Movimientos;
      $fechas = explode('-', $request->fecha);
      $dato->movimiento         = 'SALIDA STOCK';
      $dato->nro_moviento       = \Auth::user()->grupo == '2' ? $codigo_pedido : date('Ymd').'/'.$codigo_pedido;
      $dato->fecha              = $request->fecha;
      $dato->anio               = $fechas[0];
      $dato->mes                = $fechas[1];
      $dato->dia                = $fechas[2];
      $dato->cerrado_gestion    = 'NO';
      $dato->codigo_informe     = $request->codigo_informe;
      $dato->codigo_pedido      = $request->codigo_pedido;
      $dato->codigo_tramite     = $request->codigo_tramite;
      $dato->auxiliar           = \Auth::user()->grupo == '2' ? 'SI' : 'NO';;
      $dato->rupe               = "";
      $dato->orden_compra       = "";
      $dato->glosa_entrada      = "";
      $dato->glosa_salida       = $glosa_salida;
      $dato->motivo             = "";
      $dato->tipo_factura       = "";
      $dato->numero_factura     = "";
      $dato->total_factura      = "";
      $dato->otro_documento     = "";
      $dato->eliminacion        = "";
      $dato->fecha_eliminacion  = "";
      $dato->id_almacen         = \Auth::user()->id_almacen;
      $dato->id_cambio          = $id_ufv;
      $dato->id_concepto        = $id_concepto->id;
      $dato->id_proveedor       = 1;
      $dato->id_funcionario     = $id_funcionario->id;
      $dato->movimiento_ingreso = "";
      $dato->id_usuario         = \Auth::user()->id;
      $dato->eliminacion        = '';
      $dato->fecha_eliminacion  = '0000-00-00';
      $dato->id_gestion         = Gestiones::gestion();
      $dato->save();

      $idMovimiento = \DB::table('movimientos')->max('id');

      for($i=1; $i <= $request->n; $i++ ){
        $articulos = explode(',', $request['bien_'.$i]);
        $id_apertura = $request['id_apertura'.$i];
        $id_clasificador = $request['id_clasificador'.$i];
        $id_clasificador = explode(',', $id_clasificador);
        for($j = 0; $j < count($articulos) - 1; $j++){
          $articulo = $articulos[$j];
          $articulo = explode('|', $articulo);
          $canti = trim( $articulo[0] );
          $costo = trim( $articulo[1] );
          $total = trim( $articulo[2] );
          $idart = trim( $articulo[3] );
          $cantidad = $canti;
          do{
            $busqueda = "";
            $clasificador = "";
            foreach ($id_clasificador as $id_clasi) {
              $busqueda = \DB::table('articulos_movimientos')
                                              ->where('movimiento', '=', 'INGRESO STOCK')
                                              ->where('cantidad',        '>', '0')
                                              ->where('cerrado_gestion', '=', 'NO')
                                              ->where('id_apertura',     '=', $id_apertura)
                                              ->where('id_clasificador', '=', $id_clasi)
                                              //->whereRaw("id_clasificador in (".$id_clasificador.")") // 1,2,5,4
                                              ->where('eliminacion',     '=', '')
                                              ->where('id_bien',         '=', $idart)
                                              //->where('id_gestion',      '=', Gestiones::gestion())
                                              ->orderBy('created_at')
                                              ->get();

              if( count($busqueda) > 0){
                  $clasificador = $id_clasi;
                  break;
              }
            }

            $aux = 0;
            if( floatval($cantidad - $busqueda[0]->cantidad) <= 0 ){
              $aux = $canti;
              $cantidad = 0;
            }elseif( floatval($cantidad - $busqueda[0]->cantidad) > 0 ){
              $cantidad = $canti - $busqueda[0]->cantidad;
              $aux      = $canti - $cantidad;
              $canti = $cantidad;
            }

            $dato = new ArticulosMovimientos;
            $dato->movimiento       = 'SALIDA STOCK';
            $dato->cantidad         = $aux;
            $dato->cantidad_actual  = $busqueda[0]->cantidad;
            $dato->cerrado_gestion  = 'NO';
            $dato->costo            = $busqueda[0]->costo;
            $dato->total            = ($aux * $busqueda[0]->costo);
            $dato->costo_actual     = $busqueda[0]->costo;
            $dato->total_actual     = ($aux * $busqueda[0]->costo);
            $dato->observacion      = '';
            $dato->id_movimiento    = $idMovimiento;
            $dato->id_apertura      = $id_apertura;
            $dato->id_clasificador  = $clasificador;
            $dato->id_bien          = $idart;
            $dato->id_usuario       = \Auth::user()->id;
            $dato->id_almacen       = \Auth::user()->id_almacen;
            $dato->eliminacion        = '';
            $dato->fecha_eliminacion  = '0000-00-00';
            $dato->id_gestion       = Gestiones::gestion();
            $dato->save();

            $otro = ArticulosMovimientos::find( $busqueda[0]->id );

            $otro->cantidad = $otro->cantidad - $aux;
            $otro->save();
          }while( $cantidad > 0 );

        }
      }
      return redirect('Reportes/mostrar/'.$idMovimiento);
    }catch (Exception $e) {
      return "<script> alert('Error M0011: Error al guardar dats de Salida Stock".$e->getMessage()."'); location.href='".asset('index.php/Movimientos')."'; </script>";
    }
  }


  public function editar($id){
    $movimientos  = \DB::table('movimientos')->join('users',                    'movimientos.id_usuario',    '=', 'users.id')
                                             ->join('proveedores',               'movimientos.id_proveedor',  '=', 'proveedores.id')
                                             ->join('conceptos',                 'movimientos.id_concepto',   '=', 'conceptos.id')
                                             ->where('movimientos.id', '=', $id)
                                             ->where('movimientos.id_gestion', '=', Gestiones::gestion() )
                                             ->where('movimientos.cerrado_gestion', '=', 'NO')
                                             ->select('movimientos.id as IdM','movimientos.*','users.name','users.nombreCompleto','users.ci','users.grupo','proveedores.*','conceptos.*')
  ->first();
  $funcionarios = \DB::table('funcionarios')->join('estructuras',               'funcionarios.id_estructura',         '=', 'estructuras.id')
                                            ->join('movimientos', 'movimientos.id_funcionario','=', 'funcionarios.id')
                                            ->where('funcionarios.id_gestion', '=', Gestiones::gestion())
                                            ->where('movimientos.id', '=', $id)
                                            ->select('funcionarios.id as idFuncionario', 'funcionarios.*', 'estructuras.*')
  ->get();
  $clasificadores = \DB::table('clasificadores')->join('articulos_movimientos', 'clasificadores.id', '=', 'articulos_movimientos.id_clasificador')
                                                ->where('articulos_movimientos.id_movimiento', '=', $id)
                                                ->select('clasificadores.*')->groupBy('clasificadores.id')->orderBy('clasificadores.id')->get();

  $aperturas = \DB::table('aperturas')->join('articulos_movimientos', 'aperturas.id', '=', 'articulos_movimientos.id_apertura')
                                              ->where('articulos_movimientos.id_movimiento', '=', $id)
                                              ->select('aperturas.*')->groupBy('aperturas.id')->orderBy('aperturas.id')->get();

  $conceptos    = Conceptos::Where('id_gestion', '=', Gestiones::gestion())->where('tipo', '=', 'Salida')->get();


  return view('movimiento.edit', compact(  'movimientos',   'funcionarios', 'aperturas', 'clasificadores'));

  }

  public function actualizar(Request $request, $id){
    //return $request->all();
    $movimiento = Movimientos::find($id);
    $movimiento->codigo_pedido	= $request->codigo_pedido;
    $movimiento->codigo_informe	= $request->codigo_informe;
    $movimiento->orden_compra	  = $request->orden_compra;
    $movimiento->rupe	          = $request->rupe;
    $movimiento->otro_documento	= $request->otro_documento;
    $movimiento->codigo_tramite	= $request->codigo_tramite;
    $movimiento->tipo_factura	  = $request->tipo_factura;
    $movimiento->numero_factura	= $request->numero_factura;

    $movimiento->save();
    return redirect('/Movimientos/'.$id.'/edit');
  }

  /**
  * Visualizacion de los movimientos INGRESO, SALIDA, INMEDIATA, STOCK
  * Menu:
  * Link: index.php/Movimientos/{id} | get
 */
  public function show($id){
    return $id;

    try{
      $movimientos  = \DB::table('movimientos')->join('users',                    'movimientos.id_usuario',    '=', 'users.id')
                                               ->join('proveedores',               'movimientos.id_proveedor',  '=', 'proveedores.id')
                                               ->join('conceptos',                 'movimientos.id_concepto',   '=', 'conceptos.id')
                                               ->where('movimientos.id', '=', $id)
                                               //->where('movimientos.id_gestion', '=', Gestiones::gestion() )
                                               //->where('movimientos.cerrado_gestion', '=', 'NO')
                                               ->select('movimientos.id as IdM','movimientos.*','users.name','users.nombreCompleto','users.ci','users.grupo','proveedores.*','conceptos.*')
                                               ->get();
      $movimientos = $movimientos[0];
      $articulosmovimientos = \DB::table('articulos_movimientos')
                                               ->join('users',                  'articulos_movimientos.id_usuario',      '=', 'users.id')
                                               ->join('bienes',                 'articulos_movimientos.id_bien',         '=', 'bienes.id')
                                               ->join('unidades',               'bienes.id_unidad',                      '=', 'unidades.id')
                                               ->join('aperturas',              'articulos_movimientos.id_apertura',     '=', 'aperturas.id')
                                               ->join('clasificadores',         'articulos_movimientos.id_clasificador', '=', 'clasificadores.id')
                                               ->where('articulos_movimientos.id_movimiento', '=', $id)
                                               //->where('articulos_movimientos.cerrado_gestion', '=', 'NO')
                                               //->where('articulos_movimientos.id_gestion', '=', Gestiones::gestion() )
                                               ->select('clasificadores.codigo as codigoClasificador', 'clasificadores.clasificador','aperturas.codigo as codigoApertura','aperturas.apertura', 'bienes.codigo as codigoBien',
                                                  'bienes.bien','unidades.unidad','articulos_movimientos.id_almacen', 'articulos_movimientos.cantidad', 'articulos_movimientos.costo', 'articulos_movimientos.total', 'articulos_movimientos.cantidad_actual')
                                               ->orderBy('clasificadores.codigo' , 'asc')
                                               ->orderBy('bienes.codigo' , 'asc')
                                               ->get();
      //return $articulosmovimientos;
      $clasificadores = \DB::table('clasificadores')->join('articulos_movimientos', 'clasificadores.id', '=', 'articulos_movimientos.id_clasificador')
                                                    ->where('articulos_movimientos.id_movimiento', '=', $id)
                                                    ->select('clasificadores.*')->groupBy('clasificadores.id')->orderBy('clasificadores.id')->get();

      $aperturas = \DB::table('aperturas')->join('articulos_movimientos', 'aperturas.id', '=', 'articulos_movimientos.id_apertura')
                                                  ->where('articulos_movimientos.id_movimiento', '=', $id)
                                                  ->select('aperturas.*')->groupBy('aperturas.id')->orderBy('aperturas.id')->get();

      $conceptos    = Conceptos::Where('id_gestion', '=', Gestiones::gestion())->where('tipo', '=', 'Salida')->get();

      $funcionarios = \DB::table('funcionarios')->join('estructuras',               'funcionarios.id_estructura',         '=', 'estructuras.id')
                                                ->join('movimientos', 'movimientos.id_funcionario','=', 'funcionarios.id')
                                                //->where('funcionarios.id_gestion', '=', Gestiones::gestion())
                                                ->where('movimientos.id', '=', $id)
                                                ->select('funcionarios.id as idFuncionario', 'funcionarios.*', 'estructuras.*')
                                                ->get();

      return view('movimiento.show', compact( 'conceptos', 'movimientos', 'articulosmovimientos',  'funcionarios', 'aperturas', 'clasificadores'));
    }catch (Exception $e) {
      return "<script> alert('Error M0012: Error al listar los movimientos \n".$e->getMessage()."'); location.href='".asset('index.php/Movimientos')."'; </script>";
    }
  }


  /**
  * Numero maximo de cada movimiento para asignar en "nro_moviento" de la tabla movientos
  * Menu:
  * Link: index.php/Movimientos/ver/Maximo/{id}  | get
 */
  public function ver($id){
    try{
      $codigo_pedido = "";
      if($id == "INGRESO"){
        $codigo_pedido = \DB::table('movimientos')->where('movimiento', '=', 'INGRESO')->where('cerrado_gestion', '=', 'NO')->where('id_gestion', '=', Gestiones::gestion())->max('nro_moviento');
      }else if ($id == "SALIDA") {
        $codigo_pedido = \DB::table('movimientos')->where('movimiento', '=', 'SALIDA')->where('cerrado_gestion', '=', 'NO')->where('id_gestion', '=', Gestiones::gestion())->max('nro_moviento');
      }else if ($id == "STOCK_INGRESO") {
        $codigo_pedido = \DB::table('movimientos')->where('movimiento', '=', 'INGRESO STOCK')->where('cerrado_gestion', '=', 'NO')->where('id_gestion', '=', Gestiones::gestion())->max('nro_moviento');
      }else if ($id == "STOCK_SALIDA") {
        $codigo_pedido = \DB::table('movimientos')->where('movimiento', '=', 'SALIDA STOCK')->where('cerrado_gestion', '=', 'NO')->where('id_gestion', '=', Gestiones::gestion())->max('nro_moviento');
      }
      return $codigo_pedido;
    }catch (Exception $e) {
      return "<script> alert('Error M0013: No se puede definir tipo de movimiento \n".$e->getMessage()."'); location.href='".asset('index.php/Movimientos')."'; </script>";
    }
  }


  /**
  * Guardado de INGRESO Inmediato, Stock
  * Menu:
  * Link: index.php/Movimiento | post
 */
  public function store(Request $request){
    try{
      $id_usuario = \Auth::user()->id;

      if($request->movimiento =="INGRESO" or $request->movimiento =="INGRESO STOCK" ){

        $codigo_pedido = 0;
        if($request->movimiento == "INGRESO" ){
          $codigo_pedido = \DB::table('movimientos')->where('movimiento', '=', 'INGRESO')
                                                    ->where('cerrado_gestion', '=', 'NO')
                                                    ->where('id_gestion', '=', Gestiones::gestion())
                                                    ->count();
        $codigo_pedido = $codigo_pedido + 1;
        }elseif ($request->movimiento == "INGRESO STOCK" ) {
          $codigo_pedido = \DB::table('movimientos')->where('movimiento', '=', 'INGRESO STOCK')
                                                    ->where('cerrado_gestion', '=', 'NO')
                                                    ->where('id_gestion', '=', Gestiones::gestion())
                                                    ->count();
        $codigo_pedido = $codigo_pedido + 1;
        }

        $id_concepto  = Conceptos::Where('id_gestion', '=', Gestiones::gestion())->where('concepto', '=', trim($request->id_concepto) )->first();
        $id_proveedor = explode('|', $request->id_proveedor);
        $id_almacen   = \DB::table('almacenes')->max('id'); //Almacenes::max('id');
        $id_cambio    = Cambios::where('fecha', '=', trim($request->fecha) )->first();
        $fecha        = explode('-', $request->fecha);


        $dato = new Movimientos;
        $dato->movimiento       = $request->movimiento;
        $dato->nro_moviento     = \Auth::user()->grupo == '2' ? $codigo_pedido : date('Ymd').'/'.$codigo_pedido;
        $dato->fecha            = $request->fecha;
        $dato->anio             = $fecha[0];
        $dato->mes              = $fecha[1];
        $dato->dia              = $fecha[2];
        $dato->cerrado_gestion  = 'NO';
        $dato->codigo_pedido    = $request->codigo_pedido;
        $dato->codigo_informe   = $request->codigo_informe;
        $dato->orden_compra     = $request->orden_compra;
        $dato->codigo_tramite   = '';
        $dato->auxiliar         = \Auth::user()->grupo == '2' ? 'SI' : 'NO' ;
        $dato->rupe             = $request->rupe;
        $dato->orden_compra     = $request->orden_compra;
        $dato->glosa_entrada    = $request->glosa_entrada;
        $dato->glosa_salida     = '';
        $dato->motivo           = '';
        $dato->tipo_factura     = $request->tipo_factura;
        $dato->numero_factura   = $request->numero_factura;
        $dato->total_factura    = $request->total_factura;
        $dato->otro_documento   = $request->otro_documento;
        $dato->eliminacion      = '';
        $dato->fecha_eliminacion= '';
        $dato->id_almacen       = $id_almacen;
        $dato->id_cambio        = $id_cambio->id;
        $dato->id_concepto      = $id_concepto->id;
        $dato->id_proveedor     = $id_proveedor[0];
        $dato->id_funcionario   = '';
        $dato->movimiento_ingreso = 0;
        $dato->id_usuario       = $id_usuario;
        $dato->eliminacion      = '';
        $dato->fecha_eliminacion= '0000-00-00';
        $dato->id_gestion       = Gestiones::gestion();
        $dato->save();


        $id_movimiento = \DB::table('movimientos')->max('id');

        for($i=0; $i<$request->nro; $i++){
          $articulo = $request['bien'.$i];
          $articulo = explode(',', $articulo);
          for($j=0; $j<count($articulo)-1;$j++){
            $rows = explode('|', $articulo[$j]);
            $cantidad = $rows[0];
            $cantidad_actual = $rows[0];
            $costo    = $rows[1];
            $total    = $rows[2];
            $id_bien  = $rows[3];
            $dato = new ArticulosMovimientos;
            $dato->movimiento       = $request->movimiento;
            $dato->cantidad         = $cantidad;
            $dato->cantidad_actual  = $cantidad;
            $dato->cerrado_gestion  = 'NO';
            $dato->costo            = $costo;
            $dato->total            = $total;
            $dato->costo_actual     = $costo;
            $dato->total_actual     = $total;
            $dato->observacion      = '';
            $dato->id_movimiento    =  $id_movimiento;
            $dato->id_apertura      = $request['id_apertura'.$i];
            $dato->id_clasificador  = $this->codigoClasificador($id_bien);//$request['id_clasificador'.$i];
            $dato->id_bien          = $id_bien;
            $dato->id_usuario       = $id_usuario;
            $dato->id_almacen       = \Auth::user()->id_almacen;
            $dato->eliminacion        = '';
            $dato->fecha_eliminacion  = '0000-00-00';
            $dato->id_gestion       = Gestiones::gestion();
            $dato->save();
          }
        }
      }elseif( $request->movimiento == "SALIDA"){
        echo "1";
      }elseif( $request->movimiento == "SALIDA STOCK"){
        echo "1";
      }

      return redirect('Reportes/mostrar/'.$id_movimiento);
    }catch(\Exception $e){
      return "<script> alert('Error M0014: Error al guardar Ingreso Inmediato/Stock \n".$e->getMessage()."'); location.href='".asset('index.php/Movimientos')."'; </script>";
    }
  }

  /**
  * Funcion deshabilitada
  * Menu:
  * Link:
 */
  public function update(Request $request, $id){
    echo "Funcion deshabilitada";
  }

  /**
  * Funcion deshabilitada
  * Menu:
  * Link:
 */
  public function destroy($id){
    $dato = Movimientos::find($id);
    $dato->delete();
    return response()->json(["mensaje"=>"Borrado"]);
  }

  /**
  * Formulario para indicar porque se elimina un moviento
  * Menu:
  * Link: index.php/Movimiento/eliminar/{id} | get
 */
  public function eliminar($id){
    try{
      $dato = Movimientos::find($id);
      $eliminar = \DB::table('movimientos')->where('movimiento_ingreso', '=', $id)->where('id_gestion', '=', Gestiones::gestion())->count();
      return view('movimiento.eliminar', compact('dato', 'eliminar') );
    }catch (Exception $e) {
      return "<script> alert('Error M0016: No se cargo correctamente el Formulario para eliminar \n".$e->getMessage()."'); location.href='".asset('index.php/Movimientos')."'; </script>";
    }
  }

  /**
  * Eliminado de la informacion
  * Menu:
  * Link: index.php/Movimiento/eliminar/{id} | post
 */
  public function eliminarStore($id, Request $request){
    try{
      if($request->movimiento == "INGRESO" || $request->movimiento == "INGRESO STOCK"){
          //$eliminar = \DB::table('movimientos')->where('movimiento_ingreso', '=', $id)->count();
          $dato = Movimientos::find($id);
          $dato->eliminacion = $request->eliminacion;
          $dato->fecha_eliminacion = date('Y-m-d');
          $dato->save();
          $dato = ArticulosMovimientos::Where('id_movimiento', '=',$id )->first();
          $dato->eliminacion = $request->eliminacion;
          $dato->fecha_eliminacion = date('Y-m-d H:i:s');
          $dato->save();

          $eliminar = \DB::table('movimientos')->where('movimiento_ingreso', '=', $id)->count();
          if( $eliminar > 0 ){
            $dato = Movimientos::Where('movimiento_ingreso', '=', $id)->first();
            $dato = Movimientos::find($dato->id);
            $dato->eliminacion        = $request->eliminacion;
            $dato->fecha_eliminacion  = date('Y-m-d');
            $dato->movimiento_ingreso = 0;
            $dato->motivo             = '';
            $dato->save();

            $datos = \DB::table('articulos_movimientos')->where('id_movimiento', '=', $dato->id )->get();
            foreach ($datos as $dato) {
              $data = ArticulosMovimientos::find($dato->id);
              $data->eliminacion = $request->eliminacion;
              $data->fecha_eliminacion = date('Y-m-d H:i:s');
              $data->save();
            }
          }

      }elseif ($request->movimiento == "SALIDA"){
          $dato = Movimientos::find($dato->id);
          $dato->eliminacion        = $request->eliminacion;
          $dato->fecha_eliminacion  = date('Y-m-d');
          $dato->movimiento_ingreso = 0;
          $dato->motivo             = '';
          $dato->save();

          $datos = \DB::table('articulos_movimientos')->where('id_movimiento', '=', $dato->id )->get();
          foreach ($datos as $dato) {
            $data = ArticulosMovimientos::find($dato->id);
            $data->eliminacion = $request->eliminacion;
            $data->fecha_eliminacion = date('Y-m-d H:i:s');
            $data->save();
          }
      }elseif ($request->movimiento == "SALIDA STOCK"){
        echo "<script> alert('Este movimiento no puede ser eliminado, confundira el PEPS.'); </script>";
      }
      return redirect('Movimientos');

    }catch (Exception $e) {
      return "<script> alert('Error M0017: No se puedo eliminar movimeintos y sub movimientos \n".$e->getMessage()."'); location.href='".asset('index.php/Movimientos')."'; </script>";
    }
  }


  /**
  * Verificador de UFV, FECHA Anterior para Ingreso Stock , Inmediato.
  * Menu:
  * Link:  index.php/Movimientos/{id}/fecha | JSON
 */
  public function fecha($id){
    try{
      $msj = "";
      $ufv = Cambios::Where('fecha', '=', $id)->count();
      $mov = \DB::table('movimientos')->where('fecha', '>', Carbon::parse($id) )->count();
      if( $ufv == 0 && $mov > 0){
        $msj = "Inserte el UFV de la fecha ".$id." <a href='".asset('index.php#/cambio')."'>Click Aqui </a><br> Existen movimientos posteriores a la fecha ".$id;
      }elseif ($ufv == 0) {
        $msj = "Inserte el UFV de la fecha ".$id;
      }elseif ($mov > 0) {
        $msj = "Existen movimientos posteriores a la fecha ".$id;
      }else{
        $msj = "Codigo4060";
      }
      return $msj;
    }catch (Exception $e) {
      return "<script> alert('Error M0018: Vuelva a refrescar o entrar no se controla los datos UFV FECHA\n".$e->getMessage()."'); location.href='".asset('index.php/Movimientos')."'; </script>";
    }
  }


  /**
  * Lista de todos los movimientos pero cuando es un auxiliar
  * Menu: Movimeintos -> Movimientos Auxiliares
  * Link: index.php/Movimientos/auxiliar | post
 */
  public function auxiliar(){
    try{
      $datos = \DB::table('movimientos')->join('users', 'movimientos.id_usuario', '=', 'users.id')
                                        ->where('movimientos.cerrado_gestion', '=', 'NO')
                                        ->where('movimientos.auxiliar', '=', 'NO')
                                        ->where('movimientos.deleted_at', '=', NULL)
                                        ->where('movimientos.deleted_at', '=', NULL)
                                        ->where('id_gestion', '=', Gestiones::gestion() )
                                        ->select('movimientos.*', 'users.name as username')->get();
      return view('movimiento.auxiliar', compact('datos'));
    }catch (Exception $e) {
      return "<script> alert('Error M0019: Error al cargar datos del Auxiliar \n".$e->getMessage()."'); location.href='".asset('index.php/Movimientos')."'; </script>";
    }
  }

}

/***a ver...**/
