<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Http\Controllers;
use App\Http\Requests;
use App\LogNavegaciones;


class LogNavegacionesController extends Controller
{
  public function __construct(){
    $this->middleware('cors');
    $this->middleware('auth');

    if( \Auth::guest() )
      return redirect('index.php/login');
    elseif(\Auth::user()->grupo != 1)
      return abort(503);
  }
  public function find(Route $route){
    $this->data = LogNavegaciones::find($route->getParameter('LogNavegaciones') );
  }

  public function index(){
    $datos = LogNavegaciones::orderBy('id', 'desc')->get();
    return response()->json($datos);
  }

  public function show($id){
    \Excel::create('Registro de Navegacion_'.date('YmdHsi'), function($excel) {
        $excel->sheet('Codigo4060 Navegacion', function($sheet) {
            $sheet->protect(md5('Codigo4060'.date('YmdHsi')));
            $datos = \App\LogNavegaciones::select('log_navegaciones.id as Nro', 'log_navegaciones.created_at as Fecha', 'log_navegaciones.direccion as LINK', 'log_navegaciones.accion as ACTIVIDAD', 'log_navegaciones.navegador as NAVEGADOR', 'log_navegaciones.usuario as USUARIO')
                                          ->get();
            $sheet->fromArray( $datos );
        });
    })->export('xls');
  }

  public function store(Request $request){
    $request['id_usuario'] = \Auth::user()->id;
    LogNavegaciones::create($request->all());
    return response()->json([ 'mensaje' => $request->all() ]);
  }

  public function update(Request $request, $id){
    //$request['id_usuario'] = \Auth::user()->id;
    //$dato = LogNavegaciones::find($id);
    //$dato->fill($request->all());
    //$dato->save();
    //return response()->json(["mensaje"=>"Actualizado"]);
    return 'Codigo 4060';
  }

  public function destroy($id){
    //$dato = LogNavegaciones::find($id);
    //$dato->delete();
    //return response()->json(["mensaje"=>"Borrado"]);
    return 'Codigo 4060';
  }

}
