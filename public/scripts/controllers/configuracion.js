'use strict';

angular.module('Almacenes')
  .controller('IndexConfiguracionCtrl', function($scope, ConfiguracionesResource, $location, $timeout, $routeParams){
    $scope.title = "Configuraciones - Editar";
    $scope.botonIcono = "fa fa-pencil";
    $scope.button = "Actualizar";
    $scope.accion = "btn btn-warning";
    $scope.icono = "file-text-o";
    $scope.Configuraciones = ConfiguracionesResource.get({
      id: '1'
    });
    $scope.saveConfiguracion = function(){
      ConfiguracionesResource.update($scope.Configuraciones);
      $scope.msj = "Se Actualizo correctamente!";
      $scope.panel = "alert alert-warning";
      $timeout(function(){
        $location.path('/configuracion');
        $scope.msj = "";
        $scope.panel = "";
      }, 1000);
    }
  });
