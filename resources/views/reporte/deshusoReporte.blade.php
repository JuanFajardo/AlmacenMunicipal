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
          <img src="{{asset('assets/images/entidad.jpg')}}" widtd="48px" height="58px">

        <style type="text/css">
          br{ padding: 0px; }
        </style>
          <b style="padding-left: 65px;">{{ $configuracion->entidad }} </b> <br>
          <b style="font-size: 16px; padding-left: 80px;">UNIDAD DE ALMACEN</b>
        </td>
        <td align="right"> usuario: {{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}} </td>
      </tr>
    </table>
    <table width="100%">
      <tr>
        <td><h2 style="text-align: center;"> REPORTE DE MATERIALES Y SUMINISTROS ANULADOS<br><span style="font-size:10px;">( Gestion: {{ $gestion->gestion }})</span> </h2> </td>
      </tr>
    </table>

    <?php $sumaTotal=0; ?>
    @foreach($bienes as $bien)
    <table width="100%" border="0">
      <thead>
        <td> <b> {{$bien->clasificadorCodigo}}.{{$bien->id_almacen}}.{{$bien->codigo}}</b></br>  <b> {{$bien->bien}} </b> </td>
        <td> <b> UNIDAD :</b> {{$bien->unidad}} </td>
      </thead>
    </table>

    <table width="100%" border="1" style="padding:0px; margin:0px;">
        <tr style=" background-color:#BECCD2;">
          <td style="text-align:left;">Nro. Trans.</td>
          <td style="text-align:left;">Apertura</td>
          <td style="text-align:left;">Motivo</td>
          <td style="text-align:left;">Precio Uni.</td>
          <td>Entrada</td>
          <td>Salida</td>
          <td>Saldo</td>
          <td>Entrada</td>
          <td>Salida</td>
          <td>Saldo</td>
        </tr>
        <?php
          $total = 0;
          $fisico = 0;
          $valorado = 0;
        ?>
        @foreach($datos as $dato)
          @if($dato->id_bien == $bien->id)
          <tr>
            @if( $dato->movimiento == 'INGRESO STOCK')
            <td height="1" style="padding-top:0px; padding-bottom:0px; text-align: left;"> {{$dato->nro_moviento}} </td>
            @else
            <td height="1" style="padding-top:0px; padding-bottom:0px; text-align: left;"> {{ str_pad($dato->nro_moviento, 6, "0", STR_PAD_LEFT) }} </td>
            @endif

            <td height="1" style="padding-top:0px; padding-bottom:0px;"> {{$dato->aperturaCodigo}} </td>
            <td height="1" style="padding-top:0px; padding-bottom:0px;"> {{$dato->tipo}} {{$dato->concepto}}</td>
            <td height="1" style="padding-top:0px; padding-bottom:0px; text-align: right;">{{ number_format($dato->costo, 2, ",", ".") }}</td>
            @if($dato->movimiento == "INGRESO" || $dato->movimiento == "INGRESO STOCK" )
            <td height="1" style="padding-top:0px; padding-bottom:0px; background-color:#E0E0E0; text-align: right;"> <?php  $cantidadE=round($dato->total / $dato->costo); echo $cantidadE; ?> </td>
            <?php
              $fisico = round($fisico + ($dato->total / $dato->costo));
              $valorado = $valorado + $dato->total;
            ?>
            <td height="1" style="padding-top:0px; padding-bottom:0px; text-align: right;">0 </td>
            <td height="1" style="padding-top:0px; padding-bottom:0px; text-align:right;">{{$fisico}} </td>
            @endif

            @if($dato->movimiento == "SALIDA" || $dato->movimiento == "SALIDA STOCK" )
            <td height="1" style="padding-top:0px; padding-bottom:0px; text-align: right;">0 </td>
            <td height="1" style="padding-top:0px; padding-bottom:0px; text-align: right;">0 </td>
            <td height="1" style="padding-top:0px; padding-bottom:0px; background-color:#E0E0E0; text-align: right;"> {{$dato->cantidad}} </td>
            <td height="1" style="padding-top:0px; padding-bottom:0px; background-color:#E0E0E0; text-align: right;"> <?php $totalVal=$dato->cantidad * $dato->costo ?> {{ number_format($totalVal, 2, ",", ".") }}</td>
            <?php
              $fisico = round($fisico) - $dato->cantidad;
              $valorado = $valorado - ($dato->cantidad * $dato->costo) ;
            ?>
            @endif
            <td height="1" style="padding-top:0px; padding-bottom:0px; background-color:#E0E0E0; text-align: right;">  {{ number_format($dato->total, 2, ",", ".") }} </td>
            <td height="1" style="padding-top:0px; padding-bottom:0px; text-align: right;">0 </td>
            <td height="1" style="padding-top:0px; padding-bottom:0px; text-align: right;"> {{ number_format($valorado, 2, ",", ".") }} </td>

            <?php $total = $total + (1); ?>
          </tr>
          @endif
        @endforeach
        <tr>
          <td colspan="11">
            <b> Razon de Desuso</b> </br>
            {{$dato->observacion}}
          </td>
        </tr>
        <tr>
            <td colspan="11" style="font-weight:bold; font-size:16px; text-align:right;" > Monto Total: {{ number_format($valorado, 2, ",", ".") }}</td>
            <?php $sumaTotal = $sumaTotal + $valorado; ?>
          </td>
        </tr>
    </table></br>
    @endforeach

    <p> La sumatoria de todos los montos totales es: <b>Bs. {{ number_format($sumaTotal, 2, ",", ".") }}</b></p>

  </body>
</html>
