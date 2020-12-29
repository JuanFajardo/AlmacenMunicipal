@extends('sisoftComBo')

@section('cierreGestion')
active
@endsection

@section('cierreGestion1')
active
@endsection

@section('contenido')
<div class="warper container-fluid">

  <div class="row">
    <div class="col-lg-2"></div>
      <div class="col-lg-8">
        <div class="alert alert-danger" role="alert">
          <strong><h2>CIERRE DE GESTION</h2></strong><br>
              DEBE USAR ESTA OPCION SOLO CUANDO REALICE EL CIERRE DE GESTION A FINAL DE AÑO o CUANDO USTED ESTE SEGURO DE REALIZARLO.
            <b> EL CIERRE DE GESTION NO TIENE VUELTA ATRAS SI ESTA DE ACUERDO CON EL CIERRE DE CLICK EN EL BOTON "CERRAR GESTION"</b>
        </div>
      </div>
    <div class="col-lg-2"></div>
  </div>

  <div class="row">
    <div class="col-lg-12">
      {!! Form::open(['accept-charset'=>'UTF-8', 'method'=>'post', 'url'=>'CierreGestion/create', 'autocomplete'=>'off', 'id'=>'form-insert'] ) !!}
      <table class="table table-bordered table-striped" style="border: unset;" >
        <tr>
          <td colspan="2"></td>
          <td>
            <label>Fecha Inicio</label>
            <div class='input-group date' col-md-4 >
              <input type='text' name="fecha_inicio" class="form-control" id='inicio'/>
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
            <!--<input type='date' class="form-control" name="fecha_inicio" id="inicio"  required/>-->
          </td>
          <td><label>Fecha Final</label>
            <div class='input-group date' >
              <input type='text' name="fecha_fin" class="form-control" id='fin'/>
              <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
              </span>
            </div>
            <!--<input type='date' class="form-control" name="fecha_fin" id="fin" required/>-->
          </td>
          <td colspan="2"></td>
        </tr>
        <tr>
          <td colspan="2"></td>
          <td colspan="3">
            @if($dato >0 )
              <div class="col-md-3 col-sm-6">
                {!! Form::submit('CERRAR GESTION', ['class'=>'btn btn-warning']) !!}
              </div>
            @else
              <div class="col-md-3 col-sm-6">
                <a href="{{asset('index.php#/cambio')}}" > Agregar UFV del dia de hoy</a>
              </div>
            @endif

            {!! Form::close() !!}
          </td>
          <td></td>
        </tr>
      </table>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <table class="table">
        <thead>
          <tr>
            <th> Nro.</th> <th>Fecha y Hora de Cierre</th> <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($datos as $dato)
            <tr>
              <td> {{$dato->id}} </td> <td> {{ explode('|', $dato->cerrado_gestion)[1] }} </td>
              <td> <a href="{{asset('Reportes/cierre/'.$dato->cerrado_gestion)}}"> <i class="fa fa-file-pdf-o"></i> Generar Reporte </a></td>
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
   $.fn.datetimepicker.defaults.language = 'es';
  });

  $(function () {
   $('#inicio').datetimepicker({ format: 'YYYY-MM-DD'});
  });
  $(function () {
  $('#fin').datetimepicker({ format: 'YYYY-MM-DD'});
  });
</script>
@endsection
