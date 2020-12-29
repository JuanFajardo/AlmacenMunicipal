'use strict';

angular.module('Almacenes')
  .controller('IndexConfiguracionCtrl', function($scope, ParametrosResource, $location, $timeout, $routeParams){
    $scope.title = "Parametros - Editar";
    $scope.botonIcono = "fa fa-pencil";
    $scope.button = "Actualizar";
    $scope.accion = "btn btn-warning";
    $scope.icono = "file-text-o";

  });
