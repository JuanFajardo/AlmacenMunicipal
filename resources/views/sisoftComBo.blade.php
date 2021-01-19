<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Sistema de Almacenes</title>
  <meta name="description" content="Sistema de administracion de almacenes Municipales con multiples aperturas y clasificadores">
  <meta name="author" content="Nely Diaz nelydiaz@potosi.bo, Juan Fajardo juanfajardo@potosi.bo">
  <link rel="stylesheet" href="{{asset('assets/css/bootstrap/bootstrap.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/bootstrap/bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/bootstrap-select/bootstrap-select.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/app/app.v1.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/fontawesome/font-awesome.cs')}}s">
  <link rel="stylesheet" href="{{asset('assets/css/easyautocomplete/token-input.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/easyautocomplete/token-input-facebook.css')}}">
  <link rel="stylesheet" href="{{asset('assets/datatable/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/angular-datatables/datatables.bootstrap.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/angular-datatables/datatables.bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.css')}}" />

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <![endif]-->
      <style media="screen">
        .fade {
          position: absolute;
          top: 0;
          left: 0;
          right: 0;
          height: 100%;
          opacity: 1;
        }
        .fade.ng-enter,
        .fade.ng-leave {
          -webkit-transition: all 1s ease;
          transition: all 1s ease;
        }
        .fade.ng-enter {
          opacity: 0;
        }
        .fade.ng-enter-active {
          opacity: 1;
        }
        .fade.ng-leave {
          opacity: 1;
        }
        .fade.ng-leave-active {
          opacity: 0;
        }
        ul.token-input-list {
          overflow: hidden;
          height: auto !important;
          height: 1%;
          width: 400px;
          border: 1px solid #999;
          cursor: text;
          font-size: 12px;
          font-family: Verdana;
          z-index: 999;
          margin: 0;
          padding: 0;
          background-color: #fff;
          list-style-type: none;
          clear: left;
        }

        ul.token-input-list li {
          list-style-type: none;
        }

        ul.token-input-list li input {
          border: 0;
          width: 350px;
          padding: 3px 8px;
          background-color: white;
          -webkit-appearance: caret;
        }

        li.token-input-token {
          overflow: hidden;
          height: auto !important;
          height: 1%;
          margin: 3px;
          padding: 3px 5px;
          background-color: #d0efa0;
          color: #000;
          font-weight: bold;
          cursor: default;
          display: block;
        }

        li.token-input-token p {
          float: left;
          padding: 0;
          margin: 0;
        }

        li.token-input-token span {
          float: right;
          color: #777;
          cursor: pointer;
        }

        li.token-input-selected-token {
          background-color: #08844e;
          color: #fff;
        }

        li.token-input-selected-token span {
          color: #bbb;
        }

        div.token-input-dropdown {
          position: absolute;
          width: 400px;
          background-color: #fff;
          overflow: hidden;
          border-left: 1px solid #ccc;
          border-right: 1px solid #ccc;
          border-bottom: 1px solid #ccc;
          cursor: default;
          font-size: 12px;
          font-family: Verdana;
          z-index: 1;
        }

        div.token-input-dropdown p {
          margin: 0;
          padding: 5px;
          font-weight: bold;
          color: #777;
        }

        div.token-input-dropdown ul {
          margin: 0;
          padding: 0;
        }

        div.token-input-dropdown ul li {
          background-color: #fff;
          padding: 3px;
          list-style-type: none;
        }

        div.token-input-dropdown ul li.token-input-dropdown-item {
          background-color: #fafafa;
        }

        div.token-input-dropdown ul li.token-input-dropdown-item2 {
          background-color: #fff;
        }

        div.token-input-dropdown ul li em {
          font-weight: bold;
          font-style: normal;
        }

        div.token-input-dropdown ul li.token-input-selected-dropdown-item {
          background-color: #d0efa0;
        }
      </style>
    </head>
    <body ng-app="Almacenes">

      <!-- Preloader -->
      <div class="loading-container">
        <div class="loading">
          <div class="l1">
            <div></div>
          </div>
          <div class="l2">
            <div></div>
          </div>
          <div class="l3">
            <div></div>
          </div>
          <div class="l4">
            <div></div>
          </div>
        </div>
      </div>
      <!-- Preloader -->
      <aside class="left-panel">

        <div class="user text-center">
          @if(Auth::user()->grupo == 1)
          <img src="{{asset('assets/images/avtar/admin.png')}}" class="img-circle" alt="...">
          @endif
          @if(Auth::user()->grupo == 2)
          <img src="{{asset('assets/images/avtar/encargada.png')}}" class="img-circle" alt="...">
          @endif
          @if(Auth::user()->grupo == 3)
          <img src="{{asset('assets/images/avtar/asistente.png')}}" class="img-circle" alt="...">
          @endif
          @if(Auth::user()->grupo == 4)
          <img src="{{asset('assets/images/avtar/finanzas.png')}}" class="img-circle" alt="...">
          @endif
          <h4 class="user-name">  {{Auth::user()->nombreCompleto}} </h4>

          <div class="dropdown user-login">
            <a href="{{asset('/index.php/logout')}}" style=" text-decoration: none; font-size: 10px; color: white;"> <i class="fa fa-minus-circle"></i> <b>SALIR<b></a>
          </div>
        </div>
        <nav class="navigation">
          <ul class="list-unstyled">
            <li class="@yield('index')"><a href="{{asset('index.php')}}"><i class="fa fa-bookmark-o"></i><span class="nav-label">G.A.M.T.</span></a></li>
            @if(Auth::user()->grupo == 2 || Auth::user()->grupo == 3)
            <li class="@yield('ingreso')has-submenu"><a href=""><i class="fa fa-cubes"></i> <span class="nav-label">Ingresar a Almacen</span></a>
              <ul class="list-unstyled">
                <li class="@yield('ingreso1')"><a href="{{asset('/index.php/Movimiento/nuevo')}}">Ingresar</a></li>
              </ul>
            </li>
            <li class="@yield('salida')has-submenu"><a href=""><i class="fa fa-send"></i> <span class="nav-label">Salida de Almacen</span></a>
              <ul class="list-unstyled">
                <li class="@yield('salida1')"><a href="{{asset('/index.php/Movimiento/salidaStock/Sotk')}}">Salida Stock</a></li>
                <li class="@yield('salida2')"><a href="{{asset('/index.php/Movimiento/salidaStock/combustible')}}">Salida Combustible</a></li>
              </ul>
            </li>
            <li class="@yield('movimiento')has-submenu"><a href=""><i class="fa fa-database"></i> <span class="nav-label">Movimientos</span></a>
              <ul class="list-unstyled">
                <li class="@yield('movimiento0')"><a href="{{asset('/index.php/Movimientos/auxiliar')}}">Movimientos Auxiliares</a></li>
                <li class="@yield('movimiento1')"><a href="{{asset('/index.php/Movimientos')}}">Gestion Actual</a></li>
                <li class="@yield('movimiento2')"><a href="{{asset('/index.php/Reportes/gestion')}}">Gestiones Anteriores</a></li>
              </ul>
            </li>
            @endif

            @if(Auth::user()->grupo == 2 || Auth::user()->grupo == 3 || Auth::user()->grupo == 4)
            <li class="@yield('reportes')has-submenu"><a href=""><i class="fa fa-file-pdf-o"></i> <span class="nav-label">Reportes</span></a>
              <ul class="list-unstyled">
                <!--<li class="@yield('reportes1')"><a href="{{asset('/index.php/Reportes')}}">Movimientos</a></li>-->
                <li class="@yield('reportes2')"><a href="{{asset('/index.php/Reportes/peps')}}">Inventario Fisico-Valorado </br> KARDEX </a></li>
                <li class="@yield('reportes3')"><a href="{{asset('/index.php/Reportes/catalogo')}}">Fisico</a></li>
                <li class="@yield('reportes4')"><a href="{{asset('/index.php/Reportes/apertura')}}">Aperturas Programaticas</a></li>
                <li class="@yield('reportes5')"><a href="{{asset('/index.php/Reportes/clasificador')}}">Clasificadores</a></li>
                <li class="@yield('reportes6')"><a href="{{asset('/index.php/Reportes/funcionario')}}">Funcionarios</a></li>
                <li class="@yield('reportes7')"><a href="{{asset('/index.php/Reportes/estructura')}}">Unidad Administrativa</a></li>
                <li class="@yield('reportes8')"><a href="{{asset('/index.php/Reportes/proveedor')}}">Proveedor</a></li>
                <li class="@yield('reportes9')"><a href="{{asset('/index.php/Reportes/combustible')}}">Combustible</a></li>
              </ul>
            </li>
            <li class="@yield('productos')has-submenu"><a href=""><i class="fa fa-eye-slash"></i> <span class="nav-label">Productos en Desuso </span></a>
              <ul class="list-unstyled">
                <li class="@yield('productos1')"><a href="{{asset('/index.php/Reportes/deshuso')}}">Ver</a></li>
                @if(\Request::path() == '/')
                <li class="@yield('productos2')"><a href="#/catalogo">Anular Articulo</a></li>
                @else
                <li class="@yield('productos2')"><a href="{{asset('/index.php#/catalogo')}}">Anular Articulo</a></li>
                @endif


              </ul>
            </li>
            @endif


            @if(Auth::user()->grupo == 1)
            <li class="@yield('usuario') has-submenu"><a href=""><i class="fa fa-users"></i> <span class="nav-label">USUARIOS</span></a>
              <ul class="list-unstyled">
                <li class="@yield('usuario1')"><a href="#/ruta">Ver</a></li>
              </ul>
            </li>
            <li class="@yield('logs') has-submenu"><a href=""><i class="fa fa-folder-open"></i> <span class="nav-label">LOG's</span></a>
              <ul class="list-unstyled">
                <li class="@yield('logs1')"><a href="{{asset('index.php#/navegacion')}}">Navegacion</a></li>
                <li class="@yield('logs2')"><a href="{{asset('index.php#/sesiones')}}">Session</a></li>
              </ul>
            </li>
            @endif
            @if(Auth::user()->grupo == 2)
            <li class="@yield('cierreGestion')has-submenu"><a href=""><i class="fa fa-calendar"></i> <span class="nav-label">CIERRE GESTION</span></a>
              <ul class="list-unstyled">
                <li class="@yield('cierreGestion1')"><a href="{{asset('/index.php/CierreGestion')}}">Realizar</a></li>
                <li class="@yield('cierreGestion2')"><a href="{{asset('/index.php/CambiarGestion')}}">Cambiar de Gestion</a></li>
              </ul>
            </li>
            @endif
            @if(Auth::user()->grupo == 2 || Auth::user()->grupo == 3)
            <li class="@yield('configuraciones')has-submenu"><a href=""><i class="fa fa-cog"></i> <span class="nav-label">Configuraciones</span></a>
              <ul class="list-unstyled">
                @if(\Request::path() == '/')
                <li class="@yield('configuraciones1')"><a href="#/parametros">Ver</a></li>
                @else
                <li class="@yield('configuraciones1')"><a href="{{asset('/index.php#/parametros')}}">Ver</a></li>
                @endif
              </ul>
            </li>
            @endif
            @if(Auth::user()->grupo == 1 || Auth::user()->grupo == 2)
            <li class="has-submenu"><a href=""><i class="fa fa-save"></i> <span class="nav-label">BACKUPS</span></a>
              <ul class="list-unstyled">
                <li><a href="{{asset('index.php/Reportes/backup')}}">Realizar</a></li>
              </ul>
            </li>
            @endif
          </ul>
        </nav>

      </aside>
      <!-- Aside Ends-->

      <section class="content">

        <header class="top-head container-fluid">
          <button type="button" class="navbar-toggle pull-left">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          @if(Auth::user()->grupo == 2 )
          <ul class="nav-toolbar">
            <?php $nro = \App\Movimientos::Where('auxiliar', '=', 'NO')->count(); ?>
            <li class="dropdown"><a data-toggle="dropdown"><i class="fa fa-bell-o"></i><span class="badge" style="background-color:red;"> {{$nro}} </span></a>
              <div class="dropdown-menu arrow pull-right md panel panel-default arrow-top-right notifications">
                <div class="panel-heading">
                  Notificaciones
                </div>
                <div class="list-group">
                  <?php $notificaciones =  \DB::table('movimientos')->join('users', 'movimientos.id_usuario', '=', 'users.id')
                    ->where('movimientos.auxiliar', '=', 'NO')
                    ->groupBy('movimientos.id_usuario')
                    ->select('users.nombreCompleto', \DB::raw('count(movimientos.id_usuario) as numero'))->get();
                  ?>
                  @foreach($notificaciones as $notificacion)
                  <a href="{{asset('/Movimientos/auxiliar')}}" class="list-group-item">
                    <div class="media">
                      <div class="user-status busy pull-left">
                        <img class="media-object img-circle pull-left" src="{{asset('/assets/images/avtar/asistente.png')}}" alt="user#1" width="40">
                      </div>
                      <div class="media-body">
                        <h5 class="media-heading">{{$notificacion->nombreCompleto}}</h5>
                        <small class="text-muted">Tiene {{$notificacion->numero}} documentos por revisar</small>
                      </div>
                    </div>
                  </a>
                  @endforeach

                </div>
              </div>
            </li>
          </ul>
          @endif
        </header>
        <!-- Header Ends -->
        <div class="warper container-fluid">
          @yield('contenido')
        </div>
        <!-- Warper Ends Here (working area)-->

        <footer class="container-fluid footer">
          Copyright &copy; {{ date('Y') }} <a href="http://www.facebook.com.bo/" target="_blank"> EM-AISSI <i class="fa fa-firefox" aria-hidden="true"></i></a>
          <a href="#" class="pull-right scrollToTop"><i class="fa fa-chevron-up"></i></a>
        </footer>
      </section>
      <script src="{{asset('assets/jquery/jquery-3.1.1.min.js')}}"></script>
      <script src="{{asset('assets/js/jquery/jquery-1.9.1.min.js')}}"></script>
      <script src="{{asset('assets/js/plugins/nicescroll/jquery.nicescroll.min.js')}}"></script>
      <script src="{{asset('assets/js/app/custom.js')}}" type="text/javascript"></script>
      <script src="{{asset('assets/js/moment/moment.js')}}"></script>
      <script src="{{asset('assets/angular/angular.min.js')}}"></script>
      <script src="{{asset('assets/angular/angular-resource.js')}}"></script>
      <script src="{{asset('assets/angular/angular-route.js')}}"></script>
      <script src="{{asset('assets/angular/angular-animate.js')}}"></script>
      <script src="{{asset('scripts/route.js')}}"></script>
      <script src="{{asset('scripts/controllers/almacen.js')}}"></script>
      <script src="{{asset('scripts/services/AlmacenesServices.js')}}"></script>
      <script src="{{asset('scripts/controllers/estructura.js')}}"></script>
      <script src="{{asset('scripts/services/EstructurasServices.js')}}"></script>
      <script src="{{asset('scripts/controllers/cambio.js')}}"></script>
      <script src="{{asset('scripts/services/CambiosServices.js')}}"></script>
      <script src="{{asset('scripts/controllers/concepto.js')}}"></script>
      <script src="{{asset('scripts/services/ConceptosServices.js')}}"></script>
      <script src="{{asset('scripts/controllers/funcionario.js')}}"></script>
      <script src="{{asset('scripts/services/FuncionariosServices.js')}}"></script>
      <script src="{{asset('scripts/controllers/clasificador.js')}}"></script>
      <script src="{{asset('scripts/services/ClasificadoresServices.js')}}"></script>
      <script src="{{asset('scripts/controllers/apertura.js')}}"></script>
      <script src="{{asset('scripts/services/AperturasServices.js')}}"></script>
      <script src="{{asset('scripts/controllers/proveedor.js')}}"></script>
      <script src="{{asset('scripts/services/ProveedoresServices.js')}}"></script>
      <script src="{{asset('scripts/controllers/bien.js')}}"></script>
      <script src="{{asset('scripts/services/BienesServices.js')}}"></script>
      <script src="{{asset('scripts/controllers/unidad.js')}}"></script>
      <script src="{{asset('scripts/services/UnidadesServices.js')}}"></script>
      <script src="{{asset('scripts/controllers/articulosmovimientos.js')}}"></script>
      <script src="{{asset('scripts/services/ArticulosMovimientosServices.js')}}"></script>
      <script src="{{asset('scripts/controllers/ruta.js')}}"></script>
      <script src="{{asset('scripts/services/RutasServices.js')}}"></script>
      <script src="{{asset('scripts/controllers/log.js')}}"></script>
      <script src="{{asset('scripts/services/LogServices.js')}}"></script>
      <script src="{{asset('scripts/controllers/configuracion.js')}}"></script>
      <script src="{{asset('scripts/services/ConfiguracionesServices.js')}}"></script>
      <script src="{{asset('scripts/controllers/movimiento.js')}}"></script>
      <script src="{{asset('scripts/services/MovimientosServices.js')}}"></script>
      <script src="{{asset('assets/angular-datatables/angular-datatables.min.js')}}"></script>
      <script src="{{asset('assets/angular-datatables/jquery.dataTables.min.js')}}"></script>
      <script src="{{asset('assets/js/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js')}}"></script>
      <script src="{{asset('assets/js/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.es.js')}}"></script>
      <script src="{{asset('assets/js/plugins/graficos/d3.v3.min.js')}}"></script>
      <script src="{{asset('assets/css/bootstrap-select/bootstrap-select.js')}}"></script>
      <script src="{{asset('assets/js/plugins/underscore/underscore-min.js')}}"></script>
      <script src="{{asset('assets/js/bootstrap/bootstrap.min.js')}}"></script>
      <script src="{{asset('assets/datatable/jquery.dataTables.min.js')}}"></script>
      <script src="{{asset('assets/js/globalize/globalize.min.js')}}"></script>
      <script src="{{asset('assets/js/angular/todo.js')}}"></script>
      <script src="{{asset('assets/css/easyautocomplete/jquery.tokeninput.js')}}"></script>
      <script src="{{asset('assets/js/plugins/solotexto.js')}}"></script>
      <script src="{{asset('assets/js/plugins/sincaracter.js')}}"></script>

      @yield('js')
</body>
</html>
