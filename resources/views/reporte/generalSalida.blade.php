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
      body{
        font-size: 12px;
      }
      table {
        border-collapse: collapse;
      }
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
  <body style="margin-top: 20px; margin-right: 20px; margin-bottom: 20px; margin-left: 30px;">
    <div class="col-lg-12">
      <table width="100%">
        <tr>
          <td><img style="position: absolute; " align="left" src="{{asset('assets/images/entidad.jpg')}}" width="48px" height="58px"> <br><span style="padding-left: 55px; ">{{ $configuracion->entidad }}</span><br></br><span style="padding-left: 55px; font-size: 14px; font-weight: bold;">UNIDAD DE ALMACENES</span></td>
          <td>
          Fecha Generacion: <?php $date = date("Y-m-d H:i:s"); echo $date?> <br></br>
          Página <span class="pagenum"></span>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <br/>
            <b>Fecha Inicio:</b>{{$fechaInicio}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <b>Fecha Fin:</b>{{$fechaFin}}
          </td>
        </tr>
        <tr>
        <td colspan="2"><h3 style="text-align: center;"> REPORTE DE MOVIMIENTOS</h3></td>
        </tr>
      </table>
    </div>
    <table border="0" width="100%">
      <thead  style="border:solid 1px black; background-color:#BECCD2;">
        <tr>
          @if(!is_null($movimiento))          <th style="text-align:left;">{{$movimiento}}</th> @endif
          @if(!is_null($nro_moviento))        <th style="text-align:left;">{{$nro_moviento}}</th> @endif
          @if(!is_null($fecha))               <th style="text-align:left;">{{$fecha}}</th> @endif
          @if(!is_null($apertura))            <th style="text-align:left;">{{$apertura}}</th> @endif
          @if(!is_null($clasificador))        <th style="text-align:left;">{{$clasificador}}</th> @endif
          @if(!is_null($rupe))                <th style="text-align:left;">{{$rupe}}</th> @endif
          @if(!is_null($codigo_pedido))       <th style="text-align:left;">{{$codigo_pedido}}</th> @endif
          @if(!is_null($orden_compra))        <th style="text-align:left;">{{$orden_compra}}</th> @endif
          @if(!is_null($glosa))               <th style="text-align:left;">{{$glosa}}</th> @endif
          @if(!is_null($tipo_factura))        <th style="text-align:left;">{{$tipo_factura}}</th> @endif
          @if(!is_null($numero_factura))      <th style="text-align:left;">{{$numero_factura}}</th> @endif
          @if(!is_null($total_factura))       <th style="text-align:left;">{{$total_factura}}</th> @endif
          @if(!is_null($otro_documento))      <th style="text-align:left;">{{$otro_documento}}</th> @endif
          @if(!is_null($movimiento_ingreso))  <th style="text-align:left;">{{$movimiento_ingreso}}</th> @endif
          @if(!is_null($ufv))                 <th style="text-align:left;">{{$ufv}}</th> @endif
          @if(!is_null($dolar))               <th style="text-align:left;">COMPRA</th> @endif
          @if(!is_null($dolar))               <th style="text-align:left;">VENTA</th> @endif

          @if(!is_null($id_concepto))         <th style="text-align:left;">{{$id_concepto}}</th> @endif
          @if(!is_null($id_proveedor))        <th style="text-align:left;">{{$id_proveedor}}</th> @endif
          @if(!is_null($id_funcionario))      <th style="text-align:left;">{{$id_funcionario}}</th> @endif
          @if(!is_null($id_usuario))          <th style="text-align:left;">{{$id_usuario}}</th> @endif

        </tr>
      </thead>
      <tbody>
        @foreach($movimientos as $movimiento)
          <tr style="background-color:#E4E4E4;">
            @if(!is_null($movimiento))          <td style="padding-top:0px; padding-bottom:0px;">{{$movimiento->movimiento}} </td> @endif
            @if(!is_null($nro_moviento))        <td style="padding-top:0px; padding-bottom:0px;">{{$movimiento->nro_moviento}}</td> @endif
            @if(!is_null($fecha))               <td style="padding-top:0px; padding-bottom:0px;">{{ date("d/m/Y", strtotime($movimiento->fecha))  }}</td> @endif
            @if(!is_null($apertura))            <th style="text-align:left;">
                                                                            @foreach($aprs as $apr)
                                                                              @if($apr->id == $movimiento->id_apertura)
                                                                                {{ $apr->apertura }}
                                                                              @endif
                                                                            @endforeach
                                                </th> @endif
            @if(!is_null($clasificador))        <th style="text-align:left;">
                                                                            @foreach($clas as $cla)
                                                                              @if($cla->id == $movimiento->id_clasificador)
                                                                                {{ $cla->clasificador }}
                                                                              @endif
                                                                            @endforeach
                                                </th> @endif
            @if(!is_null($rupe))                <td style="padding-top:0px; padding-bottom:0px;">{{$movimiento->rupe}}</td> @endif
            @if(!is_null($codigo_pedido))       <td style="padding-top:0px; padding-bottom:0px;">{{$movimiento->codigo_pedido}}</td> @endif
            @if(!is_null($orden_compra))        <td style="padding-top:0px; padding-bottom:0px;">{{$movimiento->orden_compra}}</td> @endif
            @if(!is_null($glosa))               <td style="padding-top:0px; padding-bottom:0px;">{{$movimiento->glosa_entrada}} {{$movimiento->glosa_salida}}</td> @endif
            @if(!is_null($tipo_factura))        <td style="padding-top:0px; padding-bottom:0px;">{{$movimiento->tipo_factura}}</td> @endif
            @if(!is_null($numero_factura))      <td style="padding-top:0px; padding-bottom:0px;">{{$movimiento->numero_factura}}</td> @endif
            @if(!is_null($total_factura))       <td style="padding-top:0px; padding-bottom:0px;">
            {{ number_format($movimiento->total_factura, 2, ",", ".") }}</td> @endif
            @if(!is_null($otro_documento))      <td style="padding-top:0px; padding-bottom:0px;">{{$movimiento->otro_documento}}</td> @endif
            @if(!is_null($movimiento_ingreso))  <td style="padding-top:0px; padding-bottom:0px;">{{$movimiento->movimiento_ingreso}}</td> @endif
            @if(!is_null($ufv))                 <td style="padding-top:0px; padding-bottom:0px;">{{$movimiento->ufv}}</td> @endif

            @if(!is_null($dolar))               <td style="padding-top:0px; padding-bottom:0px;">{{$movimiento->compra}}</td> @endif
            @if(!is_null($dolar))               <td style="padding-top:0px; padding-bottom:0px;">{{$movimiento->venta}}</td> @endif

            @if(!is_null($id_concepto))         <td style="padding-top:0px; padding-bottom:0px;">{{$movimiento->concepto}}</td> @endif
            @if(!is_null($id_proveedor))        <td style="padding-top:0px; padding-bottom:0px;">{{$movimiento->proveedor}}</td> @endif
            @if(!is_null($id_funcionario))      <td style="padding-top:0px; padding-bottom:0px;">{{$movimiento->nombres}} {{$movimiento->paterno}} {{$movimiento->materno}}</td> @endif
            @if(!is_null($id_usuario))          <td style="padding-top:0px; padding-bottom:0px;">{{$movimiento->name}}</td> @endif
          </tr>

          @if( !is_null($articulo)  || !is_null($unidad) )
            <tr>
              <td colspan="{{ $colspan }}"  style="padding-top:0px; padding-bottom:0px;">
                <table border="0" width="80%">
                  <thead  style="border:solid 1px black;">
                    <tr>
                      <th style="padding-top:0px; padding-bottom:0px;" style="text-align:left;">Artiulo</th>
                      <th style="padding-top:0px; padding-bottom:0px;" style="text-align:left;">Canidad</th>
                      <th style="padding-top:0px; padding-bottom:0px;" style="text-align:left;">Costo Unidad</th>
                      <th style="padding-top:0px; padding-bottom:0px;" style="text-align:left;">Costo Total</th>
                      <th style="padding-top:0px; padding-bottom:0px;" style="text-align:left;">Unidad</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($articulosLista as $al)
                    @if($al->id_movimiento == $movimiento->idMovimientoPrincipal)
                    <tr>
                      <td style="padding-top:0px; padding-bottom:0px;">{{$al->bien}}</td>
                      <td style="padding-top:0px; padding-bottom:0px;">{{$al->cantidad}}</td>
                      <td style="padding-top:0px; padding-bottom:0px;">
                      {{ number_format($al->costo, 2, ",", ".") }}</td>
                      <td style="padding-top:0px; padding-bottom:0px;">
                      {{ number_format($al->total_actual, 2, ",", ".") }}</td>
                      <td style="padding-top:0px; padding-bottom:0px;">
                      {{ number_format($al->unidad, 2, ",", ".") }}}</td>
                    </tr>
                    @endif
                    @endforeach
                  </tbody>
                </table>
              </td>
            </tr>
          @endif

        @endforeach
      </tbody>
    </table>

  </body>
</html>
