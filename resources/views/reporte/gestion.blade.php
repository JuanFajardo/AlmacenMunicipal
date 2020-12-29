@extends('sisoftComBo')

@section ('movimiento')
active
@endsection

@section ('movimiento2')
active
@endsection

@section('contenido')
<div class="panel panel-default">
    <div class="panel-heading clean">
      <h3><i class="fa fa-database"></i>  <b>Consulta de todos los Movimientos <?php echo $bett0 == "Bett0" ? "Gestión ".$gestion->gestion : "Gestión Actual";  ?></b></h3>
    </div>

    {!! Form::open(['url'=>'/Reportes/gestion', 'autocomplete'=>'off', 'method'=>'post']) !!}
    <label>Seleccione la gestion del reporte: </label>
    <div class="col-lg-12">
      <div class="col-md-3">
            {!! Form::select('gestion', \App\Gestiones::lists('gestion', 'id'), null, ['placeholder'=>'', 'class'=>'form-control']  ) !!}
      </div>
      <div class="col-md-3">
        <button type="submit" name="button" class="btn btn-primary">MOSTRAR</button>
      </div>
    </div>
    {!! Form::close() !!}


    <div class="panel-body">
      <div class="rows">
        <div class="col-md-12">
          <!--<a href="#/movimiento/new"> <i class="fa fa-plus-circle fa-2x" aria-hidden="true"></i> <b>Nuevo Ingreso a Almacenes</b> </a><br>
          <a href="#/movimiento/newPEPS" style="color:#3e8f3e;"> <i class="fa fa-plus-circle fa-2x" aria-hidden="true"></i> <b>Nuevo Ingreso a Almacenes par Stock</b> </a><br>
          <a href="#/movimiento/exitPEPS" style="color:#3e8f3e;"> <i class="fa fa-share fa-2x" aria-hidden="true"></i> <b>Nuevo Salida de Almacenes por Stock</b> </a> -->
        </div>
      </div>
      <div class="row"><div class="col-md-12">&nbsp;</div></div>
      <div class="rows">
        <div class="col-md-12">


          <table class="one class" id="datos" width="100%">
            <thead>
              <tr>
                <th width="3%"> Nro. </th>
                <th width="5%"> Fecha </th>
                <th width="5%"> Movimiento </th>
                <th width="10%"> Total </th>
                <th width="30%"> Estructura Programatica</th>
                <th width="5%"> Usuario </th>
                <th width="20%"> Acciones </th>
              </tr>
            </thead>
            <tbody>
              <?php $index = 1; ?>
              @foreach($datos as $dato)
              @if($dato->eliminacion =="" and $dato->fecha_eliminacion == "0000-00-00")
                <tr>
              @else
                <tr style="background-color:#FB9797; color:white;">
              @endif
                <td> {{$index}} </td>
                <td> {{ date('d/m/Y', strtotime($dato->fecha)) }} </td>
                <td>
                  @if($dato->movimiento == 'INGRESO' || $dato->movimiento == 'SALIDA' )
                    {{ $dato->movimiento}} Nro. {{ str_pad($dato->nro_moviento, 6, "0", STR_PAD_LEFT) }}
                  @else
                    {{ $dato->movimiento}} Nro. {{$dato->nro_moviento}}
                  @endif
                </td>
                <td> {{ number_format($dato->total_factura, 2, ",", ".") }} </td>
                <td> {{$dato->glosa_entrada}} {{$dato->glosa_salida}} </td>
                <td> {{$dato->username}} </td>
                <td>
                  <div >
                    @if($dato->eliminacion =='') <!-- and $dato->fecha_eliminacion == "") -->
                      <a href="{{asset('index.php/Movimientos/'.$dato->id)}}" style="color:#31708f;"> <i class="fa fa-eye" aria-hidden="true"></i> Ver </a>                 &nbsp;&nbsp;&nbsp;&nbsp;
                      <a href="{{asset('index.php/Reportes/mostrar/'.$dato->id)}}" style="color:#31708f;"> <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Reporte </a> &nbsp;&nbsp;&nbsp;&nbsp;
                    @else
                      <a href="{{asset('index.php/Reportes/mostrar/'.$dato->id)}}" style="color:31708f;"> <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Reporte </a> &nbsp;&nbsp;&nbsp;&nbsp;
                      <a href="{{asset('index.php/Movimientos/'.$dato->id)}}" style="color:#31708f;"> <i class="fa fa-eye" aria-hidden="true"></i> Ver </a><br>
                      {{$dato->eliminacion}}
                    @endif
                      </div>

                </td>
              </tr><?php $index++; ?>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

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
          "sEmtpyTable": "No ay registros",
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
