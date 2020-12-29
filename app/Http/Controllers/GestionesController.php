<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Http\Controllers;
use App\Http\Requests;
use App\Gestiones;

class GestionesController extends Controller
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
    $this->data = Gestiones::find($route->getParameter('Gestiones') );
  }

  public function index(){
    $datos = Gestiones::orderBy('id', 'desc')->get();
    return response()->json($datos);
  }

  public function show($id){
    $dato = Gestiones::find($id);
    return response()->json($dato->toArray());
  }

  public function store(Request $request){
    return "No Insert Habilitado";
  }

  public function update(Request $request, $id){
    return "No Insert Habilitado";
  }

  public function destroy($id){
    return "No Delete Habilitado";
  }

}
