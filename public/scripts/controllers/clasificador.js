'use strict';

angular.module('Almacenes')
  .controller('IndexClasificadorCtrl', function($scope, ClasificadoresResource, $location, $timeout, DTOptionsBuilder, DTColumnBuilder){
    $scope.title = "Partida Clasificatoria";
    $scope.icono = "file-text-o";
    $scope.Clasificadores = ClasificadoresResource.query();
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
  .controller('CreateClasificadorCtrl', function($scope, ClasificadoresResource, $location, $timeout){
    $scope.botonIcono = "fa fa-plus-circle";
    $scope.icono = "file-text-o";
    $scope.title = "Partida Clasificatoria - Nuevo";
    $scope.button = "Guardar";
    $scope.accion = "btn btn-primary";
    $scope.Clasificadores={};
    $scope.clasificadores = ClasificadoresResource.query();

    $scope.saveClasificador = function(){
      ClasificadoresResource.save($scope.Clasificadores);
      $scope.panel = "alert alert-info";
      $scope.msj = "Se inserto el dato correctamente!";
      $timeout(function(){
        $location.path('/clasificador');
      }, 1000);
    };
  })
  .controller('ViewClasificadorCtrl', function($scope, ClasificadoresResource, $routeParams){
    $scope.title = "Partida Clasificatoria - Detalles";
    $scope.icono = "file-text-o";
    $scope.clasificadores = ClasificadoresResource.query();
    $scope.Clasificadores = ClasificadoresResource.get({
      id: $routeParams.id
    });
  })
  .controller('DelClasificadorCtrl', function($scope, ClasificadoresResource, $routeParams, $location, $timeout  ){
    $scope.title = "Partida Clasificatoria - Eliminar";
    $scope.icono = "file-text-o";
    $scope.Clasificadores = ClasificadoresResource.get({
      id: $routeParams.id
    });
    $scope.removeClasificador = function(id){
      ClasificadoresResource.delete({
        id: id
      });
      $timeout(function(){
        $location.path('/clasificador');
      }, 100);
    };

  })
  .controller('EditClasificadorCtrl', function($scope, ClasificadoresResource, $location, $timeout, $routeParams){
    $scope.title = "Partida Clasificatoria - Editar";
    $scope.botonIcono = "fa fa-pencil";
    $scope.button = "Actualizar";
    $scope.accion = "btn btn-warning";
    $scope.icono = "file-text-o";
    $scope.clasificadores = ClasificadoresResource.query();
    $scope.Clasificadores = ClasificadoresResource.get({
      id: $routeParams.id
    });
    $scope.saveClasificador = function(){
      ClasificadoresResource.update($scope.Clasificadores);
      $scope.msj = "Se Actualizo correctamente!";
      $scope.panel = "alert alert-warning";
      $timeout(function(){
        $location.path('/clasificador');
      }, 1000);
    }
  });
