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
           <b>USUARIO:</b> {{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}} </br>
           {{$almacen->almacen}}
        </td>
      </tr>
    </table>
    <table width="100%">
      <tr style="text-align: center;">
        <td>
          <h3> INVENTARIO FISICO DE MATERIALES Y SUMINISTROS - {{$reporteMovimiento}}  </h3>
          <span style="font-size:8px;">(Expresado en Bolivianos)</span></b><br>
           {{ date("d/m/Y", strtotime($fechaInicio)) }} - {{ date("d/m/Y", strtotime($fechaFin)) }}
        </td>
      </tr>
    </table>
     <table width="100%" border="1">
        <thead style="background-color:#BECCD2;">
          <th width="5%" style="text-align:left;">Fecha</th>
          <th width="5%" style="text-align:left;">Mov.</th>
          <th width="9%" style="text-align:left;">Apertura</th>
          <th width="9%" style="text-align:left;">Codigo</th>
          <th width="40%" style="text-align:left;">Articulo</th>
          <th width="6%" style="text-align:left;">Unidad</th>
          <th width="6%" style="text-align:center;">Prec. Unit.</th>
          <th width="6%" style="text-align:center;">Entrada</th>
          <th width="6%" style="text-align:center;">Salida</th>
          <th width="6%" style="text-align:center;">Saldo</th>
          <!--<th width="10%" style="text-align:center;">Total Valorado</th>-->
        </thead>
      <tbody >
        <?php $subtotal = 0; $datoss=0;?>
        @foreach($aperturas as $apertura)
        <?php $total =0;  ?>
          @foreach($datos as $dato)
            @if($dato->movimiento == $reporteMovimiento)
              @if($apertura->id == $dato->idApertura)
                <tr>
                  <td style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;" > {{ date("d/m/Y", strtotime( $dato->fechaMovimiento )) }} </td>
                  <td style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;" > {{ $dato->nro_moviento }} </td>
                  <td style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;" > {{ $dato->codigoApertura }}</td>
                  <td style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;" > {{$dato->clasificadorcodigo}}.{{$dato->id_almacen}}.{{$dato->codBien}}</td>
                  <td style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;" > {{$dato->bien}}</td>
                  <td style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;" > {{$dato->unidad}}</td>
                  <td style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black; text-align: right;"> {{ number_format($dato->costo, 2, ",", ".") }}  </td>
                  <td style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black; text-align: right;"> <?php $entrada=round($dato->total/$dato->costo); ?> {{$entrada}} </td>
                  <td style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black; text-align: right;"> <?php $salida=round($dato->total/$dato->costo) - $dato->cantidad; ?> {{$salida}} </td>
                  <td height="1" style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black; text-align: right;"> {{$dato->cantidad}} </td>
                  <!--<td height="1" style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black; text-align: right;">-->
                   <?php $datoss=$dato->costo * $dato->cantidad;
                   ?> {{-- number_format($datoss, 2, ",", ".") --}} </td>
                  <?php
                        $total = $total + $datoss;
                  ?>
                </tr>
              @endif
            @endif
          @endforeach
          <!--<tr style="border:none;">
            <td  colspan="4" style="border:none; font-weight:bold; text-align:right; padding-right:15px; background-color:#e5e5e5"></td>
            <td  colspan="4" style="border:none; font-weight:bold; text-align:left; padding-right:15px; background-color:#e5e5e5"> <b>{{$apertura->codigo}} - {{$apertura->apertura}}</b></td>
            <td  colspan="2" style="border:none; font-weight:bold; background-color:#cccccc;"> <b>Subtotal Bs.</b></td>
            <td  colspan="1" style="border:none; font-weight:bold; background-color:#cccccc; text-align:right;"> <b>{{ number_format($total, 2, ",", ".") }}</b></td>
          </tr>-->
          <tr style="border:none;"><td  style="border:none;" colspan="11">&nbsp;</td></tr>
          <?php
              $subtotal = $subtotal + $total;
            ?>
        @endforeach
        <!--<tr style="border:none;"><td  style="border:none;" colspan="11">&nbsp;</td></tr>
        <tr style="border:none;"><td  style="border:none;" colspan="11">&nbsp;</td></tr>
        <tr  style="border:none;">
          <td colspan="6" style="border:none; font-weight:bold; font-size:18px; background-color:#cccccc;"></td>
          <td colspan="3" style="border:none; font-weight:bold; font-size:18px; background-color:#cccccc;">Total Bs.</td>
          <td colspan="2" style="border:none; font-weight:bold; font-size:18px; background-color:#cccccc; text-align:right;">{{ number_format($subtotal, 2, ",", ".") }}</td>
        </tr>-->
      </tbody>
    </table>

  </body>
</html>
