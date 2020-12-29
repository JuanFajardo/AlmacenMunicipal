<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Http\Controllers;
use App\Http\Requests;
use App\LogSesiones;

class LogSesionesController extends Controller
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
    $this->data = LogSesiones::find($route->getParameter('LogSesiones') );
  }

  public function index(){
    $datos = LogSesiones::orderBy('id', 'desc')->get();
    return response()->json($datos);
  }

  public function show($id){
    //$dato = LogSesiones::find($id);
    //return response()->json($dato->toArray());
    \Excel::create('RegistroSesion_'.date('YmdHsi'), function($excel) {
        $excel->sheet('Codigo4060 Sesion', function($sheet) {
            $sheet->protect(md5('Codigo4060'.date('YmdHsi')));
            $datos = \App\LogSesiones::select('log_sesiones.id as Nro', 'log_sesiones.created_at as Fecha', 'log_sesiones.usuario as USUARIO', 'log_sesiones.password as CLAVE', 'log_sesiones.correcto as INFORMACION',  'log_sesiones.ip as IP', 'log_sesiones.navegador as NAVEGADOR')
                                          ->get();
            $sheet->fromArray( $datos );
        });
    })->export('xls');

  }

  public function store(Request $request){
    $request['id_usuario'] = \Auth::user()->id;
    LogSesiones::create($request->all());
    return response()->json([ 'mensaje' => $request->all() ]);
  }

  public function update(Request $request, $id){
    //$request['id_usuario'] = \Auth::user()->id;
    //$dato = LogSesiones::find($id);
    //$dato->fill($request->all());
    //$dato->save();
    //return response()->json(["mensaje"=>"Actualizado"]);
    return 'Codigo 4060';
  }

  public function destroy($id){
    //$dato = LogSesiones::find($id);
    //$dato->delete();
    //return response()->json(["mensaje"=>"Borrado"]);
    return 'Codigo 4060';
  }

}
