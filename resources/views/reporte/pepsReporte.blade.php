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
      .footer {
      width: 100%;
      position: fixed;
      font-size: 10px;
      }
      .footer {
          bottom: 0px;
      }
      .pagenum:before {
          content: counter(page);
      }
    </style>
  </head>
  <body>
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
          <td><h2 style="text-align: center;"> KARDEX FISICO - VALORADO </h2></td>
        </tr>
      </table>
    </div>
    Fecha Inicio:  {{ date("d/m/Y", strtotime($fechaInicio)) }}     -        Fecha Final: {{ date("d/m/Y", strtotime($fechafinal))}}
    <?php $sumaTotal = 0; ?>
    <table width="100%" border="1" style="padding:0px; margin:0px;">
        <thead  style="border:solid 1px black; background-color:#BECCD2;">
          <th colspan="7">&nbsp</th>
          <th colspan="3">FISICO</th>
          <th colspan="3">VALORADO</th>
        </thead>
        <thead  style="border:solid 1px black; background-color:#BECCD2;">
          <th style="text-align:left;">Apertura</th>
          <th style="text-align:left;">Articulo</th>
          <th style="text-align:left;">Clasificador</th>
          <th style="text-align:left;">Fecha</th>
          <th style="text-align:left;">N° Trans.</th>
          <th style="text-align:left;">Costo Uni.</th>
          <th style="padding:0px; margin:0px;">Entrada Fis.</th>
          <th style="padding:0px; margin:0px;">Salida Fis.</th>
          <th style="padding:0px; margin:0px;">Saldos Fis.</th>
          <th style="padding:0px; margin:0px;">Entrada Val.</th>
          <th style="padding:0px; margin:0px;">Salida Val.</th>
          <th style="padding:0px; margin:0px;">Saldos Val.</th>
        </thead>
      <tbody>
      @foreach($bienes as $bien)
        <?php
          $total = 0;
          $fisico = 0;
          $valorado = 0;
          $contador = 0;
        ?>

        @foreach($datos as $dato)
          @if($bien->idBien == $dato->id_bien )
          <?php $contador++; ?>
          <tr>
            <!--<td height="1" style="padding-top:0px; padding-bottom:0px;"> {{$dato->almacen}} </td>-->
            <td height="1" style="padding-top:0px; padding-bottom:0px;"> {{$dato->aperturaCodigo}} </td>
            <td height="1" style="padding-top:0px; padding-bottom:0px;"> {{$bien->bien}}</th>
            <td height="1" style="padding-top:0px; padding-bottom:0px;"> {{$dato->clasificadorCodigo}}.{{$bien->id_almacen}}.{{$bien->codigo}} </td>
            <td height="1" style="padding-top:0px; padding-bottom:0px;"> {{date("d/m/Y", strtotime($dato->movimientoFecha))}} </td>
            <td height="1" style="padding-top:0px; padding-bottom:0px;"> {{$dato->id_movimiento}} </td>
            <td height="1" style="padding-top:0px; padding-bottom:0px;"> {{$dato->tipo}} {{$dato->concepto}}</td>
            <td height="1" style="padding-top:0px; padding-bottom:0px;"> {{ number_format($dato->costo, 2, ",", ".") }} </td>
            @if($dato->movimiento == "INGRESO" || $dato->movimiento == "INGRESO STOCK" )
              <!-- <td height="1" style="padding-top:0px; padding-bottom:0px; background-color:#E0E0E0;"> <?php // $cantidadE=round($dato->total / $dato->costo); echo $cantidadE; ?> </td> -->
              <td height="1" style="padding-top:0px; padding-bottom:0px; background-color:#E0E0E0;"> {{ $dato->cantidad_actual }} </td>
              <td height="1" style="padding-top:0px; padding-bottom:0px; background-color:#E0E0E0;"> {{ number_format($dato->total, 2, ",", ".") }}</td>
              <td height="1" style="padding-top:0px; padding-bottom:0px;">0 </td>
              <td height="1" style="padding-top:0px; padding-bottom:0px;">0 </td>
              <?php
                $fisico = round($fisico + ($dato->total / $dato->costo));
                $valorado = $valorado + $dato->total;
              ?>
            @endif
            @if($dato->movimiento == "SALIDA" || $dato->movimiento == "SALIDA STOCK" )
              <td height="1" style="padding-top:0px; padding-bottom:0px;">0 </td>
              <td height="1" style="padding-top:0px; padding-bottom:0px;">0 </td>
              <td height="1" style="padding-top:0px; padding-bottom:0px; background-color:#E0E0E0;"> {{$dato->cantidad}} </td>
              <td height="1" style="padding-top:0px; padding-bottom:0px; background-color:#E0E0E0;"> <?php $totalVal=$dato->cantidad * $dato->costo ?>{{ number_format($totalVal, 2, ",", ".") }}
              </td>
              <?php
                $fisico = round($fisico) - $dato->cantidad;
                $valorado = $valorado - ($dato->cantidad * $dato->costo) ;
              ?>
            @endif
            <td height="1" style="padding-top:0px; padding-bottom:0px;"> {{$fisico}} </td>
            <td height="1" style="padding-top:0px; padding-bottom:0px;">{{ number_format($valorado, 2, ",", ".") }}</td>
            <?php $total = $total + (1); ?>
          </tr>
          @endif
        @endforeach

        @if( $contador > 0 )
        <tr>
            <td colspan="8"></td>
            <td colspan="6" style="font-weight:bold; font-size:16px;"> Monto Total: Bs. {{ number_format($valorado, 2, ",", ".") }}</td>
            <?php $sumaTotal = $sumaTotal + $valorado; ?>
        </tr>
        @endif

        @endforeach
      </tbody>
    </table>


     <p> La sumatoria de todos los montos totales es: <b> Bs. {{ number_format( $sumaTotal, 2, ",", ".") }}</b></p>

  </body>
</html>
