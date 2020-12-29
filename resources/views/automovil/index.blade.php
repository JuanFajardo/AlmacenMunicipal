@extends('sisoftComBo')

@section ('movimiento')
active
@endsection

@section ('movimiento1')
active
@endsection

@section('contenido')
<div class="panel panel-default">
    <div class="panel-heading clean">
      <h3><i class="fa fa-users"></i>  <b> Automovil </b></h3>
    </div>
    <div class="panel-body">

      <a href="{{asset('index.php/Automovil/create')}}">
        <button type="button" class="btn btn-primary">AGREGAR <i class="fa fa-plus-circle fa-2x" aria-hidden="true"></i>
        </button>
      </a>
      </br>
      </br>
       <table class="one table"  width="100%">
        <thead>
          <tr>
            <th width="5%">Nro.</th>
            <th width="20%">PLACA</th>
            <th width="10%">TIPO</th>
            <th width="5%">MODELO</th>
            <th width="20%">COLOR</th>
            <th width="30%"> Acciones </th>
          </tr>
        </thead>
        <tbody>
          @foreach($datos as $dato)
          <tr >
            <td> {{ $dato->id }} </td>
            <td style="text-align: left;"> {{$dato->placa}}  </td>
            <td> {{$dato->tipo}} </td>
            <td> {{$dato->modelo}} </td>
            <td style="text-align: left;"> {{$dato->color}} </td>
            <td>
              <div class="botonesAccion">
                <a href="{{asset('index.php/Automovil/'.$dato->id.'/edit')}}" style="color:#f0ad4e;"> <i class="fa fa-pencil" aria-hidden="true"></i> Editar </a> &nbsp;&nbsp;&nbsp;&nbsp;
              </div>
          </tr>
          @endforeach
        </tbody>
      </table>

      <div id="splineArea-chart" style="height:280px;"></div>
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
          "infoEmpty": "No ay entradas permitidas",
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
