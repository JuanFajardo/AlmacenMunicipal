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
           <b>USUARIO:</b> {{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}} </br>
           {{$almacen->almacen}}
        </td>
      </tr>
    </table>
    <table width="100%">
      <tr style="text-align: center;">
        <td>
          <h3>REPORTE DE SUMINISTROS Y MATERIALES  </BR> PROVEEDOR</h3>
          <span style="font-size:8px;">(Expresado en Bolivianos)</span></b><br>
           {{ date("d/m/Y", strtotime($fechaInicio)) }} - {{ date("d/m/Y", strtotime($fechaFin)) }}
        </td>
      </tr>
    </table>
    </div>
    <table width="100%" border="1" >
      <thead style="background-color:#BECCD2;">
          <tr>
            <th>Fecha </th>
            <th>Nro Movimiento </th>
            <th>Proveedor </th>
            <th>NIT </th>
            <th>Glosa</th>
            <th>Tipo</th>
            <th>Factura</th>
            <th>Monto Total</th>
          </tr>
        </thead>
      </thead>
      <tbody>
        <?php $total = 0; ?>
        @foreach($datos as $dato)
          <tr >
            <td style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;">  {{ date("d/m/Y", strtotime($dato->fecha)) }}</td>
            <td style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;">
              @if($dato->movimiento == 'INGRESO')
                {{ str_pad($dato->nro_moviento, 6, "0", STR_PAD_LEFT) }}
              @else
                {{ $dato->nro_moviento }}
              @endif
            </td>
            <td width="25%" style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;">  {{ $dato->proveedor }}</td>
            <td style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;">  {{ $dato->nit }}</td>
            <td width="40%" style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;">  {{ $dato->glosa_entrada}}</td>
            <td style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black; "> {{ $dato->tipo_factura}}</td>
            <td style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black; "> {{ $dato->numero_factura}}</td>
            <td style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black; text-align: right;">{{ number_format($dato->total_factura, 2, ",", ".") }}</td>
            <?php //$total = $total + ($dato->costo * $dato->cantidad);
                  $total = $total + ($dato->total_factura);
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
