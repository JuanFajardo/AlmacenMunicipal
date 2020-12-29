@extends('sisoftComBo')

@section('reportes')
active
@endsection

@section('reportes6')
active
@endsection

@section('contenido')
<div class="warper container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <h3><i class="fa fa-users"></i> Funcionarios </h3>

      {!! Form::open(['url'=>'/Reportes/funcionario', 'autocomplete'=>'off', 'method'=>'post']) !!}


	      <div class="row">
          <div class="col-md-2">
            <label> Gestion  </label>
            {!! Form::select('gestion',      \App\Gestiones::lists('gestion', 'id'), null, ['class'=>'form-control']) !!}
          </div>

          <div class="col-md-8">
	          <label>Funcionario</label>
	          <input type="text" name="funcionario"  list="funcionarios" placeholder="Eliga un funcionario" class="form-control">
	          <datalist id="funcionarios">
	            @foreach($funcionarios as $funcionario)
	              <option value="{{$funcionario->id}}- {{$funcionario->ci}} - {{$funcionario->nombres}}, {{$funcionario->paterno}}, {{$funcionario->materno}}">
	            @endforeach
	          </datalist>
	        </div>
	      </div>

	      <div class="row">
          <div class="col-md-4">
            <label>Almacen</label>
            <input type="text" name="id_almacen"  list="almacenes"  placeholder="Eliga un almacen" class="form-control" required >
            <datalist id="almacenes">
              @foreach($almacenes as $almacen)
                <option value="{{$almacen->almacen}}">
              @endforeach
            </datalist>
          </div>
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
          <div class="col-md-4" style="padding-top:15px;">
            <button type="submit" name="button" class="btn btn-info"> <i class="fa fa-file-pdf-o"></i> Reporte por Funcionario/s</button>
          </div>
        </div>
      {!! Form::close() !!}
      <br><br>
      <h4 align="left"><b>Consulta rápida de funcionarios:</b></h4>
      <table class="one class" id="datos" width="100%" >
        <thead >
          <tr>
            <th>Fecha </th>
            <th>Nro Movimiento </th>
            <th>Funcionario </th>
            <th>Apertura</th>
            <th>Codigo </th>
            <th>Articulo</th>
            <th>Prec. Unit</th>
            <th>Unidad</th>
            <th>Cantidad</th>
            <th>Monto Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach($datos as $dato)
            <tr>
              <td style="text-align:left;"> {{ date("d/m/Y", strtotime( $dato->fecha)) }}</td>
              <td style="text-align:left;">
                @if($dato->movimiento == 'SALIDA')
                  {{ str_pad($dato->nro_moviento, 6, "0", STR_PAD_LEFT) }}
                @else
                  {{ $dato->nro_moviento }}
                @endif
              </td>
              <td style="text-align:left;"> {{ $dato->nombres }}, {{ $dato->paterno }}, {{ $dato->materno }} </td>
              <td style="text-align:left;"> {{ $dato->codigoApertura }} {{ $dato->apertura }}</td>
              <td style="text-align:left;"> {{ $dato->codigoClasificador}}.{{$dato->id_almacen}}.{{$dato->id_bien}}</td>
              <td style="text-align:left;"> {{ $dato->bien}}</td>
              <td style="text-align:left;"> {{ $dato->unidad}}</td>
              <td> {{ number_format($dato->costo, 2, ",", ".") }}</td>
              <td> {{ $dato->cantidad}}</td>
              <td> <?php $val=$dato->costo * $dato->cantidad; ?>{{ number_format($val, 2, ",", ".") }}</td>
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
