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
            <h2>2.- Paso - Conexion a la base de datos</h2>
            <br/><br/>
          </div>
          <div class="col-md-2"></div>
        </div>

        <div class="row">
          <div class="col-md-3">
            <ul>
              <li> <label for="">Conexion</label></li>
              <li> <label for="">Datos Generales</label> </li>
              <li> Terminar </li>
            </ul>
          </div>
          <div class="col-md-9">
            <form class="" action="{{asset('index.php/Instalador/finalizar')}}" method="post" 'autocomplete'='off'>
            <fieldset>
              <legend> Datos del Municipio</legend>
                <label for="">Entidad Municipal</label>
                <input type="text" name="entidad"  class="form-control" id="entidad">
                <label for="">Direccion</label>
                <input type="text" name="direccion"  class="form-control" id="direccion">
                <label for="">Telefono(s)</label>
                <input type="text" name="telefono"  class="form-control" id="telefono">
                <label for="">RuC</label>
                <input type="text" name="ruc"  class="form-control" id="ruc">
                <label for="">Nro. Factura</label>
                <input type="text" name="factura"  class="form-control" id="factura">
                <br>
            </fieldset>

            <fieldset>
              <legend>Datos del Usuario: Administrador: Almacen Central</legend>
              <label for="">Nombre Completo</label>
              <input type="text" name="nombreCompleto"  class="form-control" id="nombreCompleto">
              <label for="">C.I.</label>
              <input type="text" name="ci"  class="form-control" id="ci">
              <label for="">Usuario</label>
              <input type="text" name="name"  class="form-control" id="name">
              <label for="">Contraseña</label>
              <input type="password" name="password"  class="form-control" id="password">


            </fieldset>


            <input type="submit" id="boton" value="Continuar" class="btn btn-primary">
            </form>


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

  </body>
</html>
