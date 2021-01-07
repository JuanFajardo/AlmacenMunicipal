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
      input{
        padding: 0px;
        margin: 0px;
      }
      div{
        width: 100%;
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

      #contenedor{
        margin:auto;
        width:100%;
        height:965px;
        position: static;
      }

      #cabecera{
        /*background-color: green;*/
        margin:auto;
        width:100%;
        position: static;
        float:left;
      }

      #cuerpo{
        /*background-color:red;*/
        margin:auto;
        width:100%;
        position: static;
        float:left;
      }

      #piedepagina{
        width:100%;
        height:150px;
        position: static;
        clear: both;
     }

      @if($eliminacion != '')
      body {
          background-image: url( {{asset("assets/images/bg/eliminadoBg.png")}} );
          background-color: #fff;
          background-repeat: no-repeat;
          background-position: center top;
          background-attachment: fixed;
      }
      @endif

    </style>
  </head>
  <body>
  @foreach($datos as $dato)
  @endforeach
  <div id="contenedor">

    <div id="cabecera">
      <table width="100%">
        <tr>
          <td>
            <style type="text/css"> img{padding: 0px; position: absolute;} td{ padding:0px; }</style>
            <img src="{{asset('assets/images/entidad.jpg')}}" width="48px" height="58px">

          <style type="text/css">
            br{ padding: 0px; }
          </style>
            <b style="padding-left: 50px;">{{ $configuracion[0]->entidad }} </b> <br>
            <b style="font-size: 16px; padding-left: 80px;">UNIDAD DE ALMACEN</b>
          </td>
          <td align="rigth">
             <b>USUARIO:</b> {{ $dato->nombreCompleto }}
          </td>
        </tr>
      </table>
      <table width="100%">
        <tr>
          <td><h2 style="text-align: center;"> NOTA DE {{ $movimientoDato->movimiento }} NRO. {{ $movimientoDato->nro_moviento }}</h2></td>
        </tr>
      </table>
    </div>

    <div id="cuerpo">
        <table width="100%" style=" padding: 1px;  border-collapse: collapse;" >
          <style type="text/css">
            td.uno{
              padding: 6px;
              text-align: left;
              border-bottom: 1px solid #ddd;
            }
          </style>
          <tr>
            <td colspan="4" class="uno">
              <label> <b>Fecha:</b> </label>{{ date("d/m/Y", strtotime($movimientoDato->fecha))}}
            </td>
            <!--
            <td class="uno" align="right">
              <label> <b>Motivo:</b></label> {{ $dato->concepto }}
            </td>
          -->
          </tr>
          <!--
          <tr>
            @if( !empty($movimientoDato->codigo_informe))
              <td  class="uno" colspan="2"><label> <b>Nro. de Informe:</b> </label>{{$movimientoDato->codigo_informe}}</td>
            @endif
            @if( !empty ($movimientoDato->orden_compra))
            <td class="uno" colspan="2"><label> <b>Nro. de Compra:</b> </label>{{$movimientoDato->orden_compra}}</td>
            @endif
            @if( !empty($movimientoDato->rupe))
            <td class="uno" colspan="4"><label> <b>RUPE:</b> </label>{{$movimientoDato->rupe}}</td>
            @endif
          </tr>
          @if( !empty($movimientoDato->otro_documento))
            <tr>
               <td class="uno" colspan="8"><label> <b>Otros Documentos:</b> </label>{{$movimientoDato->otro_documento}}</td>
            </tr>
          @endif
        -->
          @if( !empty($movimientoDato->codigo_pedido))
            <tr>
              <td  class="uno" colspan="8"><label> <b>Nro. de Pedido:</b> </label> {{$movimientoDato->codigo_pedido}}</td>
            </tr>
            @endif
          </tr>

          <tr>
            <td colspan="5" class="uno"><label> <b>Apertura Programatica: </b> </label> <br>
              @foreach($aperturasMovimientos as $apertura)
                  {{$apertura->codigo}} - {{$apertura->apertura}}<br>
                  <b>FTE:</b> {{$apertura->fuente_codigo}} <br>
                  <b>Org.:</b> {{$apertura->organismo_codigo}} <br>
              @endforeach
            </td>
          </tr>
          <!--
          <tr>
            <td colspan="5" class="uno">
              <label> <b>Partida Clasificatoria: </b></label> <br>
              @foreach($clasificadoresMovimientos as $clasificador)
                {{$clasificador->codigo}} - {{$clasificador->clasificador}} <br>
              @endforeach
            </td>
          </tr>
        -->
          <tr>
            <td colspan="2" class="uno"> <b>Proveedor : </b> {{$dato->proveedor}} </td>
            <td colspan="2" class="uno"> <b>Representante : </b>{{$dato->responsable}} </td>
            <td class="uno"> <b>NIT : </b> {{$dato->nit}} </td>
          </tr>
          <tr>
             <td colspan="2" style="padding: 8px;
              text-align: left;"> <b> {{$movimientoDato->tipo_factura}} No.: </b> {{$movimientoDato->numero_factura}}  </td>
             <td colspan="2" style="padding: 8px;
              text-align: left;"> <b>Monto:</b> {{ number_format($movimientoDato->total_factura, 2, ",", ".") }}
              </td>
           </tr>
        </table>


      <table width="100%" border="1" >
        <thead   style="border:solid 1px black; background-color:#BECCD2;">
          <tr>
            <td style="text-align:center;" colspan="8"><b>Artículos</td>
          </tr>
          <tr>
            <td style="text-align:center;"><b>Nro</td>
            <td style="text-align:center;"><b>Apertura</td>
            <td style="text-align:center;"><b>Código</td>
            <td style="text-align:center;"><b>Detalle</td>
            <td style="text-align:center;"><b>Unidad</td>
            <td style="text-align:center;"><b>Prec. Unit</td>
            <td style="text-align:center;"><b>Cantidad</td>
            <td style="text-align:center;"><b>Monto Total</td>
          </tr>
        </thead>
          <?php $i=0; $suma=0; ?>
          @foreach($datos as $dato)
             <?php $i++; ?>
             <tr>
              <td align="center">{{$i}}</td>
              <td>{{$dato->aperturacodigo}}</td>
              <td height="1" style="padding-top:0px; padding-bottom:0px; text-align: left;"> {{$dato->clasificadorcodigo}}.{{$dato->id_almacen}}.{{$dato->codigo}} </td>
               <td height="1" style="padding-top:0px; padding-bottom:0px; "> {{$dato->bien}} </td>
               <td height="1" style="padding-top:0px; padding-bottom:0px; "> {{$dato->unidad}} </td>
               <td height="1" style="padding-top:0px; padding-bottom:0px;  text-align:right;">
               {{ number_format($dato->costo, 2, ",", ".") }}</td>
               <td height="1" style="padding-top:0px; padding-bottom:0px; text-align:right; "> {{$dato->cantidad_actual}} </td>
               <td height="1" style="padding-top:0px; padding-bottom:0px; text-align:right; ">
               {{ number_format($dato->total, 2, ",", ".") }}</td>
            </tr>
            <?php $suma=$suma+ $dato->total?>
          @endforeach
          <tr><td colspan="8" style="text-align: right;"> <b>Total :
              {{ number_format( $suma, 2, ",", ".") }}
          </td></tr>
      </table>
    </div>
  </div>

   <div id="piedepagina">
    <table width="100%" border="1">
      <tr>
        <td width="50%">
            <table  width="100%">
              <tr><td> <label><b>Glosa</b></label><br>{{$dato->glosa_entrada}} {{$dato->glosa_salida}} <br><br><br><br><br><br></td></tr>
            </table>
        </td>
        <td width="50%">
            <table width="100%">
              <tr><td colspan="2"><label><b>Firmas</label> <br></br><br></br><br><br><br><br></td></tr>
              <tr>
                <td width="50%" style="text-align: center;">Resp. de Adquisiciones</td>
                <td width="50%" style="text-align: center;">Resp. de Almacen</td>
                <br>
              </tr>
            </table>
        </td>
      </tr>
    </table>
  </div>

 </div>

</body>
</html>
