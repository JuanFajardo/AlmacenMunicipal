<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <style media="screen">
      body{
        position: relative;
        color: #222;
        font-family: "Helvetica", Arial, Verdana, sans-serif;
        font-size: 12px;
        line-height: 1.4;
      }
      table {
        border-collapse: collapse;
        padding: 0px;
      }
      thead{display: table-header-group;}
      tfoot {display: table-row-group;}
      tr {page-break-inside: avoid;}
    </style>
  </head>
  <body >
    <table width="100%">
      <tr>
        <td>
          <style type="text/css"> img{padding: 0px; position: absolute;} td{ padding:0px; }</style>
          <img src="{{asset('assets/images/entidad.jpg')}}" width="48px" height="58px">
          <style type="text/css">
            br{ padding: 0px; }
          </style>
          <b style="padding-left: 50px;">{{ $configuracion->entidad }} </b> <br>
          <b style="font-size: 16px; padding-left: 80px;">UNIDAD DE ALMACEN</b>
        </td>
        <td style="text-align: right;">
           @foreach($datos as $dato)
           @endforeach
           <b>USUARIO:</b> {{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}} </br>
           {{$almacen->almacen}}
        </td>
      </tr>
    </table>
    <table width="100%">
      <tr style="text-align: center;">
        <td>
          <h3> REPORTE DE SUMINISTROS Y MATERIALES  </BR>APERTURA PROGRAMATICA </h3>
          <span style="font-size:8px;">(Expresado en Bolivianos)</span></b><br>
           {{ date("d/m/Y", strtotime($fechaInicio)) }} - {{ date("d/m/Y", strtotime($fechaFin)) }}
        </td>
      </tr>
    </table>

    @foreach($aperturas as $apertura)
      <table width="100%" border="0">
        <tr style="text-align: left;">
          <td>
            <b>APERTURA PROGRAMATICA {{ $apertura->codigo }} - {{ $apertura->apertura }} </b>
          </td>
        </tr>
      </table>
      <?php $sumaTotal=0; ?>
      <table width="100%" border="1" style="padding:0px; margin:0px;">
          <thead  style="background-color:#BDCB37;">
            <tr>
              <td colspan="6"></td>
              <td colspan="3" style="text-align:center;">FISICO</td>
              <td colspan="3" style="text-align:center;">VALORADO</td>
            </tr>
            <tr>
              <td width="7%" style="text-align:left;">Fecha</td>
              <td width="4%" style="text-align:left;">Nro Movimiento</td>
              <td width="7%" style="text-align:left;">Apertura</td>
              <td width="7%" style="text-align:left;">Codigo</td>
              <td width="25%" style="text-align:left;">Articulo</td>
              <td width="4%" style="text-align:left;">Precio Uni.</td>

              <td width="5%" style="padding:0px; margin:0px;">Entrada</td>
              <td width="5%" style="padding:0px; margin:0px;">Salida</td>
              <td width="5%" style="padding:0px; margin:0px;">Saldo</td>

              <td width="5%" style="padding:0px; margin:0px;">Entrada</td>
              <td width="5%" style="padding:0px; margin:0px;">Salida</td>
              <td width="5%" style="padding:0px; margin:0px;">Saldo</td>
            </tr>
          </thead>
          <tbody>
            <?php $total = $contador =  $bienAuxiliar = 0; ?>
            <?php  $cantidadFisico = $cantidadValorado = 0; ?>
            @foreach($datos as $dato)
            @if($dato->movimiento == 'INGRESO' || $dato->movimiento == 'SALIDA' )
              <?php
                $bienAuxiliar = \DB::table('articulos_movimientos')->join('movimientos',         'articulos_movimientos.id_movimiento',  '=', 'movimientos.id')
                                                                    ->where('articulos_movimientos.id_bien',          '=', $dato->id_bien )
                                                                    ->where('articulos_movimientos.eliminacion',      '=', "" )
                                                                    ->where('articulos_movimientos.observacion',      '=', "" )
                                                                    ->where('articulos_movimientos.id_almacen',       '=', $dato->id_almacen)
                                                                    ->where('articulos_movimientos.id_apertura',      '=', $dato->id_apertura)
                                                                    ->whereIn('articulos_movimientos.movimiento', array('INGRESO', 'SALIDA'))
                                                                    ->where('movimientos.created_at',            '>=', \Carbon\Carbon::parse($fechaInicio) )
                                                                    ->where('movimientos.created_at',            '<=', \Carbon\Carbon::parse($fechaFin) )
                                                                    ->where('articulos_movimientos.id_gestion',  '=', \App\Gestiones::gestion())
                                                                    ->count();
              if($bienAuxiliar==0) $bienAuxiliar=1;
              $contador++;
              ?>
              <tr>
                <td height="1" style="padding-top:0px; padding-bottom:0px; text-align: left;"> {{ date("d/m/Y", strtotime($dato->movimientoFecha)) }} </td>
                <td height="1" style="padding-top:0px; padding-bottom:0px; text-align: left;"> {{ str_pad($dato->nro_moviento, 6, "0", STR_PAD_LEFT) }} </td>
                <td height="1" style="padding-top:0px; padding-bottom:0px; text-align: left;"> {{ $dato->aperturaCodigo }} </td>
                <td height="1" style="padding-top:0px; padding-bottom:0px; text-align: left;"> {{ $dato->clasificadorCodigo }}.{{ $dato->id_almacen }}.{{ $dato->bienCodigo }} </td>
                <td height="1" style="padding-top:0px; padding-bottom:0px; text-align: left;"> {{ $dato->bien }} </th>
                <td height="1" style="padding-top:0px; padding-bottom:0px; text-align: right;"> {{ number_format($dato->costo, 2, ",", ".") }} </td>
                @if($dato->movimiento == "INGRESO" )
                  <td style="text-align: right; padding-top:0px; padding-bottom:0px; background-color:#E0E0E0;"> <?php $cantidadFisico = $cantidadFisico + $dato->cantidad_actual; ?>  {{ number_format($dato->cantidad_actual, 2, ",", ".") }}  </td>
                  <td style="text-align: right; padding-top:0px; padding-bottom:0px;">0 </td>
                  <td style="text-align: right; padding-top:0px; padding-bottom:0px;">{{ number_format($cantidadFisico, 2, ",", ".") }} </td>

                  <td style="text-align: right; padding-top:0px; padding-bottom:0px; background-color:#E0E0E0;"> <?php $cantidadValorado = $cantidadValorado + $dato->total_actual; ?>  {{ number_format($dato->total_actual, 2, ",", ".") }}  </td>
                  <td style="text-align: right; padding-top:0px; padding-bottom:0px;">0 </td>
                  <td style="text-align: right; padding-top:0px; padding-bottom:0px;"> {{ number_format($cantidadValorado, 2, ",", ".") }}</td>
                @endif
                @if($dato->movimiento == "SALIDA" )
                  <td style="text-align: right; padding-top:0px; padding-bottom:0px; "> 0 </td>
                  <td style="text-align: right; padding-top:0px; padding-bottom:0px; background-color:#E0E0E0;"> <?php $cantidadFisico = $cantidadFisico - $dato->cantidad; ?>  {{ number_format($dato->cantidad, 2, ",", ".") }}  </td>
                  <td style="text-align: right; padding-top:0px; padding-bottom:0px;">{{ number_format($cantidadFisico, 2, ",", ".") }} </td>

                  <td style="text-align: right; padding-top:0px; padding-bottom:0px;">0 </td>
                  <td style="text-align: right; padding-top:0px; padding-bottom:0px; background-color:#E0E0E0;"> <?php $cantidadValorado = $cantidadValorado - $dato->total_actual; ?>  {{ number_format($dato->total_actual, 2, ",", ".") }}  </td>
                  <td style="text-align: right; padding-top:0px; padding-bottom:0px;"> {{ number_format($cantidadValorado, 2, ",", ".") }}</td>
                @endif
              </tr>

              @if( $bienAuxiliar == $contador )
              <tr>
                <td colspan="6"></td>
                <td colspan="6" style="font-weight:bold; font-size:16px;"> Monto Total: Bs. {{ number_format($cantidadValorado, 2, ",", ".") }}</td>
                <?php
                  $total = $total + $cantidadValorado;
                  $contador = $cantidadFisico = $cantidadValorado = 0;
                ?>
              </tr>
              <tr>
                <td colspan="12">&nbsp;</td>
              </tr>
              @endif
          @endif
          @endforeach
          </tbody>
        </table>
        <p> La sumatoria de todos los montos totales es: <b> Bs. {{ number_format($total, 2, ",", ".") }} </b></p><br><br><br>
    @endforeach
  </body>
</html>
