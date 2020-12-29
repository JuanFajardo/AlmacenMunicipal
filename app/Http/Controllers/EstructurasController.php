<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Http\Controllers;
use App\Http\Requests;
use App\Estructuras;
use App\Gestiones;

class EstructurasController extends Controller
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
    $this->data = Estructuras::find($route->getParameter('Estructuras') );
  }

  public function index(){
    //$datos = Estructuras::Where('id_gestion', '=', Gestiones::gestion())->orderBy('codigoEstructura', 'asc')->get();
    //return response()->json($datos->toArray());
    $datos = \DB::table('estructuras')->orderBy('estructura', 'asc')->get();
    return $datos;
  }

  public function show($id){
    //return response()->json($this->data);
    $dato = Estructuras::find($id);
    return response()->json($dato->toArray());
  }

  public function store(Request $request){
    $request['id_usuario'] = \Auth::user()->id;
    $request['id_gestion'] = Gestiones::gestion();

    /*
    $estructura = explode(' ', $request->codigoEstructura);
    $estructura = $estructura[0];
    $codigo = Estructuras::Where('id_gestion', '=', Gestiones::gestion())->where('codigoEstructura', '=', $estructura )->first();
    $numero = Estructuras::Where('id_gestion', '=', Gestiones::gestion())->where('id_estructura', '=', $codigo->id )->where('deleted_at', '=', NULL)->count();
    */

    $dato = new Estructuras;
    $dato->codigoEstructura = 0;//( $codigo->codigoEstructura + ($numero+1) );
    $dato->estructura       = $request->estructura;
    $dato->id_estructura    = 0;//$codigo->id;
    $dato->id_usuario       = $request->id_usuario;
    $dato->id_gestion       = $request->id_gestion;
    $dato->save();

    return response()->json([ 'mensaje' => $request->all() ]);
  }

  public function update(Request $request, $id){
    $request['id_usuario'] = \Auth::user()->id;
    $request['id_gestion'] = Gestiones::gestion();
    $dato = Estructuras::find($id);
    $dato->codigoEstructura = $request->codigoEstructura;
    $dato->estructura       = $request->estructura;
    $dato->id_usuario       = $request->id_usuario;
    $dato->id_gestion       = $request->id_gestion;
    //$dato = Estructuras::find($id);
    //$dato->fill($request->all());
    $dato->save();

    return response()->json(["mensaje"=>"Actualizado"]);
  }

  public function destroy($id){
    $dato = Estructuras::find($id);
    $dato->delete();
    return response()->json(["mensaje"=>"Borrado"]);
  }

}
