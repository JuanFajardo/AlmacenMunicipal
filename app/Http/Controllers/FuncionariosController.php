<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Http\Controllers;
use App\Http\Requests;
use App\Funcionarios;
use App\Gestiones;

class FuncionariosController extends Controller
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
    $this->data = Funcionarios::find($route->getParameter('Funcionarios') );
    //$this->data = Funcionarios::->join('transacciones', 'name.id', '=', 'table.id')
    //->select('name.id', 'table.email');
  }

  public function index(){
    $datos = \DB::table('funcionarios')->join('estructuras', 'funcionarios.id_estructura', '=','estructuras.id')
                                       ->where('funcionarios.deleted_at', '=', NULL)
                                       //->where('funcionarios.id_gestion', '=', Gestiones::gestion())
                                       ->select("funcionarios.*","estructuras.estructura")->orderBy('funcionarios.id','desc')->get();
    return response()->json($datos);
  }

  public function show($id){
    $dato = Funcionarios::find($id);
    return response()->json($dato->toArray());
  }

  public function store(Request $request){
    $request['id_usuario'] = \Auth::user()->id;
    $request['id_gestion'] = Gestiones::gestion();
    $request['nombres']    = ucfirst($request['nombres']);
    $request['paterno']    = ucfirst($request['paterno']);
    $request['materno']    = ucfirst($request['materno']);
    $request['zona']       = ucfirst($request['zona']);
    $request['direccion']  = ucfirst($request['direccion']);

    Funcionarios::create($request->all());
    return response()->json([ 'mensaje' => $request->all() ]);
  }

  public function update(Request $request, $id){
    $request['id_usuario'] = \Auth::user()->id;
    $request['id_gestion'] = Gestiones::gestion();
    $dato = Funcionarios::find($id);
    $dato->fill($request->all());
    $dato->save();
    return response()->json(["mensaje"=>"Actualizado"]);
  }

  public function destroy($id){
    $dato = Funcionarios::find($id);
    $dato->delete();
    return response()->json(["mensaje"=>"Borrado"]);
  }

}
