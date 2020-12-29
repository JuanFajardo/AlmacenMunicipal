
@extends('sisoftComBo')

@section ('configuraciones')
active
@endsection

@section ('configuraciones1')
active
@endsection

@section('contenido')

<link rel="stylesheet" href="assets/css/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.css" />

<div class="panel panel-default">
    <div class="panel-heading clean">
      <h3><i class="fa fa-users"></i>  <b>Creacion de Automovil</b> </h3>
    </div>

    <div class="panel-body">


        {!! Form::open(['url'=>'Automovil', 'autocomplete'=>'off', 'method'=>'POST', 'id'=>'formEnvio']) !!}

        <div class="form-group">

          <div class="col-md-3">
            <label>PLACA</label>
            <input type="text" name="placa" class="form-control"  placeholder="placa" style="margin:10px" required>
          </div>
          <div class="col-md-3">
            <label>Tipo de Automovil</label>
            <input type="text" name="tipo" class="form-control"  placeholder="Tipo de Automovil" style="margin:10px" required>
          </div>
          <div class="col-md-3">
            <label>Modelo</label>
            <input type="text" name="modelo" class="form-control"  placeholder="Modelo" style="margin:10px">
          </div>
          <div class="col-md-3">
            <label>Color</label>
            <input type="text" name="color" class="form-control"  placeholder="Color"  style="margin:10px">
          </div>
        </div>

        <div class="rows">
          <div class="col-md-4">
            <input type="submit" name="boton" class="btn btn-primary" value="Insertar">
          </div>
        </div>
      {!! Form::close() !!}
    </div>
</div>


@endsection


@section('js')
@endsection
