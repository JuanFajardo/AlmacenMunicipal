@extends('sisoftComBo')

@section('cierreGestion')
active
@endsection

@section('cierreGestion2')
active
@endsection

@section('contenido')
<div class="warper container-fluid">

  <div class="row">
    <div class="col-lg-12">

    <div class="row">
      <div class="col-md-12">
        <fieldset>
            {!! Form::open(['accept-charset'=>'UTF-8', 'method'=>'post', 'url'=>'CambiarGestion', 'autocomplete'=>'off', 'id'=>'form-insert'] ) !!}
              <label for="">Base de datos</label>
              <select class="form-control" name="DB_CONNECTION" id="DB_CONNECTION">
                  <option value="">  </option>
                  <option value="mysql"> MySQL - MariaDB </option>
                  <option value="pgsql"> PostgreSQL </option>
              </select>
              <label for="">Host de la base de datos</label>
              <input type="text" name="DB_HOST"  class="form-control" id="DB_HOST">
              <label for="">Puerto de la base de datos</label>
              <input type="text" name="DB_PORT"  class="form-control" id="DB_PORT">
              <label for="">Nombre de la base de datos</label>
              <select name="DB_DATABASE"  class="form-control" id="DB_DATABASE">
                <?php foreach ($gestiones as $gestion): ?>
                  <option value="<?php echo $gestion['gestion']; ?>"> <?php echo $gestion['gestion']; ?> </option>
                <?php endforeach; ?>



              </select>
              <label for="">Usuario de la base de datos</label>
              <input type="text" name="DB_USERNAME"  class="form-control" id="DB_USERNAME">
              <label for="">Contraseña de la base de datos</label>
              <input type="passwd" name="DB_PASSWORD"  class="form-control" id="DB_PASSWORD">
              <br>
              <input type="submit" id="boton" value="CAMBIAR GESTION" class="btn btn-info">
          {!! Form::close() !!}
        </fieldset>

        @if($errors->any())
        <div class="alert alert-danger">
          <h4>{{$errors->first()}}</h4>
        </div>
        @endif

      </div>
    </div>

  </div>


</div>
@endsection

@section('js')
<script type="text/javascript">
  $('#DB_CONNECTION').change(function(){
    if($('#DB_CONNECTION').val() == 'mysql'){
      $('#DB_HOST').val('localhost'); $('#DB_PORT').val('3306'); $('#DB_USERNAME').val('root');
    }else if ($('#DB_CONNECTION').val() == 'pgsql'){
      $('#DB_HOST').val('localhost'); $('#DB_PORT').val('5432'); $('#DB_USERNAME').val('postgres');
    }else if ($('#DB_CONNECTION').val() == ''){
      $('#DB_HOST').val(''); $('#DB_PORT').val(''); $('#DB_DATABASE').val(''); $('#DB_USERNAME').val('');
    }
  });
</script>
@endsection
