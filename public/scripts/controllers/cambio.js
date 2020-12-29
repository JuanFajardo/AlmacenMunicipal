'use strict';

angular.module('Almacenes')
  .controller('IndexCambioCtrl', function($scope, CambiosResource, $location, $timeout, DTOptionsBuilder, DTColumnBuilder){
    $scope.title = "Datos del Dolar y UVF";
    $scope.icono = "flag-o";
    $scope.Cambios = CambiosResource.query();$scope.vm = {};
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

  .controller('CreateCambioCtrl', function($scope, CambiosResource, $location, $timeout){
    $scope.botonIcono = "fa fa-plus-circle";
    $scope.icono = "flag-o";
    $scope.title = "Datos del Dolar y UVF - Nuevo";
    $scope.button = "Guardar";
    $scope.accion = "btn btn-primary";

    $scope.Cambios={};
    $scope.saveCambios = function(){
      CambiosResource.save($scope.Cambios);
      $scope.panel = "alert alert-info";
      $scope.msj = "Se inserto el dato correctamente!";
      $timeout(function(){
        $location.path('/cambio');
      }, 1000);
    };
  })

  .controller('ViewCambioCtrl', function($scope, CambiosResource, $routeParams){
    $scope.title = "Datos del Dolar y UVF - Detalles";
    $scope.icono = "flag-o";
    $scope.Cambios = CambiosResource.get({
      id: $routeParams.id
    });
  })

  .controller('DelCambioCtrl', function($scope, CambiosResource, $routeParams, $location, $timeout  ){
    $scope.title = "Datos del Dolar y UVF - Eliminar";
    $scope.icono = "flag-o";
    $scope.Cambios = CambiosResource.get({
      id: $routeParams.id
    });
    $scope.removeCambios = function(id){
      CambiosResource.delete({
        id: id
      });
      $timeout(function(){
        $location.path('/cambio');
      }, 100);
    };

  })

  .controller('EditCambioCtrl', function($scope, CambiosResource, $location, $timeout, $routeParams){
    $scope.title = "Datos del Dolar y UVF - Editar";
    $scope.botonIcono = "fa fa-pencil";
    $scope.button = "Actualizar";
    $scope.accion = "btn btn-warning";
    $scope.icono = "flag-o";
    $scope.Cambios = CambiosResource.get({
      id: $routeParams.id
    });
    $scope.saveCambios = function(){
      CambiosResource.update($scope.Cambios);
      $scope.msj = "Se Actualizo correctamente!";
      $scope.panel = "alert alert-warning";
      $timeout(function(){
        $location.path('/cambio');
      }, 1000);
    }


  });
