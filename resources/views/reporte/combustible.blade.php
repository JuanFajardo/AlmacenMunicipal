@extends('sisoftComBo')

@section('reportes')
active
@endsection

@section('reportes9')
active
@endsection

@section('contenido')
<div class="warper container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <h3><i class="fa fa-th"></i> Reporte de Combustible</h3>

      {!! Form::open(['url'=>'/Reportes/combustible', 'autocomplete'=>'off', 'method'=>'post']) !!}

      <div class="row">
        <!--<div class="col-md-4">
          <label>Almacen</label>
          <input type="text" name="id_almacen"  list="almacenes"  placeholder="Eliga un almacen" class="form-control" required >
          <datalist id="almacenes">
            @foreach($almacenes as $almacen)
              <option value="{{$almacen->almacen}}">
            @endforeach
          </datalist>
        </div>-->
        <div class="col-md-3">
          <label>Fecha Inicio</label>
          <div class='input-group date' >
            <input type='text' class="form-control" name="fecha_inicio" id="fecha_inicio" required/>
            <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
            </span>
          </div>
        </div>
        <div class="col-md-3">
          <label>Fecha Final</label>
          <div class='input-group date' >
          <input type='text' class="form-control" name="fecha_fin" id="fecha_fin" required/>
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div>
        </div>
      </div>

      <div class="row">

        <div class="col-md-4" style="padding-top:10px;">
          <button type="submit" name="button" value="pdfStock" class="btn btn-primary"> <i class="fa fa-file-pdf-o"></i> Reporte del Combustible </button>
        </div>

      </div>
      {!! Form::close() !!}
      <br><br>
      <!--
      <h4 align="left"><b>Consulta rápida de movimiento de partida de gasto:</b></h4>
      <table class="one class" id="datos" width="100%" >
        <thead>
          <tr>
            <th>Fecha </th>
            <th>Nro Movimeinto </th>
            <th>Partida </th>
            <th>Codigo </th>
            <th>Bien</th>
            <th>Unidad </th>
            <th>Prec. Unit</th>
            <th>Cantidad</th>
            <th>Monto Total</th>
          </tr>
        </thead>
        <tbody>
          foreach($datos as $dato)
            <tr>
              <td style="text-align:left;">  date("d/m/Y", strtotime($dato->fecha) ) }}</td>
              <td style="text-align:left;">  str_pad($dato->nro_moviento, 6, "0", STR_PAD_LEFT) }}</td>
              <td style="text-align:left;">  $dato->clasificador }}</td>
              <td style="text-align:left;">  $dato->codigoClasificador }}. $dato->id_almacen }}.$dato->id_bien}}</td>
              <td style="text-align:left;">  $dato->bien}}</td>
              <td style="text-align:left;">  $dato->unidad}}</td>
              <td>  number_format($dato->costo, 2, ",", ".") }}</td>
              <td>  $dato->cantidad}}</td>
              <td>  $val=$dato->costo * $dato->cantidad; ?> number_format($val, 2, ",", ".") }}}</td>
            </tr>
          endforeach
        </tbody>
      </table>
      -->
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
