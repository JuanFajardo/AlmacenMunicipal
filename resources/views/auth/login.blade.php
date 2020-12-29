<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sistema de Almacenes - Codigo 4060</title>
	<meta name="description" content="">
	<meta name="author" content="Codigo4046">

	<link rel="stylesheet" href="{{asset('assets/css/bootstrap/bootstrap.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/app/app.v1.css')}}" />
</head>
<body>

    <div class="container">
    	<div class="row">
      <br></br>
      <br></br>
    	<div class="col-lg-8 col-lg-offset-2">
        <?php $dato = \App\Configuraciones::find(1); ?>
        	<h3 class=" text-center" style="color: #455A64;"><b> Sistema de Almacenes <br> {{$dato->entidad}}</h3>
        </div>
        <div class="col-lg-8 col-lg-offset-5">
            <img src="{{asset('assets/images/entidad.jpg')}}" width="130px" height="150px;" style="background-repeat: no-repeat; background-position: 50%;  border-radius: 50%;  background-size: 100% auto;" >
            <hr class="clean">
        </div>
        <div class="col-lg-4 col-lg-offset-4">

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}

                 <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input id="name" type="text" class="form-control"  name="name" value="{{ old('name') }}" placeholder="Usuario">
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group input-group">
                	<span class="input-group-addon"><i class="fa fa-key"></i></span>
                  <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}"  placeholder="Contraseña">
                  @if ($errors->has('password'))
                      <span class="help-block">
                          <strong>{{ $errors->first('password') }}</strong>
                      </span>
                  @endif
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <button type="submit" class="btn btn-primary btn-flat btn-block"> <i class="fa fa-btn fa-sign-in"></i> Ingresar</button>
                    </div>
                </div>

            </form>
        </div>
        </div>
    </div>

	  <script src="{{asset('assets/js/jquery/jquery-1.9.1.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/plugins/underscore/underscore-min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/globalize/globalize.min.js')}}"></script>

</body>
</html>
