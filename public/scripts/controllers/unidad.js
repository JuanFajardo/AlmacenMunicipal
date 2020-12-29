'use strict';

angular.module('Almacenes')
  .controller('IndexUnidadCtrl', function($scope, UnidadesResource, $location, $timeout, DTOptionsBuilder, DTColumnBuilder){
    $scope.title = "Unidades";
    $scope.icono = "file-text-o";
    $scope.Unidades = UnidadesResource.query();
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

  .controller('CreateUnidadCtrl', function($scope, UnidadesResource, $location, $timeout){
    $scope.botonIcono = "fa fa-plus-circle";
    $scope.icono = "file-text-o";
    $scope.title = "Unidades - Nuevo";
    $scope.button = "Guardar";
    $scope.accion = "btn btn-primary";
    $scope.Unidades={};

    $scope.saveUnidad = function(){
      UnidadesResource.save($scope.Unidades);
      $scope.panel = "alert alert-info";
      $scope.msj = "Se inserto el dato correctamente!";
      $timeout(function(){
        $location.path('/unidad');
      }, 1000);
    };
  })
  .controller('ViewUnidadCtrl', function($scope, UnidadesResource, $routeParams){
    $scope.title = "Unidades - Detalles";
    $scope.icono = "file-text-o";
    $scope.Unidades = UnidadesResource.get({
      id: $routeParams.id
    });
  })
  .controller('DelUnidadCtrl', function($scope, UnidadesResource, $routeParams, $location, $timeout  ){
    $scope.title = "Unidades - Eliminar";
    $scope.icono = "file-text-o";
    $scope.Unidades = UnidadesResource.get({
      id: $routeParams.id
    });
    $scope.removeUnidad = function(id){
      UnidadesResource.delete({
        id: id
      });
      $timeout(function(){
        $location.path('/unidad');
      }, 100);
    };

  })
  .controller('EditUnidadCtrl', function($scope, UnidadesResource, $location, $timeout, $routeParams){
    $scope.title = "Unidades - Editar";
    $scope.botonIcono = "fa fa-pencil";
    $scope.button = "Actualizar";
    $scope.accion = "btn btn-warning";
    $scope.icono = "file-text-o";
    $scope.Unidades = UnidadesResource.get({
      id: $routeParams.id
    });
    $scope.saveUnidad = function(){
      UnidadesResource.update($scope.Unidades);
      $scope.msj = "Se Actualizo correctamente!";
      $scope.panel = "alert alert-warning";
      $timeout(function(){
        $location.path('/unidad');
      }, 1000);
    }
  });
