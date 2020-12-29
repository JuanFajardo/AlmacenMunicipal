'use strict';

angular.module('Almacenes',['ngResource', 'ngRoute', 'ngAnimate', 'datatables'])
  .config(function($routeProvider){
    $routeProvider
          .when('/sesiones', {
            templateUrl: 'views/log/sesiones.html',
            controller: 'IndexSesionesCtrl'
          })
          .when('/navegacion', {
            templateUrl: 'views/log/navegacion.html',
            controller: 'IndexNavegacionCtrl'
          })

          .when('/catalogo', {
            templateUrl: 'views/articulosmovimientos/index.html',
            controller: 'IndexArticulosMovimientosCtrl'
          })
          .when('/catalogo/edit/:id', {
            templateUrl: 'views/articulosmovimientos/create.html',
            controller: 'EditArticulosMovimientosCtrl'
          })

          .when('/ruta', {
            templateUrl: 'views/rutas/index.html',
            controller: 'IndexRutaCtrl'
          })
          .when('/ruta/new', {
            templateUrl: 'views/rutas/create.html',
            controller: 'CreateRutaCtrl'
          })
          .when('/ruta/edit/:id', {
            templateUrl: 'views/rutas/create.html',
            controller: 'EditRutaCtrl'
          })
          .when('/ruta/view/:id', {
            templateUrl: 'views/rutas/view.html',
            controller: 'ViewRutaCtrl'
          })
          .when('/ruta/delete/:id', {
            templateUrl: 'views/rutas/delete.html',
            controller: 'DelRutaCtrl'
          })


        .when('/almacen', {
          templateUrl: 'views/almacen/index.html',
          controller: 'IndexAlmacenCtrl'
        })
        .when('/almacen/new', {
          templateUrl: 'views/almacen/create.html',
          controller: 'CreateAlmacenCtrl'
        })
        .when('/almacen/edit/:id', {
          templateUrl: 'views/almacen/create.html',
          controller: 'EditAlmacenCtrl'
        })
        .when('/almacen/view/:id', {
          templateUrl: 'views/almacen/view.html',
          controller: 'ViewAlmacenCtrl'
        })
        .when('/almacen/delete/:id', {
          templateUrl: 'views/almacen/delete.html',
          controller: 'DelAlmacenCtrl'
        })


      .when('/estructura', {
        templateUrl: 'views/estructura/index.html',
        controller: 'IndexEstructuraCtrl'
      })
      .when('/estructura/new', {
        templateUrl: 'views/estructura/create.html',
        controller: 'CreateEstructuraCtrl'
      })
      .when('/estructura/edit/:id', {
        templateUrl: 'views/estructura/edit.html',
        controller: 'EditEstructuraCtrl'
      })
      .when('/estructura/view/:id', {
        templateUrl: 'views/estructura/view.html',
        controller: 'ViewEstructuraCtrl'
      })
      .when('/estructura/delete/:id', {
        templateUrl: 'views/estructura/delete.html',
        controller: 'DelEstructuraCtrl'
      })
      .when('/cambio', {
        templateUrl: 'views/cambio/index.html',
        controller: 'IndexCambioCtrl'
      })
      .when('/cambio/new', {
        templateUrl: 'views/cambio/create.html',
        controller: 'CreateCambioCtrl'
      })
      .when('/cambio/edit/:id', {
        templateUrl: 'views/cambio/create.html',
        controller: 'EditCambioCtrl'
      })
      .when('/cambio/view/:id', {
        templateUrl: 'views/cambio/view.html',
        controller: 'ViewCambioCtrl'
      })
      .when('/cambio/delete/:id', {
        templateUrl: 'views/cambio/delete.html',
        controller: 'DelCambioCtrl'
      })
      .when('/concepto', {
        templateUrl: 'views/concepto/index.html',
        controller: 'IndexConceptoCtrl'
      })
      .when('/concepto/new', {
        templateUrl: 'views/concepto/create.html',
        controller: 'CreateConceptoCtrl'
      })
      .when('/concepto/edit/:id', {
        templateUrl: 'views/concepto/create.html',
        controller: 'EditConceptoCtrl'
      })
      .when('/concepto/view/:id', {
        templateUrl: 'views/concepto/view.html',
        controller: 'ViewConceptoCtrl'
      })
      .when('/concepto/delete/:id', {
        templateUrl: 'views/concepto/delete.html',
        controller: 'DelConceptoCtrl'
      })
      .when('/funcionario', {
        templateUrl: 'views/funcionario/index.html',
        controller: 'IndexFuncionarioCtrl'
      })
      .when('/funcionario/new', {
        templateUrl: 'views/funcionario/create.html',
        controller: 'CreateFuncionarioCtrl'
      })
      .when('/funcionario/edit/:id', {
        templateUrl: 'views/funcionario/create.html',
        controller: 'EditFuncionarioCtrl'
      })
      .when('/funcionario/view/:id', {
        templateUrl: 'views/funcionario/view.html',
        controller: 'ViewFuncionarioCtrl'
      })
      .when('/funcionario/delete/:id', {
        templateUrl: 'views/funcionario/delete.html',
        controller: 'DelFuncionarioCtrl'
      })
      .when('/clasificador', {
        templateUrl: 'views/clasificador/index.html',
        controller: 'IndexClasificadorCtrl'
      })
      .when('/clasificador/new', {
        templateUrl: 'views/clasificador/create.html',
        controller: 'CreateClasificadorCtrl'
      })
      .when('/clasificador/edit/:id', {
        templateUrl: 'views/clasificador/create.html',
        controller: 'EditClasificadorCtrl'
      })
      .when('/clasificador/view/:id', {
        templateUrl: 'views/clasificador/view.html',
        controller: 'ViewClasificadorCtrl'
      })
      .when('/clasificador/delete/:id', {
        templateUrl: 'views/clasificador/delete.html',
        controller: 'DelClasificadorCtrl'
      })
      .when('/apertura', {
        templateUrl: 'views/apertura/index.html',
        controller: 'IndexAperturaCtrl'
      })
      .when('/apertura/new', {
        templateUrl: 'views/apertura/create.html',
        controller: 'CreateAperturaCtrl'
      })
      .when('/apertura/edit/:id', {
        templateUrl: 'views/apertura/create.html',
        controller: 'EditAperturaCtrl'
      })
      .when('/apertura/view/:id', {
        templateUrl: 'views/apertura/view.html',
        controller: 'ViewAperturaCtrl'
      })
      .when('/apertura/delete/:id', {
        templateUrl: 'views/apertura/delete.html',
        controller: 'DelAperturaCtrl'
      })
      .when('/proveedor', {
        templateUrl: 'views/proveedor/index.html',
        controller: 'IndexProveedorCtrl'
      })
      .when('/proveedor/new', {
        templateUrl: 'views/proveedor/create.html',
        controller: 'CreateProveedorCtrl'
      })
      .when('/proveedor/edit/:id', {
        templateUrl: 'views/proveedor/create.html',
        controller: 'EditProveedorCtrl'
      })
      .when('/proveedor/view/:id', {
        templateUrl: 'views/proveedor/view.html',
        controller: 'ViewProveedorCtrl'
      })
      .when('/proveedor/delete/:id', {
        templateUrl: 'views/proveedor/delete.html',
        controller: 'DelProveedorCtrl'
      })


      .when('/bien', {
        templateUrl: 'views/bien/index.html',
        controller: 'IndexBienCtrl'
      })
      .when('/bien/new', {
        templateUrl: 'views/bien/create.html',
        controller: 'CreateBienCtrl'
      })
      .when('/bien/edit/:id', {
        templateUrl: 'views/bien/create.html',
        controller: 'EditBienCtrl'
      })
      .when('/bien/view/:id', {
        templateUrl: 'views/bien/view.html',
        controller: 'ViewBienCtrl'
      })
      .when('/bien/delete/:id', {
        templateUrl: 'views/bien/delete.html',
        controller: 'DelBienCtrl'
      })

      .when('/automovil', {
        templateUrl: 'views/automovil/index.html',
        controller: 'IndexAutomovilCtrl'
      })
      .when('/automovil/new', {
        templateUrl: 'views/automovil/create.html',
        controller: 'CreateAutomovilCtrl'
      })
      .when('/automovil/edit/:id', {
        templateUrl: 'views/automovil/create.html',
        controller: 'EditAutomovilCtrl'
      })
      .when('/automovil/view/:id', {
        templateUrl: 'views/automovil/view.html',
        controller: 'ViewAutomovilCtrl'
      })
      .when('/automovil/delete/:id', {
        templateUrl: 'views/automovil/delete.html',
        controller: 'DelAutomovilCtrl'
      })

      .when('/unidad', {
        templateUrl: 'views/unidad/index.html',
        controller: 'IndexUnidadCtrl'
      })
      .when('/unidad/new', {
        templateUrl: 'views/unidad/create.html',
        controller: 'CreateUnidadCtrl'
      })
      .when('/unidad/edit/:id', {
        templateUrl: 'views/unidad/create.html',
        controller: 'EditUnidadCtrl'
      })
      .when('/unidad/view/:id', {
        templateUrl: 'views/unidad/view.html',
        controller: 'ViewUnidadCtrl'
      })
      .when('/unidad/delete/:id', {
        templateUrl: 'views/unidad/delete.html',
        controller: 'DelUnidadCtrl'
      })


      .when('/movimiento', {
        templateUrl: 'views/movimiento/index.html',
        controller: 'IndexMovimientoCtrl'
      })
      .when('/movimiento/new', {
        templateUrl: 'views/movimiento/create.html',
        controller: 'CreateMovimientoCtrl'
      })
      .when('/movimiento/edit/:id', {
        templateUrl: 'views/movimiento/create.html',
        controller: 'EditMovimientoCtrl'
      })
      .when('/movimiento/view/:id', {
        templateUrl: 'views/movimiento/view.html',
        controller: 'ViewMovimientoCtrl'
      })
      .when('/movimiento/exit/:id', {
        templateUrl: 'views/movimiento/exit.html',
        controller: 'ExitMovimientoCtrl'
      })
      .when('/movimiento/delete/:id', {
        templateUrl: 'views/movimiento/delete.html',
        controller: 'DelMovimientoCtrl'
      })
      .when('/movimiento/newPEPS', {
        templateUrl: 'views/movimiento/create.html',
        controller: 'CreateMovimientoCtrl'
      })
      .when('/movimiento/exitPEPS', {
        templateUrl: 'views/movimiento/exitpeps.html',
        controller: 'ExitPEPSMovimientoCtrl'
      })

      .when('/configuracion', {
        templateUrl: 'views/configuracion/create.html',
        controller: 'IndexConfiguracionCtrl'
      })

      .when('/parametros', {
        templateUrl: 'views/parametros/index.html',
        controller: 'IndexConfiguracionCtrl'
      })

      .otherwise({
       templateUrl: 'views/inicio.html'
      });

  });
