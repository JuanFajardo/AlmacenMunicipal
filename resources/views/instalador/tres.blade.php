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
            Sistema de alamacenes de EM-EASSI y Codigo4060
            Para la instalacion necesita ir paso a paso introduciendo los datos necesarios para una correcta instalacion del sistema.
            <h2>3.- Paso - Finalizado</h2>
            <br/><br/>
          </div>
          <div class="col-md-2"></div>
        </div>

        <div class="row">
          <div class="col-md-3">
            <ul>
              <li> <label for="">Conexion</label></li>
              <li> <label for="">Datos Generales</label> </li>
              <li> <label for="">Terminar</label> </li>
            </ul>
          </div>
          <div class="col-md-9">
            <fieldset>
              <legend>Usuario</legend>
              <b>Nombre Completo:</b>{{$user->nombreCompleto}}<br>
              <b>Usuario:</b>{{$user->name}}<br>
              <b>Cargo:</b>Administrador<br>
            </fieldset>

            <fieldset>
              <legend>Datos Generales</legend>
              <b>Entidad:</b>{{$config->entidad}}<br>
              <b>Direccion:</b>{{$config->direccion}}<br>
              <b>Telefono:</b>{{$config->telefono}}<br>
            </fieldset>

          </div>
          <div><a href="<a href="{{asset('GamtAlmacenes/public/index.php')}}"><button>COMENZAR</button></a></div>
        </div>
      </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

  </body>
</html>
