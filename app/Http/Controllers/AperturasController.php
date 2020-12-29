<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Http\Controllers;
use App\Http\Requests;
use App\Aperturas;
use App\Gestiones;

class AperturasController extends Controller
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
    $this->data = Aperturas::find($route->getParameter('Aperturas') );
  }

  public function index(){
    $datos = Aperturas::Where('id_gestion', '=', Gestiones::gestion())->orderBy('codigo', 'asc')->get();
    return response()->json($datos);
  }

  public function show($id){
    $dato = Aperturas::find($id);
    return response()->json($dato->toArray());
  }

  public function buscar($id){
    $dato = Aperturas::Where('id_gestion', '=', Gestiones::gestion())
                      ->where('codigo', 'like', '%' . $id . '%')
                      ->select(\DB::raw("id, CONCAT(codigo, ' -', apertura) AS name"))
                      ->get();
    return response()->json($dato->toArray());
  }


  public function ver(){
    //$datos = Aperturas::select('id', 'codigo as name')->get();
    $datos = Aperturas::Where('id_gestion', '=', Gestiones::gestion())->select(\DB::raw("id, CONCAT(codigo, ' -', apertura) AS name"))->orderBy('aperturas.codigo','asc')->get();
    return response()->json($datos->toArray());
  }

  public function verSalida(){
     $datos = \DB::table('articulos_movimientos')->join('aperturas', 'articulos_movimientos.id_apertura', '=', 'aperturas.id')
                                                //->where('articulos_movimientos.id_apertura', '=', $id)
                                                ->groupBy('articulos_movimientos.id_apertura')
                                                ->select( \DB::raw("aperturas.id, CONCAT(aperturas.codigo, ' -', aperturas.apertura) AS name") )
                                                ->orderBy('aperturas.codigo','asc')
                                                ->get();
    return response()->json($datos);
  }

  public function store(Request $request){
    $request['id_usuario'] = \Auth::user()->id;
    $request['id_gestion'] = Gestiones::gestion();
    Aperturas::create($request->all());
    return response()->json([ 'mensaje' => $request->all() ]);
  }

  public function update(Request $request, $id){
    $request['id_usuario'] = \Auth::user()->id;
    $request['id_gestion'] = Gestiones::gestion();
    $dato = Aperturas::find($id);
    $dato->fill($request->all());
    $dato->save();
    return response()->json(["mensaje"=>"Actualizado"]);
  }

  public function destroy($id){
    $dato = Aperturas::find($id);
    $dato->delete();
    return response()->json(["mensaje"=>"Borrado"]);
  }

}
