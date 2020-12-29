<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Http\Controllers;
use App\Http\Requests;
use App\Proveedores;
use App\Gestiones;

class ProveedoresController extends Controller
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
    $this->data = Proveedores::find($route->getParameter('Proveedores') );
  }

  public function index(){
    //$datos = Proveedores::Where('id_gestion', '=', Gestiones::gestion())->orderBy('id', 'desc')->get();
    $datos = \DB::table('proveedores')->get();
    return response()->json($datos);
  }

  public function show($id){
    $dato = Proveedores::find($id);
    return response()->json($dato->toArray());
  }

  public function store(Request $request){
    $request['id_usuario'] = \Auth::user()->id;
    $request['id_gestion'] = Gestiones::gestion();
    Proveedores::create($request->all());
    return response()->json([ 'mensaje' => $request->all() ]);
  }

  public function update(Request $request, $id){
    $request['id_usuario'] = \Auth::user()->id;
    $request['id_gestion'] = Gestiones::gestion();
    $dato = Proveedores::find($id);
    $dato->fill($request->all());
    $dato->save();
    return response()->json(["mensaje"=>"Actualizado"]);
  }

  public function destroy($id){
    $dato = Proveedores::find($id);
    $dato->delete();
    return response()->json(["mensaje"=>"Borrado"]);
  }



}
