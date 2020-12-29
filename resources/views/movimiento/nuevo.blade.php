@extends('sisoftComBo')

@section ('ingreso')
active
@endsection

@section ('ingreso1')
active
@endsection

@section('contenido')
  <div class="warper container-fluid">
    <div class="page-header"><h1>Ingreso <small>Seleccione sus opciones...</small></h1></div>

    <div class="col-lg-12">
      <div class="col-md-4">
        <label>Cantidades de aperturas programaticas:</label>
      </div>
      {!! Form::open(['url'=>'Movimiento/create', 'autocomplete'=>'off', 'method'=>'POST' ]) !!}
        <div class="col-md-3 col-sm-2">
          {!! Form::text('nro_moviento', null, ['class'=>'form-control', 'placeholder'=>'1,2,3,4....', 'required']) !!}
        </div>
    </div>
    <div class="col-lg-12">
      <div class="col-md-4">
        <label>Seleccione su movimiento:</label>
      </div>
        <div class="col-md-3 col-sm-2">
          <!--{!! Form::select('movimento', ['1'=>'Ingreso', '2'=>'Ingreso Stock', '3'=>'Salida Stock'], null, ['class'=>'form-control', 'required']) !!} -->
          {!! Form::select('movimento', ['1'=>'Ingreso', '2'=>'Ingreso Stock'], null, ['class'=>'form-control', 'required']) !!}
        </div><br><br><br>
    </div>

    <div class="col-lg-12">
      <div class="col-md-3 col-sm-6">
      </div>
        @if($dato >0 )
          <div class="col-md-3 col-sm-6">
            {!! Form::submit('Realizar movimiento',  ['class'=>'btn btn-primary']) !!}
          </div>
        @else
          <div class="col-md-3 col-sm-6">
            <a href="{{asset('index.php#/cambio')}}" > Agregar UFV del dia de hoy</a>
          </div>
        @endif

      {!! Form::close() !!}
      <br><br><br><br><br>
    </div>
  </div>
@endsection
