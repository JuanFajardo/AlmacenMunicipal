@extends('sisoftComBo')

@section('reportes')
active
@endsection

@section('reportes2')
active
@endsection


@section('contenido')
<div class="warper container-fluid">
  <div class="row">
        <h3 class="md-offset-5"><i class="fa fa-indent"></i>  REPORTE KARDEX E INVENTARIO FISICO - VALORADO</h3>
    <div class="panel-body">

      {!! Form::open(['accept-charset'=>'UTF-8', 'method'=>'POST', 'url'=>'/Reportes/peps',  'autocomplete'=>'off', 'id'=>'form-insert'] ) !!}
      <div class="row">
        <div class="col-md-2">
          <label> Gestion  </label>
            {!! Form::select('gestion',      \App\Gestiones::lists('gestion', 'id'), null, ['class'=>'form-control']) !!}
        </div>
        <div class="col-md-8">
          <label>Bienes</label>
          <input type="text" name="id_articulo"  list="bienes"  placeholder="Eliga un Bien" class="form-control" >
          <datalist id="bienes">
              @foreach($bienes as $bien)
                <option value="{{$bien->bien}}">
              @endforeach
          </datalist>
        </div>
      </div>

      <div class="row">
        <div class="col-md-3">
          <label> Almacen</label>
          <input type="text" name="id_almacen"  list="almacenes" placeholder="Eliga un almacen" class="form-control" required >
          <datalist id="almacenes">
            @foreach($almacenes as $almacen)
              <option value="{{$almacen->almacen}}">
            @endforeach
          </datalist>
        </div>
        <div class="col-md-3">
          <label>Fecha Inicio</label>
            <div class='input-group date' class="form-group col-lg-4" >
              <input type='text' class="form-control" required name="fecha_inicio" id="fecha_inicio"/>
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
        <div class="col-md-3">
          <label>Fecha Final</label>
            <div class='input-group date' class="form-group col-lg-4" >
              <input type='text' class="form-control" required name="fecha_fin" id="fecha_fin"/>
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-3" style="padding-top:10px;">
          <button type="submit" formtarget="_blank" name="button" value="inmediato" class="btn btn-info">
          <i class="fa fa-file-pdf-o"></i> Kardex - Inmediato</button>
        </div>
        <div class="col-md-3" style="padding-top:10px;">
          <button type="submit" formtarget="_blank" name="button" value="stock" class="btn btn-primary">
          <i class="fa fa-file-pdf-o"></i> Kardex -  Stock</button><br>
        </div>
        <div class="col-md-3" style="padding-top:10px;">
          <button type="submit" formtarget="_blank" name="button" value="fisicoValorado" class="btn btn-success">
          <i class="fa fa-file-pdf-o"></i> Kardex Fisico Valorado</button><br>
          <a href="" >
        </div>
      </div>

      <div class="row" style="margin-top:50px;">

          <h3 align="left"><b>KARDEX FÍSICO VALORADO</b></h4>
             <table width="100%" class="table table-striped" border="1px" style="font-size:12px;">
                <thead>
                  <tr bgcolor="#F44336">
                    <td colspan="6" bgcolor="#D32F2F" width="2%" style="color: white;"></td>
                    <td colspan="3" bgcolor="#D32F2F" width="2%" style="color: white; text-align:center;">FÍSICO</td>
                    <td colspan="3" bgcolor="#D32F2F" width="2%" style="color: white; text-align:center;">VALORADO</td>
                  </tr>
                  <tr bgcolor="#F44336">
                    <td width="2%" bgcolor="#D32F2F" width="2%" style="color: white;" style="text-align:left;">Nro.</td>
                    <td width="10%" bgcolor="#D32F2F" width="2%" style="color: white;" style="text-align:left;">Apertura</td>
                    <td width="10%" bgcolor="#D32F2F" width="2%" style="color: white;" style="text-align:left;">Código</td>
                    <td width="10%" bgcolor="#D32F2F" width="2%" style="color: white;" style="text-align:left;">Unidad</td>
                    <td width="30%" bgcolor="#D32F2F" width="2%" style="color: white;" style="text-align:left;">Artículo</td>
                    <td width="5%" bgcolor="#D32F2F" width="2%" style="color: white;" style="text-align:left;">Precio</td>
                    <td width="5%" bgcolor="#D32F2F" width="2%" style="color: white;" style="padding:0px; margin:0px;">Entrada</td>
                    <td width="5%" bgcolor="#D32F2F" width="2%" style="color: white;" style="padding:0px; margin:0px;">Salida</td>
                    <td width="5%" bgcolor="#D32F2F" width="2%" style="color: white;" style="padding:0px; margin:0px;">Saldo</td>
                    <td width="5%" bgcolor="#D32F2F" width="2%" style="color: white;" style="padding:0px; margin:0px;">Entrada</td>
                    <td width="5%" bgcolor="#D32F2F" width="2%" style="color: white;" style="padding:0px; margin:0px;">Salida</td>
                    <td width="5%" bgcolor="#D32F2F" width="2%" style="color: white;" style="padding:0px; margin:0px;">Saldo</td>
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
                    <td colspan="5">&nbsp;</td>
                    <td colspan="4" style="border:none; font-weight:bold; text-align:left; padding-right:15px;"><b>{{$apertura->codigo}} - {{$apertura->apertura}}</b></td>
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
                <tr style="border:none;"><td style="border:none; font-weight:bold; font-size:18px;" colspan="12">  Total de Kardex Valorado: Bs. {{ number_format($gtotal, 2, ",", ".") }}</td></tr>
              </tbody>
            </table>


      </div>
      {!! Form::close() !!}




    </div>
  </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
  $(document).ready(function(){
    $.fn.datetimepicker.defaults.language = 'es';
  });


  $(function () {
    $('#fecha_inicio').datetimepicker({ format: 'YYYY/MM/DD'});
  });
  $(function () {
    $('#fecha_fin').datetimepicker({ format: 'YYYY/MM/DD'});
  });

  $(document).ready(function(){
      $('#datos').DataTable({
          "order": [[ 0, 'desc']],
          "language": {
              "bDeferRender": true,
              "sEmtpyTable": "No hay registros",
              "decimal": ",",
              "thousands": ".",
              "lengthMenu": "Mostrar _MENU_ datos por registros",
              "zeroRecords": "No se encontro nada,  lo siento",
              "info": "Mostrar paginas [_PAGE_] de [_PAGES_]",
              "infoEmpty": "No hay entradas permitidas",
              "search": "Buscar ",
              "infoFiltered": "(Busqueda de _MAX_ registros en total)",
              "oPaginate":{
                  "sLast":"Final",
                  "sFirst":"Principio",
                  "sNext":"Siguiente",
                  "sPrevious":"Anterior"
              }
          }
      });
  });
</script>

@endsection
