'use strict';

angular.module('Almacenes')
  .controller('IndexAperturaCtrl', function($scope, AperturasResource, $location, $timeout, DTOptionsBuilder, DTColumnBuilder){
    $scope.title = "Aperturas Programaticas";
    $scope.icono = "file-text-o";
    $scope.Aperturas = AperturasResource.query();
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

  .controller('CreateAperturaCtrl', function($scope, AperturasResource, $location, $timeout){
    $scope.botonIcono = "fa fa-plus-circle";
    $scope.icono = "file-text-o";
    $scope.title = "Aperturas Programaticas - Nuevo";
    $scope.button = "Guardar";
    $scope.accion = "btn btn-primary";
    $scope.Aperturas={};

    $scope.saveApertura = function(){
      AperturasResource.save($scope.Aperturas);
      $scope.panel = "alert alert-info";
      $scope.msj = "Se inserto el dato correctamente!";
      $timeout(function(){
        $location.path('/apertura');
      }, 1000);
    };
  })
  .controller('ViewAperturaCtrl', function($scope, AperturasResource, $routeParams){
    $scope.title = "Aperturas Programaticas - Detalles";
    $scope.icono = "file-text-o";
    $scope.Aperturas = AperturasResource.get({
      id: $routeParams.id
    });
  })
  .controller('DelAperturaCtrl', function($scope, AperturasResource, $routeParams, $location, $timeout  ){
    $scope.title = "Aperturas Programaticas - Eliminar";
    $scope.icono = "file-text-o";
    $scope.Aperturas = AperturasResource.get({
      id: $routeParams.id
    });
    $scope.removeApertura = function(id){
      AperturasResource.delete({
        id: id
      });
      $timeout(function(){
        $location.path('/apertura');
      }, 100);
    };

  })
  .controller('EditAperturaCtrl', function($scope, AperturasResource, $location, $timeout, $routeParams){
    $scope.title = "Aperturas Programaticas - Editar";
    $scope.botonIcono = "fa fa-pencil";
    $scope.button = "Actualizar";
    $scope.accion = "btn btn-warning";
    $scope.icono = "file-text-o";
    $scope.Aperturas = AperturasResource.get({
      id: $routeParams.id
    });
    $scope.saveApertura = function(){
      AperturasResource.update($scope.Aperturas);
      $scope.msj = "Se Actualizo correctamente!";
      $scope.panel = "alert alert-warning";
      $timeout(function(){
        $location.path('/apertura');
      }, 1000);
    }
  });
