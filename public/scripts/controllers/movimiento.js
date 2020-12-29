'use strict';

angular.module('Almacenes')

  .controller('IndexMovimientoCtrl', function($scope, MovimientosResource, $location, $timeout,  DTOptionsBuilder, DTColumnBuilder){
    var dato=0;
    $scope.title = "Movimientos";
    $scope.icono = "file-text-o";
    $scope.Movimientos = MovimientosResource.query();
    $scope.vm = {};
    $scope.vm.dtOptions = DTOptionsBuilder.newOptions()
    .withOption(
      "language",{
          "sProcessing":     "Procesando...",
          "sLengthMenu":     "Mostrar _MENU_ registros",
          "sZeroRecords":    "No se encontraron resultados",
          "sEmptyTable":     "Ningún dato disponible en esta tabla",
          "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
          "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
          "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
          "sInfoPostFix":    "",
          "sSearch":         "Buscar:",
          "sUrl":            "",
          "sInfoThousands":  ",",
          "sLoadingRecords": "Cargando...",
          "oPaginate": {
              "sFirst":    "Primero",
              "sLast":     "Último",
              "sNext":     "Siguiente",
              "sPrevious": "Anterior"
          },
          "oAria": {
              "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
              "sSortDescending": ": Activar para ordenar la columna de manera descendente"
          }
        }
      )
    .withOption('order', [0, 'asc']);
  })


  .controller('CreateMovimientoCtrl', function($scope, MovimientosResource, $http, ConceptosResource, ProveedoresResource, FuncionariosResource, EstructurasResource, $location, $timeout){
    $scope.botonIcono = "fa fa-plus-circle";
    $scope.icono = "file-text-o";
    $scope.title = "Movimientos - NUEVO ";
    $scope.button = "Guardar";
    $scope.accion = "btn btn-primary";

    $scope.botonActivar = false;
    $scope.sumaTotal = false;



    $scope.cambio = function(){
        $scope.botonActivar = true;
        $scope.Movimientos.total_factura = $scope.montoTotal;
        $scope.montoTotal = parseFloat($scope.montoTotal).toLocaleString();
    }

    var url = $location.absUrl().split('#')[1];
    var dato = "";
    if(url == "/movimiento/new"){
      $http({url: "index.php/Movimientos/ver/Maximo/INGRESO",
             method: "GET"
      }).success(function(numero) {
          $scope.numero =  parseInt(numero) + 1 ;
      });
    }else if (url == "/movimiento/newPEPS") {
      $http({url: "index.php/Movimientos/ver/Maximo/STOCK_INGRESO",
             method: "GET"
      }).success(function(numero) {
          $scope.numero =  parseInt(numero) + 1 ;
      });
    }


    $scope.Conceptos = ConceptosResource.query();
    $scope.Proveedores = ProveedoresResource.query();
    $scope.Funcionarios = FuncionariosResource.query();
    $scope.Estructuras = EstructurasResource.query();
    var f = new Date();

    var url = $location.absUrl().split('#')[1];
    var dato = "";
    if(url == "/movimiento/new"){
      dato = "INGRESO";
    }else if (url == "/movimiento/newPEPS") {
      dato = "INGRESO STOCK";
    }

    $scope.Movimientos={
      movimiento: dato,
      otro_documento: " ",
      rupe: " ",
      fecha: f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate(),
      id_clasificador: 1
    };
    $scope.cargaBienes = function(){
      var identificador = $scope.Movimientos.id_clasificador;
      $http({url: "index.php/Bienes/ver/JSON/list/"+identificador,
             method: "GET",
             params: {value: $scope.bienes}
        }).success(function(usuarios) {
          $scope.bienes = usuarios;
        });
    }
    $scope.cambiaBien = function(bien, idarticulo, medida, clasificadorCode, almacenCode, bienCode){
      $scope.idarticulo = idarticulo;
      $scope.articulo = bien;
      $scope.medida = medida.toUpperCase();
      $scope.bienes = null;
      $scope.codigoVer = clasificadorCode+'.'+almacenCode+'.'+bienCode;
    }
    var total = 0;
    var index = 0;
    $scope.Articulos = [{indice:0, codigoVer:'NaN', idarticulo:'NaN', articulo:'NaN', medida:'NaN', cantidad:'NaN', precio:'NaN', falta:0}];
    $scope.agregarArticulo = function(){
        if ($scope.Articulos[0].precio == 'NaN')
           { $scope.Articulos.shift(); }
        if($scope.Articulos.length == 0 ){
              total = parseFloat($scope.Movimientos.total_factura).toFixed(2) - parseFloat($scope.precio).toFixed(2);
              index = index;
        }else{
          var i=0;
          var tamanio = parseInt($scope.Articulos.length);
          console.log(tamanio);
            var costo = parseFloat($scope.precio);
            for(i=0; i<tamanio; i++){
              costo = costo + parseFloat($scope.Articulos[i].precio);
              console.log(costo);
            }
            total = parseFloat($scope.Movimientos.total_factura).toFixed(2) - costo;
        }
        if(total >=0){
          $scope.Articulos.push({indice:(index), codigoVer:$scope.codigoVer, idarticulo:$scope.idarticulo, articulo:$scope.articulo, medida:$scope.medida, cantidad:$scope.cantidad, precio:$scope.precio, falta:(total) });
          $scope.articulo = '';
          $scope.precio   = '';
          $scope.cantidad = '';
          $scope.idarticulo = '';
          $scope.medida = '';
          if(total == 0)
            $scope.sumaTotal = true;
        }else {

        }
    };
    $scope.eliminarBien = function(id){
      $scope.Articulos.splice(parseInt(id), 1);
      $scope.articulo   = '';
      $scope.precio     = '';
      $scope.cantidad   = '';
      $scope.idarticulo = '';
      $scope.medida     = '';
    }
    $scope.saveMovimiento = function(){
      $scope.Movimientos = {
        movimiento: $scope.Movimientos.movimiento,
        fecha: $scope.Movimientos.fecha,
        rupe: $scope.Movimientos.rupe,
        hoja_ruta: $scope.Movimientos.hoja_ruta,

        codigo_pedido: $scope.Movimientos.codigo_pedido,
        orden_compra: $scope.Movimientos.orden_compra,
        glosa_entrada: $scope.Movimientos.glosa_entrada,
        motivo: '',

        tipo_factura: $scope.Movimientos.tipo_factura,
        numero_factura: $scope.Movimientos.numero_factura,
        total_factura: $scope.Movimientos.total_factura,
        otro_documento: $scope.Movimientos.otro_documento,

        id_concepto: $scope.Movimientos.id_concepto,
        id_proveedor: $scope.Movimientos.id_proveedor,
        id_funcionario: $scope.Movimientos.id_funcionario,
        movimiento_ingreso: '',

        id_apertura: $scope.Movimientos.id_apertura,
        id_clasificador: $scope.Movimientos.id_clasificador,

        articulos: $scope.Articulos
      };
      MovimientosResource.save($scope.Movimientos);
      $scope.panel = "alert alert-info";
      $scope.msj = "Se inserto el dato correctamente!";
      $timeout(function(){
        $location.path('/movimiento');
      }, 1000);
    };
  })


  .controller('ViewMovimientoCtrl', function($scope, $http, MovimientosResource, $routeParams, $location, $timeout){
    $scope.title = "Movimientos - Detalles";
    $scope.icono = "file-text-o";
    /*
    $scope.Movimientos = MovimientosResource.get({
      id: $routeParams.id
    });
    */
    $http({url: "index.php/Movimientos/"+ $routeParams.id,
           method: "GET"
      }).success(function(datos) {
        $scope.Movimientos = datos;
      });

  })

  .controller('ExitMovimientoCtrl', function($scope, $http, MovimientosResource, ConceptosResource, FuncionariosResource, $routeParams, $location, $timeout){
    $scope.title = "Movimientos - Salida";
    $scope.icono = "file-text-o";

    $scope.button = "Guardar Salida";
    $scope.accion = "btn btn-primary";

    $scope.Conceptos = ConceptosResource.query();
    $scope.Funcionarios = FuncionariosResource.query();

    $http({url: "index.php/Movimientos/"+ $routeParams.id,
           method: "GET"
    }).success(function(datos) {
        $scope.Movimientos = datos;
        $scope.fecha = $scope.Movimientos[0].fecha;
        $scope.rupe = $scope.Movimientos[0].rupe;
        $scope.hoja_ruta = $scope.Movimientos[0].hoja_ruta;
        $scope.codigo_pedido = $scope.Movimientos[0].codigo_pedido;
        $scope.orden_compra = $scope.Movimientos[0].orden_compra;
        $scope.tipo_factura = $scope.Movimientos[0].tipo_factura;
        $scope.numero_factura = $scope.Movimientos[0].numero_factura;
        $scope.total_factura = $scope.Movimientos[0].total_factura;
        $scope.otro_documento = $scope.Movimientos[0].otro_documento;
        $scope.id_proveedor = $scope.Movimientos[0].id_proveedor;
        $scope.movimiento_ingreso = $scope.Movimientos[0].id;
    });

    $http({url: "index.php/Movimientos/"+ $routeParams.id+"/apertura",
             method: "GET"
    }).success(function(datos) {
          $scope.id_apertura=datos;
    });

    $http({url: "index.php/Movimientos/"+ $routeParams.id+"/clasificador",
             method: "GET"
    }).success(function(datos) {
          $scope.id_clasificador=datos;
    });

    $scope.Articulos = [{indice:0, idarticulo:'NaN', articulo:'NaN', medida:'NaN', cantidad:'NaN', precio:'NaN', falta:0}];
    $scope.agregarArticulo = function( index, idarticulo, articulo, medida, cantidad, precio  ){
        if ($scope.Articulos[0].precio == 'NaN')
            $scope.Articulos.shift();
        $scope.Articulos.push({indice:index, idarticulo:idarticulo, articulo:articulo, medida:medida, cantidad:cantidad, precio:precio, falta:0 });
    };

    $scope.saveMovimiento = function(){
        $scope.Movimientos = {
          movimiento: 'SALIDA',
          fecha: $scope.fecha,
          rupe: $scope.rupe,
          hoja_ruta: $scope.hoja_ruta,

          codigo_pedido: $scope.codigo_pedido,
          orden_compra: $scope.orden_compra,
          glosa_entrada: '',
          glosa_salida: $scope.glosa_salida,
          motivo: '',

          tipo_factura: $scope.tipo_factura,
          numero_factura: $scope.numero_factura,
          total_factura: $scope.total_factura,
          otro_documento: $scope.otro_documento,

          id_concepto: $scope.id_concepto,
          id_proveedor: $scope.id_proveedor,
          id_funcionario: $scope.id_funcionario,
          movimiento_ingreso: $scope.movimiento_ingreso,

          id_apertura: $scope.id_apertura,
          id_clasificador: $scope.id_clasificador,
          articulos: $scope.Articulos
        };
        MovimientosResource.save($scope.Movimientos);
        $scope.panel = "alert alert-info";
        $scope.msj = "Se inserto la SALIDA correctamente!";
        $timeout(function(){
          $location.path('/movimiento');
        }, 1000);
      };

  })
  .controller('ExitPEPSMovimientoCtrl', function($scope, MovimientosResource, $http, ConceptosResource, FuncionariosResource, $location, $timeout){
      $scope.botonIcono = "fa fa-plus-circle";
      $scope.icono = "file-text-o";
      $scope.title = "Movimientos - NUEVO ";
      $scope.button = "Guardar";
      $scope.accion = "btn btn-primary";
      $scope.botonActivar = true;
      $scope.sumaTotal = false;

      $scope.cambio = function(){
          $scope.botonActivar = true;
      }
      $http({url: "index.php/Movimientos/ver/Maximo/STOCK_SALIDA",
             method: "GET"
      }).success(function(numero) {
          $scope.numero =  parseInt(numero) + 1 ;
      });
      $scope.Conceptos = ConceptosResource.query();
      $scope.Funcionarios = FuncionariosResource.query();
      var f = new Date();
      $scope.Movimientos={
        movimiento: 'SALIDA STOCK',
        otro_documento: " ",
        fecha: f.getFullYear() +"-"+ (f.getMonth() +1) + "-" + f.getDate(),
        id_clasificador: 1
      };

      $scope.cargaBienes = function(){
        $http({url: "index.php/Movimientos/STOCK_SALIDA",
               method: "GET",
               params: {value: $scope.bienes}
          }).success(function(usuarios) {
            $scope.bienes = usuarios;
          });
      }

      $scope.cambiaBien = function(bien, idarticulo, medida, clasificadorCode, almacenCode, bienCode, id, costo, cantidad){
        $scope.idarticulo = idarticulo;
        $scope.articulo = bien;
        $scope.medida = medida.toUpperCase();
        $scope.bienes = null;
        //$scope.costo = costo;
        $scope.id = id;
        $scope.codigoVer = clasificadorCode+'.'+almacenCode+'.'+bienCode;
        $scope.cantidad = cantidad;
        $scope.precio = costo;
      }
      var total = 0;
      var index = 0;
      var cost0 = 0;

      $scope.Articulos = [{indice:0, codigoVer:'NaN', idarticulo:'NaN', articulo:'NaN', medida:'NaN', cantidad:'NaN', precio:'NaN', costo:0, id:0, total:0}];
      $scope.agregarArticulo = function(){
          if ($scope.Articulos[0].precio == 'NaN')
              $scope.Articulos.shift();
          if($scope.Articulos.length == 0 ){
                total = parseFloat($scope.precio).toFixed(2) * parseInt($scope.cantidad);
                cost0 = parseFloat($scope.precio).toFixed(2) * parseInt($scope.cantidad);
                index = index;
          }else{
            var i=0;
            var tamanio = parseInt($scope.Articulos.length);
            total = 0;
            for(i=0; i<tamanio; i++){
              total = total + (parseInt($scope.Articulos[i].precio) * parseInt($scope.Articulos[i].cantidad) );

            }
            cost0 =  parseFloat($scope.precio).toFixed(2) *  parseInt($scope.cantidad);
            total = total  + cost0;
          }
          if($scope.cantidad >= 0){
            $scope.Articulos.push({indice:(index), codigoVer:$scope.codigoVer, idarticulo:$scope.idarticulo, articulo:$scope.articulo, medida:$scope.medida, cantidad:$scope.cantidad, precio:$scope.precio, costo:cost0, id:$scope.id, total:total });
            $scope.articulo   = '';
            $scope.precio     = '';
            $scope.cantidad   = '';
            $scope.idarticulo = '';
            $scope.medida     = '';
            if(total == 0)
              $scope.sumaTotal = true;
          }else {

          }
      };

      $scope.eliminarBien = function(id){
        $scope.Articulos.splice(parseInt(id), 1);
        $scope.articulo   = 'NaN';
        $scope.precio     = 'NaN';
        $scope.cantidad   = 'NaN';
        $scope.idarticulo = 'NaN';
        $scope.medida     = 'NaN';
      }

      $scope.saveMovimiento = function(){
        var i=0;
        var tamanio = parseInt($scope.Articulos.length);
        total = 0;
        for(i=0; i<tamanio; i++){
          total = total + (parseFloat($scope.Articulos[i].precio).toFixed(2) * parseInt($scope.Articulos[i].cantidad) );
        }
        $scope.Movimientos = {
          movimiento: $scope.Movimientos.movimiento,
          fecha: $scope.Movimientos.fecha,
          rupe: 0,
          hoja_ruta: 0,

          codigo_pedido: 0,
          orden_compra: 0,
          glosa_entrada: 0,
          motivo: '',

          tipo_factura: 0,
          numero_factura: 0,
          total_factura: total,
          otro_documento: $scope.Movimientos.otro_documento,

          id_concepto: $scope.Movimientos.id_concepto,
          id_proveedor: '',
          id_funcionario: $scope.Movimientos.id_funcionario,
          movimiento_ingreso: '',
          glosa_entrada: '',
          glosa_salida: $scope.Movimientos.glosa_salida,

          id_apertura: $scope.Movimientos.id_apertura,
          id_clasificador: '',

          articulos: $scope.Articulos
        };
        MovimientosResource.save($scope.Movimientos);
        $scope.panel = "alert alert-info";
        $scope.msj = "Se inserto el dato correctamente!";
        $timeout(function(){
          $location.path('/movimiento');
        }, 1000);
      };
    })


  .controller('DelMovimientoCtrl', function($scope, MovimientosResource, $routeParams, $location, $timeout  ){
    $scope.title = "Movimientos - Eliminar";
    $scope.icono = "file-text-o";
    $scope.Movimientos = MovimientosResource.get({
      id: $routeParams.id
    });
    $scope.removeMovimiento = function(id){
      MovimientosResource.delete({
        id: id
      });
      $timeout(function(){
        $location.path('/movimiento');
      }, 100);
    };

  })


  .controller('EditMovimientoCtrl', function($scope, MovimientosResource, $location, $timeout, $routeParams){
    $scope.title = "Movimientos - Editar";
    $scope.botonIcono = "fa fa-pencil";
    $scope.button = "Actualizar";
    $scope.accion = "btn btn-warning";
    $scope.icono = "file-text-o";
    $scope.Movimientos = MovimientosResource.get({
      id: $routeParams.id
    });
    $scope.saveMovimiento = function(){
      MovimientosResource.update($scope.Movimientos);
      $scope.msj = "Se Actualizo correctamente!";
      $scope.panel = "alert alert-warning";
      $timeout(function(){
        $location.path('/movimiento');
      }, 1000);
    }
  });
