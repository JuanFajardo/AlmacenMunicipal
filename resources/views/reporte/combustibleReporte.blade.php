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
  <body>
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
          <h3> REPORTE COMBUSTIBLE </h3>
          <span style="font-size:8px;">(Expresado en Bolivianos)</span></b><br>
           {{ date("d/m/Y", strtotime($fechaInicio)) }} - {{ date("d/m/Y", strtotime($fechaFin)) }}
        </td>
      </tr>
    </table>



      <table width="100%" border="0">
        <tr style="text-align: left;">
          <td>
            <b> Partida: 34110  -  Combustibles, Lubricantes y Derivados para consumo  </b>
          </td>
        </tr>
      </table>
      <?php $sumaTotal=0; ?>
      <table width="100%" border="1" style="padding:0px; margin:0px;">
          <thead  style="background-color:#BECCD2;">
            <tr>
              <th rowspan="2" width="7%" style="text-align:left;">Orden Sal.<br>Comb.</th>
              <th rowspan="2" width="5%" style="text-align:left;">FECHA INGRESO</th>
              <th rowspan="2" width="7%" style="text-align:left;">FECHA DE SALIDA</th>
              <th rowspan="2" width="7%" style="text-align:left;">NOMBRE, CARGO DEL CONDUCTOR</th>
              <th rowspan="2" width="7%" style="text-align:left;">VEHICULO<br> N° DE PLACA</th>
              <th rowspan="2" width="7%" style="text-align:left;">LUGAR</th>
              <th rowspan="2" width="7%" style="text-align:left;">ACTIVIDAD</th>

              <th width="15%" style="text-align:left;" colspan="3">CANTIDAD FISICA</th>
              <th rowspan="2" width="7%" style="text-align:left;">P/U</th>
              <th width="15%" style="text-align:left;"  colspan="3">CANTIDAD VALORADA</th>
            </tr>

            <tr>


                <th>ENTRADA<br>LITROS</th>
                <th>SALIDA<br>LITROS</th>
                <th>SALDO<br>LITROS</th>



                <th>ENTRADA<br>BS</th>
                <th>SALIDA<br>BS</th>
                <th>SALDO<br>BS</th>
            </tr>

          </thead>
          <tbody>
            <?php $total = $contador =  $bienAuxiliar = 0; ?>
            <?php  $cantidadFisico = $cantidadValorado = 0; ?>
            @foreach($datos as $dato)
            @if($dato->glosa_salida == 'COMBUSTIBLE' || $dato->movimiento == 'COMBUSTIBLE' )
              <?php
                $bienAuxiliar = \DB::table('articulos_movimientos')->join('movimientos',         'articulos_movimientos.id_movimiento',  '=', 'movimientos.id')
                                                                    ->where('articulos_movimientos.id_bien',          '=', $dato->id_bien )
                                                                    ->where('articulos_movimientos.eliminacion',      '=', "" )
                                                                    ->where('articulos_movimientos.observacion',      '=', "" )
                                                                    ->whereIn('articulos_movimientos.movimiento', array('INGRESO STOCK', 'SALIDA STOCK'))

                                                                    //->where('movimientos.created_at',            '>=', \Carbon\Carbon::parse($fechaInicio) )
                                                                    //->where('movimientos.created_at',            '<=', \Carbon\Carbon::parse($fechaFin) )


                                                                    ->count();
                                                                    if($bienAuxiliar==0) $bienAuxiliar=1;
              $contador++;
              ?>
              <tr>


                <td height="1" style="padding-top:0px; padding-bottom:0px; text-align: left;"> {{ $dato->boleta }} </td>
                <td height="1" style="padding-top:0px; padding-bottom:0px; text-align: left;"> {{ date("d/m/Y", strtotime($dato->movimientoFecha)) }} </td>
                <td height="1" style="padding-top:0px; padding-bottom:0px; text-align: left;"> {{ $dato->aperturaCodigo }} </td>
                <td height="1" style="padding-top:0px; padding-bottom:0px; text-align: left;"> {{ $dato->nombres }}.{{ $dato->paterno }}.{{ $dato->materno }} </td>
                <td height="1" style="padding-top:0px; padding-bottom:0px; text-align: left;"> {{ $dato->placa }} </th>
                <td height="1" style="padding-top:0px; padding-bottom:0px; text-align: right;"> {{ $dato->observacion }} </th>
                @if($dato->movimiento == "INGRESO STOCK" )
                  <td style="text-align: right; padding-top:0px; padding-bottom:0px; background-color:#E0E0E0;"> <?php $cantidadFisico = $cantidadFisico + $dato->cantidad_actual; ?>  {{ number_format($dato->cantidad_actual, 2, ",", ".") }}  </td>
                  <td style="text-align: right; padding-top:0px; padding-bottom:0px;">0 </td>
                  <td style="text-align: right; padding-top:0px; padding-bottom:0px;">{{ number_format($cantidadFisico, 2, ",", ".") }} </td>

                  <td style="text-align: right; padding-top:0px; padding-bottom:0px; background-color:#E0E0E0;"> <?php $cantidadValorado = $cantidadValorado + $dato->total_actual; ?>  {{ number_format($dato->total_actual, 2, ",", ".") }}  </td>
                  <td style="text-align: right; padding-top:0px; padding-bottom:0px;">0 </td>
                  <td style="text-align: right; padding-top:0px; padding-bottom:0px;"> {{ number_format($cantidadValorado, 2, ",", ".") }}</td>
                @endif
                @if($dato->movimiento == "SALIDA STOCK" )
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

  </body>
</html>
