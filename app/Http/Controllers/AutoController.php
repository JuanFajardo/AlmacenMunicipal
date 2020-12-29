<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Auto;

class AutoController extends Controller
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
    $this->data = Auto::find($route->getParameter('Conceptos') );
  }

  public function index(){
    $datos = Auto::all();
    return view('automovil.index', compact('datos'));
    //return response()->json($datos->toArray());
  }

  public function create(){
    return view('automovil.create');
  }

  public function show($id){
    //return response()->json($this->data);
    $dato = Auto::find($id);
    return response()->json($dato->toArray());
  }

  public function store(Request $request){
    $request['id_usuario'] = \Auth::user()->id;

    $dato = new Auto;
    $dato->placa    = $request->placa;
    $dato->tipo     = $request->tipo;
    $dato->modelo   = $request->modelo;
    $dato->color    = $request->color;
    $dato->id_usuario= $request->id_usuario;
    //$dato->fill($request->all());
    $dato->save();
    //return response()->json([ 'mensaje' => $request->all() ]);
    return redirect('Automovil');
  }

  public function edit($id){
    $dato = Auto::find($id);
    return view('automovil.edit', compact('dato'));
  }

  public function update(Request $request, $id){
    $request['id_usuario'] = \Auth::user()->id;

    $dato = Auto::find($id);
    $dato->placa    = $request->placa;
    $dato->tipo     = $request->tipo;
    $dato->modelo   = $request->modelo;
    $dato->color    = $request->color;
    $dato->id_usuario= $request->id_usuario;
    $dato->save();
    return redirect('Automovil');
  }

  public function destroy($id){
    $dato = Auto::find($id);
    $dato->delete();
    return response()->json(["mensaje"=>"Borrado"]);
  }
}
