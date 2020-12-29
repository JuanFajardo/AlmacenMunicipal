<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <style media="screen">
      *{
        margin: 0px;
        padding: 5px;
      }
      table {
        border-collapse: collapse;
      }
      td {
          font-size: 12px;
      }
      input{
        padding: 0px;
        margin: 0px;
      }
    </style>
  </head>
  <body style="margin-top: 30px; margin-right: 30px; margin-bottom: 30px; margin-left: 50px;">
    <div class="col-lg-12" >
          <img style="position: relative;" align="left" src="{{asset('assets/images/entidad.jpg')}}" width="80px" height="50px">
          <h5 align="center" style="position: absolute;"> CIERRE DE GESTION <br/> {{ $configuracion->entidad }} <br/>  Actualizacion del Patrimonio Institucional </h5>
    </div>
    <p>
      UFV Final: {{date('m/d/Y', strtotime($fechaFinal) ) }} = {{$ufvFinal}}
    </p>
    <table width="100%" border="0" >
      <thead   style="border:solid 1px black; background-color:#BECCD2; font-size:14px;">
        <tr>
          <th style="text-align:left;">Fecha</th>
          <th style="text-align:left;">Nro</th>
          <th style="text-align:left;">Codigo</th>
          <th style="text-align:left;">Articulo</th>
          <th style="text-align:left;">Cant.</th>
          <th style="text-align:left;">Valor<br>U. I.</th>
          <th style="text-align:left;">Valor<br>Incr. </th>
          <th style="text-align:left;">Valor<br>U. A.</th>
          <th style="text-align:left;">Valor<br>Total A.</th>
        </tr>
      </thead>
      <tbody  style="font-size:10px;">
        @foreach($movimientos as $movimiento)
          <?php $inicial=0; $incremento=0; $cantidad = 0;  $actualizado=0; $nro=1; $aceptado = false; $total=0; ?>
          @foreach($datos as $dato)
           @if($movimiento->nro_moviento == $dato->nro_moviento)
            <tr >
              <td height="1" style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;"> {{ $dato->fecha }}</td>
              <td height="1" style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black; text-align:center;"> {{ $dato->nro_moviento }}</td>
              <td height="1" style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;"> {{ $dato->codigo }}.{{ $dato->id_almacen }}.{{$dato->codigoBien}}</td>
              <td height="1" style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;"> {{ ucwords( $dato->bien )  }}</td>
              <td height="1" style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black; text-align:center;"> {{ $dato->cantidad }}</td>
              <td height="1" style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;"> {{ number_format($dato->costo_actual, 2, ",", ".") }}</td>
              <td height="1" style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;"> {{ number_format(($dato->costo - $dato->costo_actual), 2, ",", ".")}}</td>
              <td height="1" style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;"> {{ number_format($dato->costo, 2, ",", ".") }}</td>
              <td height="1" style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;"> {{ number_format(($dato->costo * $dato->cantidad), 2, ",", ".") }}</td>
              <?php
                $cantidad = $cantidad + $dato->cantidad;
                $inicial = $inicial + $dato->costo_actual;
                $incremento = $incremento + ($dato->costo - $dato->costo_actual);
                $actualizado = $actualizado + $dato->costo;
                $total = $total + ($dato->costo * $dato->cantidad);
                $nro++;
                $aceptado = true;
              ?>
            </tr>
           @endif
          @endforeach
           @if($aceptado)
            <tr style="font-weight:bold;">
                <td >Total</td>
                <td height="1" style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;"> </td>
                <td height="1" style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;"> </td>
                <td height="1" style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;"> </td>
                <td height="1" style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;"> {{ number_format($cantidad, 2, ",", ".") }}</td>
                <td height="1" style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;"> {{ number_format($inicial, 2, ",", ".") }}</td>
                <td height="1" style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;"> {{ number_format($incremento, 2, ",", ".") }}</td>
                <td height="1" style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;"> {{ number_format($actualizado, 2, ",", ".") }}</td>
                <td height="1" style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;"> {{ number_format($total, 2, ",", ".") }}</td>
              </td>
            </tr>
          @endif
          <?php $aceptado = false; ?>
        @endforeach
       </tbody>
    </table>

  </body>
</html>
