<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Http\Controllers;
use App\Http\Requests;
use App\Bienes;
use App\Gestiones;


class BienesController extends Controller
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
    $this->data = Bienes::find($route->getParameter('Aperturas') );
  }

  public function index(){
    //$datos = Bienes::orderBy('id', 'desc')->get();
    $datos = \DB::table('bienes')->join('clasificadores', 'bienes.id_clasificador', '=', 'clasificadores.id')
                                 ->join('unidades', 'bienes.id_unidad', '=', 'unidades.id')
                                 ->where('bienes.id_gestion', '=', Gestiones::gestion())
                                 ->where('bienes.deleted_at', '=', NULL)
                                 ->select('bienes.*',  'clasificadores.clasificador', 'unidades.unidad as medida', 'clasificadores.codigo as clasificadorCode')->orderBy('id','desc')->paginate(100);
    return response()->json(array($datos));
    //return view('datos', compact('datos'));
  }


  public function buscar($id){
    $datos = \DB::table('bienes')->join('clasificadores', 'bienes.id_clasificador', '=', 'clasificadores.id')
                                 ->join('unidades', 'bienes.id_unidad', '=', 'unidades.id')
                                 ->where('bienes.id_gestion', '=', Gestiones::gestion())
                                 ->where('bienes.bien', 'like', '%'.$id.'%')
                                 ->where('bienes.deleted_at', '=', NULL)
                                 ->orWhere('clasificadores.codigo', 'like', '%'.$id.'%')
                                 ->orWhere('bienes.id_almacen', 'like', '%'.$id.'%')
                                 ->orWhere('bienes.codigo', 'like', '%'.$id.'%')
                                 ->where('bienes.deleted_at', '=', NULL)
                                 ->select('bienes.*',  'clasificadores.clasificador', 'unidades.unidad as medida', 'clasificadores.codigo as clasificadorCode')->orderBy('clasificadores.codigo','asc')->orderBy('bienes.codigo','asc')->paginate(100);

  return response()->json(array($datos));
  }

  public function show($id){
    $dato = Bienes::find($id);
    return response()->json( $dato );
  }


  //Ver Bienes de Ingreso / IngresoStock
  public function ver($id){
    $ids = explode(',',$id);
    $datos = \DB::table('bienes')->join('unidades', 'bienes.id_unidad', '=', 'unidades.id')
                                 ->join('clasificadores', 'bienes.id_clasificador', '=', 'clasificadores.id')
                                 ->where('bienes.id_gestion', '=', Gestiones::gestion())
                                 ->where('bienes.deleted_at', '=', NULL)
                                 ->whereIn('bienes.id_clasificador', $ids)
    ->select('bienes.id as code',  'bienes.bien AS name', 'unidades.unidad as medida', 'clasificadores.codigo as clasificadorCode', 'bienes.id_almacen as almacenCode', 'bienes.codigo as bienCode' )
    ->get();
    return response()->json($datos);
  }
  //Ver Bienes de Salida Stock
  public function verStock($id){
    $datos =  explode('|',$id);
    $apertura = $datos[1];
    $ids = explode( ',', $datos[0] );

    $datos = \DB::table('articulos_movimientos')->join('bienes', 'articulos_movimientos.id_bien', '=', 'bienes.id')
                                                ->join('clasificadores', 'bienes.id_clasificador', '=', 'clasificadores.id')
                                                ->join('unidades', 'bienes.id_unidad', '=', 'unidades.id')
                                                ->where('articulos_movimientos.movimiento', '=', 'INGRESO STOCK')
                                                ->where('articulos_movimientos.eliminacion', '=', '')
                                                ->where('articulos_movimientos.cantidad', '>', 0)
                                                ->where('articulos_movimientos.id_apertura', '=',  $apertura)
                                                ->whereIn('articulos_movimientos.id_clasificador', $ids)
    ->select('bienes.id as code',  'bienes.bien AS name', 'unidades.unidad as medida', 'clasificadores.codigo as clasificadorCode', 'bienes.id_almacen as almacenCode', 'bienes.codigo as bienCode', \DB::raw(" sum(articulos_movimientos.cantidad) as cantidad"), 'articulos_movimientos.costo'  )
                                                ->groupBy('articulos_movimientos.id_bien')
                                                ->get();
    return response()->json($datos);
  }

  public function store(Request $request){
    $request['id_almacen'] = 0;
    $request['id_usuario'] = \Auth::user()->id;
    $request['id_gestion'] = Gestiones::gestion();
    $numero = Bienes::Where('id_clasificador', '=', $request->id_clasificador)->max('codigo');
    $request['codigo'] = $numero + 1;
    Bienes::create($request->all());
    return response()->json([ 'mensaje' => $request->all() ]);
  }

  public function update(Request $request, $id){
    $request['id_almacen'] = 0;
    $request['id_usuario'] = \Auth::user()->id;
    $request['id_gestion'] = Gestiones::gestion();
    $numero = Bienes::Where('id_clasificador', '=', $request->id_clasificador)->where('bienes.id_gestion', '=', Gestiones::gestion())->max('codigo');
    $request['codigo'] = $numero+1;
    $numero = \DB::table('articulos_movimientos')->where('id_bien', '=', $id)->count();
    if($numero == 0){
      $dato = Bienes::find($id);
      $dato->fill($request->all());
      $dato->save();
    }
    return response()->json(["mensaje"=>"Actualizado"]);
  }

  public function destroy($id){
    $numero = 0;
    $request['id_gestion'] = Gestiones::gestion();
    $numero = \DB::table('articulos_movimientos')->where('id_bien', '=', $id)->count();
    if($numero == 0){
      $dato = Bienes::find($id);
      $dato->delete();
    }
    return response()->json(["mensaje"=>"Borrado"]);
  }


  public function catalogoApertura($id){
      $datos = \DB::table('bienes')->join('articulos_movimientos', 'bienes.id', '=', 'articulos_movimientos.id_bien')
                                  ->whereIn('articulos_movimientos.movimiento', array('INGRESO', 'INGRESO STOCK'))
                                  ->where('articulos_movimientos.id_apertura', '=', $id)
                                  ->groupBy('bienes.bien')
                                  ->orderBy('bienes.bien')
                                  ->select('bienes.*')
                                  ->get();
    return response()->json($datos);
  }

}
