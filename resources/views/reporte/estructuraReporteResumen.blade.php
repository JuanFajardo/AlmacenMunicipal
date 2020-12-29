<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <style media="screen">
      *{
        margin: 0px;
        padding: 10px;
      }
      body{
        position: relative;
        color: #222;
        font-family: "Helvetica", Arial, Verdana, sans-serif;
        font-size: 12px;
        line-height: 1.4;
      }table {
        border-collapse: collapse;
        padding: 0px;
      }
      thead{display: table-header-group;}
      tfoot {display: table-row-group;}
      tr {page-break-inside: avoid;}
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
          <h3> REPORTE DE SUMINISTROS Y MATERIALES  </BR> UNIDADES ADMINISTRATIVA</h3>
          <span style="font-size:8px;">(Expresado en Bolivianos)</span></b><br>
           {{ date("d/m/Y", strtotime($fechaInicio)) }} - {{ date("d/m/Y", strtotime($fechaFin)) }}
        </td>
      </tr>
    </table>
  </div>
    <table width="100%" border="1" >
      <thead style="background-color:#BECCD2;">
        <tr>
          <th style="text-align:left;">Unidad Administrativa</th>
          <th style="text-align:right;">Cantidad Salidas</th>
          <th style="text-align:right;">Valor Salidas</th>
        </tr>
      </thead>
      <tbody>
        <?php $total = 0; ?>
        @foreach($datos as $dato)
          <tr >
            <td height="1" style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;"> {{ $dato->codigoEstructura }} - {{ $dato->estructura }}</td>
            <td height="1" style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black; text-align: right;">  {{ $dato->cantidad }} </td>
            <td height="1" style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black; text-align: right;"> {{ number_format($dato->total, 2, ",", ".") }}</td>
            <?php //$total = $total + ($dato->costo * $dato->cantidad);
                  $total = $total + ($dato->total);
            ?>
          </tr>
        @endforeach
        <tr >
            <td colspan="9" style="font-weight:bold; font-size:16px;"> Monto Total: Bs. {{ number_format($total, 2, ",", ".") }}.</td>
          </td>
        </tr>
      </tbody>
    </table>

  </body>
</html>
