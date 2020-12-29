<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Http\Controllers;
use App\Http\Requests;
use App\User;

class UserController extends Controller
{
  public function __construct(){
    $this->middleware('cors');
    $this->middleware('auth');

    if( \Auth::guest() )
      return redirect('index.php/login');
    elseif(\Auth::user()->grupo != 1)
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
    $this->data = User::find($route->getParameter('User') );
  }

  public function index(){
    $datos = User::orderBy('id', 'desc')->get();
    return response()->json($datos);
  }

  public function show($id){
    $dato = User::find($id);
    return response()->json($dato->toArray());
  }

  public function store(Request $request){
    $request['id_usuario']      = \Auth::user()->id;
    $request['password']        = bcrypt($request->password);
    User::create($request->all());
    return response()->json([ 'mensaje' => 'Se inserto usuario' ]);
  }

  public function update(Request $request, $id){
    $request['id_usuario'] = \Auth::user()->id;
    $dato = User::find($id);
    $dato->name           = $request->name;
    $dato->nombreCompleto = $request->nombreCompleto;
    $dato->ci             = $request->ci;
    $dato->grupo          = $request->grupo;
    $dato->id_almacen     = $request->id_almacen;
    if( strlen($request->password) > 0 )
      $dato->password     = bcrypt($request->password);
    $dato->id_usuario     = \Auth::user()->id;
    $dato->save();
    return response()->json(["mensaje"=>"Actualizado"]);
  }

  public function destroy($id){
    $dato = User::find($id);
    $dato->delete();
    return response()->json(["mensaje"=>"Borrado"]);
  }
}
