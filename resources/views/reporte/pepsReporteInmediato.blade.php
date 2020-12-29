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
      thead{display: table-header-group;}
      tfoot {display: table-row-group;}
      tr {page-break-inside: avoid;}
    </style>
  </head>
  <body style="border:0; margin: 0;">
    <div class="col-lg-12">
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
          <td align="rigth">
          @foreach($datos as $dato)
          @endforeach
             <b>USUARIO:</b> {{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}} </br>
             {{$almacen->almacen}}
          </td>
        </tr>
      </table>
      <table width="100%">
        <tr>
          @if($bett0 == ' 1=1 ')
            <td><h2 style="text-align: center;"> INVENTARIO FISICO - VALORADO DE MATERIALES Y SUMINISTROS</h2></td>
          @else
            <td><h2 style="text-align: center;"> KARDEX DE MATERIALES Y SUMINISTROS </h2></td>
          @endif
        </tr>
      </table>
    </div>
    {{$almacen->almacen}} Fecha Inicio:  {{ date("d/m/Y", strtotime($fechaInicio)) }}     -        Fecha Final: {{ date("d/m/Y", strtotime($fechafinal))}}
    <?php $sumaTotal = 0; ?>
    <table width="100%" border="1" style="padding:0px; margin:0px;">
        <thead  style="background-color:#BDCB37;">
          <tr>
            <td colspan="6"></td>
            <td colspan="3" style="text-align:center;">FISICO</td>
            <td colspan="3" style="text-align:center;">VALORADO</td>
          </tr>
          <tr>
            <td width="7%" style="text-align:left;">Fecha</td>
            <td width="4%" style="text-align:left;">N° Trans.</td>
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

        <?php $total = $contador =  $bienAuxiliar = $entradaFisico = $salidaFisico = $saldoFisico = $entradaValorado = $salidaValorado = $saldoValorado = 0; ?>
        <?php  $cantidadFisicoAux = $cantidadValoradoAux = $cantidadFisico = $cantidadValorado = 0; ?>
        @foreach($datos as $dato)
        @if($dato->movimiento == 'INGRESO' || $dato->movimiento == 'SALIDA' )
          <?php
            $bienAuxiliar = \DB::table('articulos_movimientos')->join('movimientos',         'articulos_movimientos.id_movimiento',  '=', 'movimientos.id')
                                                                ->where('articulos_movimientos.id_bien',     '=', $dato->id_bien )
                                                                ->where('articulos_movimientos.eliminacion', '=', "" )
                                                                ->where('articulos_movimientos.observacion', '=', "" )
                                                                ->where('articulos_movimientos.id_almacen',  '=', $dato->id_almacen)
                                                                ->whereIn('articulos_movimientos.movimiento', array('INGRESO', 'SALIDA'))
                                                                ->where('movimientos.created_at',            '>=', \Carbon\Carbon::parse($fechaInicio) )
                                                                ->where('movimientos.created_at',            '<=', \Carbon\Carbon::parse($fechafinal) )
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
              <td style="text-align: right; padding-top:0px; padding-bottom:0px; background-color:#E0E0E0;"> <?php $cantidadFisico = $cantidadFisico + $dato->cantidad_actual; ?>  {{ $dato->cantidad_actual }}  </td>
              <td style="text-align: right; padding-top:0px; padding-bottom:0px;">0 </td>
              <td style="text-align: right; padding-top:0px; padding-bottom:0px;">{{ $cantidadFisico }} </td>

              <td style="text-align: right; padding-top:0px; padding-bottom:0px; background-color:#E0E0E0;"> <?php $cantidadValorado = $cantidadValorado + $dato->total_actual; ?>  {{ number_format($dato->total_actual, 2, ",", ".") }}  </td>
              <td style="text-align: right; padding-top:0px; padding-bottom:0px;">0.00 </td>
              <td style="text-align: right; padding-top:0px; padding-bottom:0px;"> {{ number_format($cantidadValorado, 2, ",", ".") }}</td>
            @endif
            @if($dato->movimiento == "SALIDA" )
              <td style="text-align: right; padding-top:0px; padding-bottom:0px; "> 0 </td>
              <td style="text-align: right; padding-top:0px; padding-bottom:0px; background-color:#E0E0E0;"> <?php $cantidadFisico = $cantidadFisico - $dato->cantidad; ?>  {{ $dato->cantidad }}  </td>
              <td style="text-align: right; padding-top:0px; padding-bottom:0px;">{{ $cantidadFisico }} </td>

              <td style="text-align: right; padding-top:0px; padding-bottom:0px;">0.00 </td>
              <td style="text-align: right; padding-top:0px; padding-bottom:0px; background-color:#E0E0E0;"> <?php $cantidadValorado = $cantidadValorado - $dato->total_actual; ?>  {{ number_format($dato->total_actual, 2, ",", ".") }}  </td>
              <td style="text-align: right; padding-top:0px; padding-bottom:0px;"> {{ number_format($cantidadValorado, 2, ",", ".") }}</td>
            @endif
          </tr>
          @if( $bienAuxiliar == $contador )          
          <tr>
            <td colspan="11">&nbsp;</td>
            <td style="text-align: right; font-weight:bold; background-color:#CFD8DC;"> {{ number_format($cantidadValorado, 2, ",", ".") }} </td>
            <?php
              $total = $total + $cantidadValorado;
              $contador = $cantidadFisico = $cantidadValorado = 0;
              $entradaFisico = $salidaFisico = $saldoFisico = $entradaValorado = $salidaValorado = $saldoValorado = 0;
            ?>
          </tr>
          <tr><td colspan="12">&nbsp;</td></tr>
          @endif
      @endif
      @endforeach
      </tbody>
    </table>
     <p> Total: <b> Bs. {{ number_format( $total, 2, ",", ".") }}</b></p>
  </body>
</html>
