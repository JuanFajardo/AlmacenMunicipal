<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Http\Controllers;
use App\Http\Requests;
use App\Clasificadores;
use App\Gestiones;

class ClasificadoresController extends Controller
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
    $this->data = Clasificadores::find($route->getParameter('Clasificadores') );
  }

  public function index(){
    $datos = Clasificadores::Where('id_gestion', '=', Gestiones::gestion())->orderBy('codigo', 'asc')->get();
    return response()->json($datos);
  }

  public function show($id){
    $dato = Clasificadores::find($id);
    return response()->json($dato->toArray());
  }

  public function buscar($id){
    $dato = Clasificadores::Where('id_gestion', '=', Gestiones::gestion())->where('codigo', 'like', '%' . $id . '%')->orderBy('codigo', 'asc')->get();
    return response()->json($dato->toArray());
  }

  public function ver(){
    $datos = Clasificadores::Where('id_gestion', '=', Gestiones::gestion())->select(\DB::raw("id, CONCAT(codigo, ' -', clasificador) AS name"))->orderBy('codigo', 'asc')->get();
    return response()->json($datos->toArray());
  }
  public function verSalida($id){
    $datos = \DB::table('articulos_movimientos')->join('clasificadores', 'articulos_movimientos.id_clasificador', '=', 'clasificadores.id')
                                                ->where('articulos_movimientos.id_apertura', '=', $id)
                                                ->groupBy('articulos_movimientos.id_clasificador')
                                                ->select( \DB::raw("clasificadores.id, CONCAT(clasificadores.codigo, ' -', clasificadores.clasificador) AS name") )
                                                ->get();
    return response()->json($datos);
  }

  public function store(Request $request){
    $request['id_usuario'] = \Auth::user()->id;
    $request['id_gestion'] = Gestiones::gestion();
    Clasificadores::create($request->all());
    return response()->json([ 'mensaje' => $request->all() ]);
  }

  public function update(Request $request, $id){
    $request['id_usuario'] = \Auth::user()->id;
    $request['id_gestion'] = Gestiones::gestion();
    $dato = Clasificadores::find($id);
    $dato->fill($request->all());
    $dato->save();
    return response()->json(["mensaje"=>"Actualizado"]);
  }

  public function destroy($id){
    $dato = Clasificadores::find($id);
    $dato->delete();
    return response()->json(["mensaje"=>"Borrado"]);
  }

}
