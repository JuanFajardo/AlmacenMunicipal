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
          <h3> INVENTARIO GLOBAL FÍSICO VALORADO </h3>
          <span style="font-size:8px;">(Expresado en Bolivianos)</span></b><br>
           Gestion: {{$gestion->gestion}}
        </td>
      </tr>
    </table>
    <table width="100%" class="table table-striped" border="1px" style="font-size:12px;">
       <thead>
         <tr>
           <td colspan="6" bgcolor="#CFD8DC" width="2%" style="color: black;"></td>
           <td colspan="3" bgcolor="#CFD8DC" width="2%" style="color: black; text-align:center;">FÍSICO</td>
           <td colspan="3" bgcolor="#CFD8DC" width="2%" style="color: black; text-align:center;">VALORADO</td>
         </tr>
         <tr>
           <td width="2%" bgcolor="#CFD8DC" style="color: black;" style="text-align:left;">Nro.</td>
           <td width="6%" bgcolor="#CFD8DC" style="color: black;" style="text-align:left;">Apertura</td>
           <td width="6%" bgcolor="#CFD8DC" style="color: black;" style="text-align:left;">Código</td>
           <td width="5%" bgcolor="#CFD8DC" style="color: black;" style="text-align:left;">Unidad</td>
           <td width="42%" bgcolor="#CFD8DC" style="color: black;" style="text-align:left;">Artículo</td>
           <td width="5%" bgcolor="#CFD8DC" style="color: black;" style="text-align:left;">Precio</td>
           <td width="5%" bgcolor="#CFD8DC" style="color: black;" style="padding:0px; margin:0px;">Entrada</td>
           <td width="5%" bgcolor="#CFD8DC" style="color: black;" style="padding:0px; margin:0px;">Salida</td>
           <td width="7%" bgcolor="#CFD8DC" style="color: black;" style="padding:0px; margin:0px;">Saldo</td>
           <td width="5%" bgcolor="#CFD8DC" style="color: black;" style="padding:0px; margin:0px;">Entrada</td>
           <td width="5%" bgcolor="#CFD8DC" style="color: black;" style="padding:0px; margin:0px;">Salida</td>
           <td width="7%" bgcolor="#CFD8DC" style="color: black;" style="padding:0px; margin:0px;">Saldo</td>
         </tr>
       </thead>
       <tbody>
       <?php $i=0; $suma=0; ?>
       <?php $total = $totalP = $gtotal = 0; ?>
       @foreach($aperturas as $apertura)
         <?php $subtotal =  $entradaFisico = $salidaFisico = $saldoFisico = $entradaValorado = $salidaValorado = $saldoValorado = 0; ?>
           @foreach($datos as $dato)
             @if($apertura->id == $dato->idApertura)
               <?php $i++; ?>
               <tr style="color:#212121;">
                 <td style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;" > {{ $i }} </td>
                 <td style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;" > {{ $dato->codigoApertura }}</td>
                 <td style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;" > {{$dato->clasificadorcodigo}}.{{$dato->id_almacen}}.{{$dato->BienCod}}</td>
                 <td style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;" > {{ $dato->unidad }} </td>
                 <td style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black;" > {{$dato->bien}}</td>
                 <td style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black; text-align: right;"> {{ number_format($dato->costo, 2, ",", ".") }}  </td>
                 <td style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black; text-align: right;"> <?php $entrada =$dato->cantidad_actual; ?> {{$entrada}} </td>
                 <td style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black; text-align: right;"> <?php $salida =$dato->cantidad_actual - $dato->cantidad; ?> {{$salida}} </td>
                 <td height="1" style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black; text-align: right;"> {{$dato->cantidad}} </td>
                 <!--<td style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black; text-align: right;"> {{ number_format($dato->costo, 2, ",", ".") }}  </td> -->
                 <td style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black; text-align: right;"> <?php $entradaV=$dato->cantidad_actual * $dato->costo; ?> {{ number_format($entradaV, 2, ",", ".") }} </td>
                 <td style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black; text-align: right;"> <?php $salidaV=$salida * $dato->costo; ?>  {{ number_format($salidaV, 2, ",", ".") }} </td>
                 <td height="1" style="padding-top:0px; padding-bottom:0px; border-bottom:solid 1px black; text-align: right;"><?php $datoss=$dato->costo * $dato->cantidad;?> {{ number_format($datoss, 2, ",", ".") }} </td>
                 <?php $total = $total + ($dato->costo * $dato->cantidad);
                       $totalP = $totalP + $dato->cantidad;
                       $subtotal = $subtotal + $datoss;
                       $entradaValorado = $entradaValorado + $entradaV;
                       $salidaValorado = $salidaValorado + $salidaV;
                       $saldoValorado = $saldoValorado + $datoss;
                 ?>
               </tr>
              @endif
           @endforeach
         <tr>
           <td colspan="4" style="text-align: right;"></td>
           <td colspan="5" style="text-align: left; border:none;"><b>{{$apertura->codigo}} - {{$apertura->apertura}}</b></td>
           <td style="text-align: right; font-weight:bold; background-color:#CFD8DC;"> {{ number_format($entradaValorado, 2, ",", ".") }} </td>
           <td style="text-align: right; font-weight:bold; background-color:#CFD8DC;"> {{ number_format($salidaValorado, 2, ",", ".") }} </td>
           <td style="text-align: right; font-weight:bold; background-color:#CFD8DC;"> {{ number_format($saldoValorado, 2, ",", ".") }} </td>
         </tr>
         <?php
           $gtotal=$gtotal + $subtotal;
         ?>
       @endforeach
       <tr style="border:none;"><td style="border:none;" colspan="12">&nbsp;</td></tr>
       <tr style="border:none;"><td style="border:none;" colspan="12">&nbsp;</td></tr>
       <tr style="border:none;"><td style="border:none; font-weight:bold; font-size:18px; text-align: right;" colspan="12">  Total de Kardex Valorado: Bs. {{ number_format($gtotal, 2, ",", ".") }}</td></tr>
     </tbody>
    </table>
    </table>

  </body>
</html>
