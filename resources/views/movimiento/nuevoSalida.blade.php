@extends('sisoftComBo')

@section ('salida')
active
@endsection

@section ('salida1')
active
@endsection

@section('contenido')
  <div class="warper container-fluid">
    <div class="page-header"><h1>Salida Stock </h1></div>

    <div class="col-lg-12">
      <div class="col-md-4">
        <label>Ingrese cantidad de salidas:</label>
      </div>
      {!! Form::open(['url'=>'Movimiento/salidaStock', 'autocomplete'=>'off', 'method'=>'POST' ]) !!}
        <div class="col-md-3 col-sm-2">
          {!! Form::text('nro_moviento', null, ['class'=>'form-control', 'placeholder'=>'1,2,3,4....', 'required']) !!}
        </div>
    </div>

    <div class="col-lg-12">
      <div class="col-md-3 col-sm-6">
      </div>
        @if($dato >0 )
          <div class="col-md-3 col-sm-6">
            <input type="submit" name="boton" value="Salidas Stock" class='btn btn-primary'>
            <input type="submit" name="boton" value="Salidas Combustible" class='btn btn-success'>
          </div>
        @else
          <div class="col-md-3 col-sm-6">
            <br></br>
            <a href="{{asset('index.php#/cambio')}}" > Agregar UFV del dia de hoy</a>
          </div>
        @endif

      {!! Form::close() !!}
      <br><br><br><br><br>
    </div>
  </div>
@endsection
