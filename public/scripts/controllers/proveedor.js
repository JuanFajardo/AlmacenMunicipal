'use strict';

angular.module('Almacenes')
  .controller('IndexProveedorCtrl', function($scope, ProveedoresResource, $location, $timeout, DTOptionsBuilder, DTColumnBuilder){
    $scope.title = "Proveedores";
    $scope.icono = "file-text-o";
    $scope.Proveedores = ProveedoresResource.query();
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
  .controller('CreateProveedorCtrl', function($scope, ProveedoresResource, $location, $timeout){
    $scope.botonIcono = "fa fa-plus-circle";
    $scope.icono = "file-text-o";
    $scope.title = "Proveedores - Nuevo";
    $scope.button = "Guardar";
    $scope.accion = "btn btn-primary";
    $scope.Proveedores={};
    $scope.entidades = [{entidad:'Empresas/Unipersonales',id:'Empresas/Unipersonales'},{entidad:'Comerciante Minorista',id:'Comerciante Minorista'}];

    $scope.saveProveedor = function(){
      ProveedoresResource.save($scope.Proveedores);
      $scope.panel = "alert alert-info";
      $scope.msj = "Se inserto el dato correctamente!";
      $timeout(function(){
        $location.path('/proveedor');
      }, 1000);
    };
  })
  .controller('ViewProveedorCtrl', function($scope, ProveedoresResource, $routeParams){
    $scope.title = "Proveedores - Detalles";
    $scope.icono = "file-text-o";
    $scope.Proveedores = ProveedoresResource.get({
      id: $routeParams.id
    });
  })
  .controller('DelProveedorCtrl', function($scope, ProveedoresResource, $routeParams, $location, $timeout  ){
    $scope.title = "Proveedor - Eliminar";
    $scope.icono = "file-text-o";
    $scope.Proveedores = ProveedoresResource.get({
      id: $routeParams.id
    });
    $scope.removeProveedor = function(id){
      ProveedoresResource.delete({
        id: id
      });
      $timeout(function(){
        $location.path('/proveedor');
      }, 100);
    };

  })
  .controller('EditProveedorCtrl', function($scope, ProveedoresResource, $location, $timeout, $routeParams){
    $scope.title = "Proveedores - Editar";
    $scope.botonIcono = "fa fa-pencil";
    $scope.button = "Actualizar";
    $scope.accion = "btn btn-warning";
    $scope.icono = "file-text-o";
    $scope.Proveedores = ProveedoresResource.get({
      id: $routeParams.id
    });
    $scope.entidades = [{entidad:'Empresas/Unipersonales',id:'Empresas/Unipersonales'},{entidad:'Comerciante Minorista',id:'Comerciante Minorista'}];
    $scope.saveProveedor = function(){
      ProveedoresResource.update($scope.Proveedores);
      $scope.msj = "Se Actualizo correctamente!";
      $scope.panel = "alert alert-warning";
      $timeout(function(){
        $location.path('/proveedor');
      }, 1000);
    }
  });
