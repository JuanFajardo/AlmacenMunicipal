@extends('sisoftComBo')

@section('contenido')
<!-- DateTime Picker  -->
<link rel="stylesheet" href="{{asset('assets/css/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.css')}}" />

<div class="panel panel-primary">
    <div class="panel-heading clean">
      <h3><i class="fa fa-shopping-cart"></i>  <b>  </b></h3>
    </div>
    <div class="panel-body">

      {!! Form::open(['url'=>'Movimiento/eliminar/'.$dato->id, 'autocomplete'=>'off', 'method'=>'POST', 'id'=>'formEnvio']) !!}
      <div class="rows">
        @if($eliminar == 0 )
        <div class="col-md-4">
          <label for="">Movimiento: {{$dato->movimiento}} N° {{$dato->nro_moviento}}</label>
        </div>
        <div class="col-md-4">
          <label for="">Glosa: {{$dato->glosa_entrada}} {{$dato->glosa_salida}}</label>
        </div>
        <div class="col-md-4">
          <label for=""></label>
        </div>
        @else
          <!--<div class="col-md-8">
            <label for=""> El movimiento no puede ser eliminado</label>
          </div>-->
        @endif

      </div>

      <div class="rows">
        <div class="form-group col-md-12">
            <div class="col-md-12">
              <h4><span class="glyphicon glyphicon-list col-md-12" style="color: #fff; padding: 7px; background-color: red; border-top-left-radius: 10px; border-top-right-radius: 10px;"><b> Motivo de eliminacion  </span></h4>
              <textarea class="form-control" rows="2" cols="100" name="eliminacion" id="eliminacion" required> </textarea>
              <input type="hidden" value="{{$dato->movimiento}}" name="movimiento">
            </div>
        </div>
      </div>

      <div class="rows">
          <div class="form-group col-md-12">
            <div class="rows">

              <div class="col-md-3">
                <button type="submit" name="button" id="button" class="btn btn-danger" >
                  <i class="fa fa-plus-circle" aria-hidden="true"></i> Eliminar movimiento
                </button>
              </div>


              <div class="col-md-3">
                <a href="{{asset('index.php/Movimientos')}}" class="btn btn-info"> <i class="fa fa-times-circle" aria-hidden="true"></i> Cancelar</a>
              </div>
            </div>
          <div id="splineArea-chart" style="height:280px;"></div>
        </div>
      </div>
      {!! Form::close() !!}

  </div>
</div>

@endsection
