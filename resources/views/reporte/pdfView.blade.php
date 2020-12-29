<html>
<head>
  <title> {{$name}} </title>
  <link rel="stylesheet" href="{{asset('assets/css/bootstrap/bootstrap.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/bootstrap/bootstrap.min.css')}}" />
</head>
<body>


  <div class="container">
    <div class="row">
      <div class="col-md-2"></div>
      @if( $tipoMovimiento == 'INGRESO')
        <?php 
        $existe = \DB::table('movimientos')->where('movimiento_ingreso', '=', $id )->count();
        if( $existe > 0)
        {
          ?>
          <div class="col-md-3"> <a href="{{asset('index.php/Movimientos')}}" class="btn btn-primary btn-lg"> Menu Movimientos </a> </div>
          <?php
        }
        else { ?> 
          <div class="col-md-3"> <a href="{{asset('index.php/Movimientos/'.$id.'/salir')}}" class="btn btn-danger  btn-lg"> Salida Inmediata</a> </div>
          <div class="col-md-3"> <a href="{{asset('index.php/Movimientos')}}" class="btn btn-primary btn-lg"> Menu Movimientos </a> </div>

        <?php } ?>
      @endif
      @if( $tipoMovimiento == 'INGRESO STOCK' || $tipoMovimiento == 'SALIDA STOCK' || $tipoMovimiento == 'SALIDA' )
        
          <div class="col-md-3"> <a href="{{asset('index.php/Movimientos')}}" class="btn btn-primary btn-lg"> Menu Movimientos </a> </div>
          
      @endif

      
    </div>
    <br><br>
    <div class="row">
      <div class="col-md-12">
        <iframe src="{{asset($name)}}" width="100%" height="90%" >
      </div>
    </div>

  </div>
      <script src="{{asset('assets/jquery/jquery-3.1.1.min.js')}}"></script>
      <script src="{{asset('assets/js/jquery/jquery-1.9.1.min.js')}}"></script>
      <script src="{{asset('assets/js/bootstrap/bootstrap.min.js')}}"></script>
</body>
</html>
