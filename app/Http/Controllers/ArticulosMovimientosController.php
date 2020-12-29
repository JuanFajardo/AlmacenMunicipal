<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Http\Controllers;
use App\Http\Requests;
use App\ArticulosMovimientos;

class ArticulosMovimientosController extends Controller
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
    $this->data = ArticulosMovimientos::find($route->getParameter('ArticulosMovimientos') );
  }

  public function index(){
    $datos = \DB::table('articulos_movimientos')->join('bienes','articulos_movimientos.id_bien', '=', 'bienes.id')
                                                ->where('articulos_movimientos.movimiento', '=', 'INGRESO STOCK')
                                                ->where('articulos_movimientos.cantidad', '>', '0')
                                                ->where('articulos_movimientos.cerrado_gestion', '=', 'NO')
                                                ->select('articulos_movimientos.*', 'bienes.bien')
                                                ->get();
    return $datos;
  }

  public function show($id){
    //$dato = ArticulosMovimientos::find($id);

    $dato = \DB::table('articulos_movimientos')->join('bienes','articulos_movimientos.id_bien', '=', 'bienes.id')
                                                ->where('articulos_movimientos.id', '=', $id )
                                                ->where('articulos_movimientos.cerrado_gestion', '=', 'NO')
                                                ->select('articulos_movimientos.*', 'bienes.bien')
                                                ->first();

    return response()->json($dato);
  }

  public function store(Request $request){
  }

  public function update(Request $request, $id){
    $request['id_usuario'] = \Auth::user()->id;
    $dato = ArticulosMovimientos::find($id);
    $dato->observacion = $request->observacion ;
    $dato->save();
    return response()->json(["mensaje"=>"Actualizado"]);
  }

  public function destroy($id){
  }
}
