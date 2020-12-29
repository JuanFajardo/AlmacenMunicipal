'use strict';

angular.module('Almacenes')
  .controller('IndexEstructuraCtrl', function($scope, EstructurasResource, $location, $timeout, DTOptionsBuilder, DTColumnBuilder){
  $scope.title = "UNIDADES ADMINISTRATIVAS";
  $scope.Estructuras = EstructurasResource.query();
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

  .controller('CreateEstructuraCtrl', function($scope, EstructurasResource, $location, $timeout){
    $scope.title = "UNIDADES ADMINISTRATIVAS - NUEVO";
    $scope.button = "Guardar";
    $scope.accion = "btn btn-primary";
    $scope.estructuras = EstructurasResource.query();
    $scope.Estructuras={};
    $scope.saveEstructura = function(){
      EstructurasResource.save($scope.Estructuras);
      $scope.panel = "alert alert-info";
      $scope.msj = "Se inserto el dato correctamente!";
      $timeout(function(){
        $location.path('/estructura');
      }, 1000);
    };
  })

  .controller('ViewEstructuraCtrl', function($scope, EstructurasResource, $routeParams){
    $scope.title = "UNIDADES ADMINISTRATIVAS - DETALLES";
    $scope.Estructuras = EstructurasResource.get({
      id: $routeParams.id
    });
  })

  .controller('DelEstructuraCtrl', function($scope, EstructurasResource, $routeParams, $location, $timeout  ){
    $scope.title = "UNIDADES ADMINISTRATIVAS - ELIMINAR";
    $scope.Estructuras = EstructurasResource.get({
      id: $routeParams.id
    });
    $scope.removeEstructura = function(id){
      EstructurasResource.delete({
        id: id
      });
      $timeout(function(){
        $location.path('/estructura');
      }, 100);
    };
  })

  .controller('EditEstructuraCtrl', function($scope, EstructurasResource, $location, $timeout, $routeParams){
    $scope.title = "UNIDADES ADMINISTRATIVAS - EDITAR";
    $scope.button = "Actualizar";
    $scope.accion = "btn btn-warning";
    $scope.estructuras = EstructurasResource.query();
    $scope.Estructuras = EstructurasResource.get({
      id: $routeParams.id
    });
    $scope.saveEstructura = function(){
      EstructurasResource.update($scope.Estructuras);
      $scope.msj = "Se Actualizo correctamente!";
      $scope.panel = "alert alert-warning";
      $timeout(function(){
        $location.path('/estructura');
      }, 1000);
    }


  });
