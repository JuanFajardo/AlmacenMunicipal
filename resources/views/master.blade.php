<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('assets/font-awesome/css/font-awesome.css')}}">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body ng-app="Almacenes">
    <script src="{{asset('assets/angular/angular.min.js')}}"></script>
    <script src="{{asset('assets/angular/angular-resource.js')}}"></script>
    <script src="{{asset('assets/angular/angular-route.js')}}"></script>

    <div class="container">
      <div class="rows">
        <div class="col-md-4">

        </div>
        <div class="col-md-8">
          @yield('cuerpo')
        </div>
      </div>
    </div>


    <script src="{{asset('assets/jquery/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('assets/bootstrap/js/bootstrap.js')}}"></script>
    <script src="{{asset('assets/bootstrap/js/npm.js')}}"></script>
    @yield('js')

  </body>
</html>
