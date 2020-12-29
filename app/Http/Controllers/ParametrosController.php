<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Http\Controllers;
use App\Http\Requests;


class ParametrosController extends Controller
{
  public function __construct(){
    $this->middleware('cors');
    $this->middleware('auth');
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


  public function insertarUFV(){
    $dato = \DB::table('cambios')->max('fecha');
    $fecha = date('Y-m-d');
    //
    if( $dato == $fecha ){
      $result = "<script type='text/javascript'>alert('Usted ya inserto la actualizacion de los datos');window.location='".asset('index.php#/cambio')."';</script>";
    }else{

      $dato = new \App\Cambios;

      $dato->fecha = $fecha;
      $dato->compra     = $this->dolar('compra');
      $dato->venta      = $this->dolar('venta');
      $dato->ufv        = $this->ufv();
      $dato->automatico = 'SI';
      $dato->id_usuario = \Auth::user()->id;
      $dato->save();

      $result = "<script type='text/javascript'>var hoy = new Date();
                  var dd = hoy.getDate();
                  var mm = hoy.getMonth()+1;
                  var yyyy = hoy.getFullYear();
                  if(dd<10) {
                      dd='0'+dd
                  }
                  if(mm<10) {
                      mm='0'+mm
                  }
                  hoy = yyyy+'-'+mm+'-'+dd;
                  alert('Acaba de actualizar los datos del dolar y ufvs'+'  '+ hoy);
                  window.location='".asset('index.php#/cambio')."'</script>";
    }

    return $result;
  }


  public function ufv(){
    $data = file_get_contents("https://www.bcb.gob.bo/librerias/indicadores/ufv/ultimo.php");
    $data1 = explode(">", $data);
    $ufv = explode("&nbsp;", $data1[24]);
    $ufv = trim($ufv[0]);

    $ufv = floatval( str_replace(',', '.', trim($ufv)) ) ;
    return $ufv;
  }

  public function dolar($tipo){
    $data = file_get_contents("https://www.bcb.gob.bo/librerias/indicadores/otras/ultimo.php");
    $data1 = explode("</tr>", $data);
    $v1 = explode(">", $data1[2]);
    $c1 = explode(">", $data1[3]);
    $venta = explode("<", $v1[15]);
    $compra = explode("<", $c1[15]);
    $venta = trim($venta[0]);
    $compra = trim($compra[0]);
    if( $tipo == "compra" ){
      return $compra;
    }else{
      return $venta;
    }
  }

}
