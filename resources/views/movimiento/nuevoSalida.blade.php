@extends('sisoftComBo')

@section ('salida')
active
@endsection

<?php
if($id == "combustible")
  $titulo = "salida2";
else
  $titulo = "salida1";
?>

@section ($titulo)
active
@endsection

@section('contenido')
  <div class="warper container-fluid">
    <div class="page-header"><h1>
      @if($id == "combustible")
        Salida Combustible
      @else
        Salida Stock
      @endif
    </h1></div>

    <div class="col-lg-12">
      <div class="col-md-4">
        @if($id == "combustible")
          <label>Ingrese cantidad de salidas de combustible:</label>
        @else
          <label>Ingrese cantidad de salidas de Stock:</label>
        @endif
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
            @if($id == "combustible")
              <input type="submit" name="boton" value="Salidas Combustible" class='btn btn-success'>
            @else
              <input type="submit" name="boton" value="Salidas Stock" class='btn btn-primary'>
            @endif
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
