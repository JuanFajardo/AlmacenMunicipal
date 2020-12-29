<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Instalador de Sistemsa de Almacenes</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

      <div class="container">

        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <br/><br/>
            Logo 1
            Logo 2
            <br>
            Sistema de alamacenes de EM-EASSI y SiSoft
            Para la instalacion necesita ir paso a paso introduciendo los datos necesarios para una correcta instalacion del sistema.
            <h2>1.- Paso - Conexion a la base de datos</h2>
            <br/><br/>
          </div>
          <div class="col-md-2"></div>
        </div>

        <div class="row">
          <div class="col-md-3">
            <ul>
              <li> <label for="">Conexion</label></li>
              <li> Datos Generales </li>
              <li> Terminar </li>
            </ul>
          </div>
          <div class="col-md-9">
            <fieldset>
              <form class="" action="{{asset('index.php/Instalador')}}" method="post" 'autocomplete'='off'>
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
                  <input type="text" name="DB_DATABASE"  class="form-control" id="DB_DATABASE" readonly>
                  <label for="">Usuario de la base de datos</label>
                  <input type="text" name="DB_USERNAME"  class="form-control" id="DB_USERNAME">
                  <label for="">Contraseña de la base de datos</label>
                  <input type="passwd" name="DB_PASSWORD"  class="form-control" id="DB_PASSWORD">
                  <br>
                  <input type="submit" id="boton" value="Probar Conexion" class="btn btn-primary">
              </form>
            </fieldset>

            @if($errors->any())
            <div class="alert alert-danger">
              <h4>{{$errors->first()}}</h4>
            </div>
            @endif

          </div>
        </div>
      </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <script type="text/javascript">
      $('#DB_CONNECTION').change(function(){
        var d = new Date();
        if($('#DB_CONNECTION').val() == 'mysql'){
          $('#DB_HOST').val('localhost'); $('#DB_PORT').val('3306'); $('#DB_DATABASE').val('almacenes_'+d.getFullYear()); $('#DB_USERNAME').val('root');
        }else if ($('#DB_CONNECTION').val() == 'pgsql'){
          $('#DB_HOST').val('localhost'); $('#DB_PORT').val('5432'); $('#DB_DATABASE').val('almacenes_'+d.getFullYear()); $('#DB_USERNAME').val('postgres');
        }else if ($('#DB_CONNECTION').val() == ''){
          $('#DB_HOST').val(''); $('#DB_PORT').val(''); $('#DB_DATABASE').val(''); $('#DB_USERNAME').val('');
        }
      });

    </script>
  </body>
</html>
