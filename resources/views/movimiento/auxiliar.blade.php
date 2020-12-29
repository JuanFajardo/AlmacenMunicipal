@extends('sisoftComBo')

@section ('movimiento')
active
@endsection

@section ('movimiento0')
active
@endsection

@section('contenido')
<div class="panel panel-default">
    <div class="panel-heading clean">
      <h3><i class="fa fa-user"></i>  <b>Movimientos de Auxiliares para confirmar</b></h3>
    </div>
    <div class="panel-body">

      <div class="rows">
        <div class="col-md-12">
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
                <th width="30%"> Acciones </th>
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
                <td> {{ $index }} </td>
                <td> {{ date('d/m/Y', strtotime($dato->fecha)) }} </td>
                <td>
                  @if($dato->movimiento == 'INGRESO' || $dato->movimiento == 'SALIDA' )
                    {{ $dato->movimiento}} Nro. {{ str_pad($dato->nro_moviento, 6, "0", STR_PAD_LEFT) }}
                  @else
                    {{ $dato->movimiento}} Nro. {{$dato->nro_moviento}}
                  @endif
                </td>
                <td> {{ number_format($dato->total_factura, 2, ",", ".") }} </td>
                <td> {{ $dato->glosa_entrada }} {{ $dato->glosa_salida }} </td>
                <td> {{ $dato->username }} </td>
                <td>
                  <div >

                    @if($dato->eliminacion =='') <!-- and $dato->fecha_eliminacion == "") -->
                      <a href="{{asset('index.php/Movimientos/'.$dato->id)}}" style="color:#31708f;"> <i class="fa fa-eye" aria-hidden="true"></i> Ver </a>                               &nbsp;&nbsp;&nbsp;&nbsp;
                      <a href="{{asset('index.php/Reportes/mostrar/'.$dato->id)}}" style="color:#31708f;"> <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Reporte </a> &nbsp;&nbsp;&nbsp;&nbsp;

                      @if($dato->movimiento == 'SALIDA')
                      @elseif($dato->movimiento == 'INGRESO' and $dato->motivo != 'salio'  )
                        <a href="{{asset('index.php/Movimientos/'.$dato->id.'/salir')}}" style="color:#3e8f3e;"> <i class="fa fa-share" aria-hidden="true"></i> Salida </a> &nbsp;&nbsp;&nbsp;&nbsp;
                      @endif

                      @if($dato->movimiento == 'INGRESO' || $dato->movimiento == 'SALIDA' || $dato->movimiento == 'INGRESO STOCK')
                        @if($dato->eliminacion == '')
                          <a href="{{asset('index.php/Movimiento/eliminar/'.$dato->id)}}" style="color:#c12e2a;"> <i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar</a>  &nbsp;&nbsp;&nbsp;&nbsp;
                        @endif
                      @endif

                      @if( \Auth::user()->grupo == 2 and $dato->auxiliar == "NO" )
                        <a href="{{asset('index.php/Movimiento/confirmar/'.$dato->id)}}" style="color:#2777C7;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> Confirmar </a>
                      @endif
                      @else
                          <a href="{{asset('index.php/Reportes/mostrar/'.$dato->id)}}" style="color:31708f;"> <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Reporte </a> &nbsp;&nbsp;&nbsp;&nbsp;
                          <a href="{{asset('index.php/Movimientos/'.$dato->id)}}" style="color:#31708f;"> <i class="fa fa-eye" aria-hidden="true"></i> Ver </a>
                          <br>
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
          "sEmtpyTable": "No hay registros",
          "decimal": ",",
          "thousands": ".",
          "lengthMenu": "Mostrar _MENU_ datos por registros",
          "zeroRecords": "No se encontro nada,  lo siento",
          "info": "Mostrar páginas [_PAGE_] de [_PAGES_]",
          "infoEmpty": "No hay entradas permitidas",
          "search": "Buscar ",
          "infoFiltered": "(Búsqueda de _MAX_ registros en total)",
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
