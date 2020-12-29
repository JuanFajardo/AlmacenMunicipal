@extends('sisoftComBo')

@section('cierreGestion')
active
@endsection

@section('cierreGestion1')
active
@endsection

@section('contenido')

<div>
  <div class="row">
    <div class="col-lg-12">

      <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
          <div class="alert alert-danger text-center" role="alert">
            <h2>¿Esta completamente seguro de cerrar su gestion?</h2><br>
            Antes de realizar el cierre gestion debe crear la base de datos "<strong>almacenes_{{ date('Y')+1 }}</strong>"
          </div>
        </div>
      </div>

      {!! Form::open(['accept-charset'=>'UTF-8', 'autocomplete'=>'off','method'=>'post', 'url'=>'CierreGestion/', 'id'=>'form-insert'] ) !!}
      {!! Form::hidden('fecha_inicio', $fecha_inicio) !!}
      {!! Form::hidden('fecha_fin', $fecha_fin) !!}

      @if( $fecha1=='' and $fecha2 == '')
        {!! Form::submit('CERRAR GESTION', ['class'=>'btn btn-danger form-control', 'id'=>'boton']) !!}
      @else
        <a href="{{asset('index.php/CierreGestion')}}" class="btn btn-info"> No exite un UFV en esa fecha se sugiere usar estas fechas {{$fecha1}} -- {{$fecha2}}</a>
      @endif

      {!! Form::close() !!}
    </div>
  </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
  $('#boton').click(function(event) {
      event.preventDefault();
      if(confirm('Esta de acuerdo en cerrar la GESTION'))
      {
        $('#form-insert').submit();
      }
  });

</script>
@endsection
