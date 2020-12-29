@extends('sisoftComBo')

@section('productos')
active
@endsection

@section('productos1')
active
@endsection

@section('contenido')

<div class="panel panel-default">
    <div class="panel-heading clean">
      <h3><i class="fa fa-shopping-cart"></i>  <b> Catalogo de Productos en Desuso </b></h3>
    </div>
    <div class="panel-body">
      <form action="{{asset('index.php/Reporte/deshuso')}}" method="get">

      <div class="row">
        <div class="col-md-3">
          <label for="">Gestiones</label>
          <select class="form-control" name="gestion" required >
            @foreach($gestiones as $gestion)
              <option value="{{$gestion->id}}"> {{$gestion->gestion}}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-4">
          <label for="">Almacenes</label>
          <select class="form-control" name="almacen" required >
            @foreach($almacenes as $almacen)
              <option  value="{{ $almacen->id }}"> {{ $almacen->almacen }} </option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="row">
        <div class="col-md-2" style="padding-top:15px;">
          <button type="submit" name="button" id="button" class="btn btn-info" >
            <i class="fa fa-file-pdf-o"></i> Generar Reporte de Catalogo de Productos en Desuso
          </button>
        </div>
      </div>
    </form>

      <div class="row"><div class="col-md-12">&nbsp;</div></div>
      <div class="rows">
        <div class="col-md-12">
          <table class="one class" id="datos" width="100%">
            <thead>
              <tr>
                <th width="5%"  style="text-align:left;"> Nro. </th>
                <th width="5%"  style="text-align:left;"> Fecha </th>
                <th width="30%" style="text-align:left;"> Articulo </th>
                <th width="30%" style="text-align:left;"> Observacion </th>
                <th width="5%"> Costo</th>
                <th width="5%"> Cantidad </th>
                <th width="10%"> Total </th>
              </tr>
            </thead>
            <tbody>
              <?php $index =1; ?>
              @foreach($datos as $dato)
              <tr >
                <td> {{ $index }} </td>
                <td> {{ date("d/m/Y", strtotime( explode(' ', $dato->actualizado )[0] )) }} </td>
                <td> {{ $dato->bien}} </td>
                <td> {{ $dato->observacion}} </td>
                <td> {{ $dato->costo}}</td>
                <td> {{ $dato->cantidad}}</td>
                <td> {{ $dato->total}} </td>
              </tr>
              <?php $index++; ?>
              @endforeach
            </tbody>
          </table>
        </div>
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
