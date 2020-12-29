@extends('sisoftComBo')

@section('reportes')
active
@endsection

@section('reportes3')
active
@endsection


@section('contenido')
<div class="warper container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <h3><i class="fa fa-book"></i> Inventario Fisico de Materiales y Suministros</h3>

      {!! Form::open(['url'=>'/Reportes/catalogo', 'autocomplete'=>'off', 'method'=>'post']) !!}

      <div class="row">
        <div class="col-md-2">
          <label>Almacenes</label>
          <input type="text" name="id_almacen" required list="almacenes"  placeholder="Eliga un almacen" class="form-control"  >
          <datalist id="almacenes">
            @foreach($almacenes as $almacen)
              <option value="{{$almacen->almacen}}">
            @endforeach
          </datalist>
        </div>

        <div class="col-md-4">
          <label>Aperturas</label>
          <input type="text" name="id_apertura" id="id_apertura" list="aperturas"  placeholder="Eliga un Bien" class="form-control" >
          <datalist id="aperturas">
            @foreach($aperturas as $apertura)
              <option value="{{$apertura->id}}-  {{$apertura->codigo}} {{$apertura->apertura}}">
            @endforeach
          </datalist>
        </div>

        <div class="col-md-4">
          <label>Bienes</label>
          <input type="text" name="id_bien"  list="bienes"  placeholder="Eliga un Bien" class="form-control" >
          <datalist id="bienes">

          </datalist>
        </div>
      </div>

      <div class="row">
        <div class="col-md-2">
          <label> Gestion  </label>
          {!! Form::select('gestion', \App\Gestiones::lists('gestion', 'id'), null, ['class'=>'form-control']) !!}
        </div>

        <div class="col-md-4">
            <label>Fecha Inicio</label>
            <div class='input-group date' >
              <input type='text' class="form-control" name="fecha_inicio" id="fecha_inicio" required>
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
        </div>

        <div class="col-md-4">
            <label>Fecha Final</label>
            <div class='input-group date' >
              <input type='text' class="form-control" name="fecha_fin" id="fecha_fin" required>
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-3"  style="padding-top:10px;">
          <button type="submit" name="button" class="btn btn-primary" formtarget="_blank" value="stock"> <i class="fa fa-file-pdf-o"></i> Inventario Fisico Ingreso Stock </button>
        </div>
        <div class="col-md-3"  style="padding-top:10px;">
          <button type="submit" name="button" class="btn btn-danger" formtarget="_blank" value="inmediato"> <i class="fa fa-file-pdf-o"></i> Inventario Fisico Ingreso Inmediato</button>
        </div>
      </div>
      {!! Form::close() !!}
      <br><br>
      <h4 align="left"><b>Consulta rápida de artículos en stock:</b></h4>
      <table class="one class" id="datos" width="100%" >
        <thead >
          <tr>
            <th width="2%">Fecha</th>
            <th width="5%">Nro. Mov.</th>
            <th width="15%">Apertura</th>
            <th width="3%">Codigo</th>
            <th width="15%">Articulo</th>
            <th width="3%">Unidad</th>
            <th width="3%">Prec. Unit</th>
            <th width="3%">Entrada</th>
            <th width="3%">Salida</th>
            <th width="3%">Saldo</th>
            <!--<th width="5%">Monto Total</th>-->
          </tr>
        </thead>
        <tbody>
          <?php $total = 0; ?>
          @foreach($datos as $dato)
            <tr>
              <td style="text-align:left;"> {{ date("d/m/Y", strtotime($dato->fechaMovimiento) ) }}</td>
              <td style="text-align:left;"> {{ $dato->nro_moviento }}</td>
              <td style="text-align:left;"> {{ $dato->codigoApertura }} {{ $dato->apertura }} </td>
              <td style="text-align:left;"> {{ $dato->clasificadorcodigo }}.{{ $dato->id_almacen }}.{{ $dato->id_bien }}</td>
              <td style="text-align:left;"> {{ $dato->bien }}</td>
              <td style="text-align:left;"> {{ $dato->unidad }}</td>
              <td> {{ number_format($dato->costo, 2, ",", ".") }} </td>
              <td> <?php $entrada=round($dato->total/$dato->costo); ?> {{$entrada}}</td>
              <td> <?php $salida=round($dato->total/$dato->costo) - $dato->cantidad; ?> {{$salida}}</td>
              <td> {{$dato->cantidad}}</td>
              <!--<td> <?php $datoss=$dato->costo * $dato->cantidad; ?> {{ number_format($datoss, 2, ",", ".") }} </td>-->
              <?php
                if( $dato->observacion == ''  )
                  $total = $total + $datoss;
                ?>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection


@section('js')
<script type="text/javascript">
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

$('#id_apertura').change(function(){
  var apertura = $('#id_apertura').val();
  var id_apertura = apertura.split('-')[0];
  var link = "{{asset('index.php/Bienes/apertura/lista/')}}/"+id_apertura;
  $.getJSON(link, null, function(data, textStatus) {
    if(data.length>0){
      $('#bienes').empty();
      $.each( data, function( key, el ) {
        dato = el.id+'- '+ el.bien;
        $('#bienes').append($('<option>', {
          value: dato
          //text: dato
        }));
     });
    }
   });

});

</script>
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
</script>
@endsection
