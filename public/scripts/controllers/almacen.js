'use strict';

angular.module('Almacenes')
  .controller('IndexAlmacenCtrl', function($scope, AlmacenesResource, $location, $timeout){
    $scope.title = "ALMACENES";
    $scope.icono = "file-text-o";
    $scope.Almacenes = AlmacenesResource.query();
  })
  .controller('CreateAlmacenCtrl', function($scope, AlmacenesResource, $location, $timeout){
    $scope.botonIcono = "fa fa-plus-circle";
    $scope.icono = "file-text-o";
    $scope.title = "ALMACENES - NUEVO";
    $scope.button = "Guardar";
    $scope.accion = "btn btn-primary";
    $scope.Almacenes={};

    $scope.saveAlmacen = function(){
      AlmacenesResource.save($scope.Almacenes);
      $scope.panel = "alert alert-info";
      $scope.msj = "Se inserto el dato correctamente!";
      $timeout(function(){
        $location.path('/almacen');
      }, 1000);
    };
  })
  .controller('ViewAlmacenCtrl', function($scope, AlmacenesResource, $routeParams){
    $scope.title = "ALMACENES - DETALLES";
    $scope.icono = "file-text-o";
    $scope.Almacenes = AlmacenesResource.get({
      id: $routeParams.id
    });
  })
  .controller('DelAlmacenCtrl', function($scope, AlmacenesResource, $routeParams, $location, $timeout  ){
    $scope.title = "ALMACENES - ELIMINAR";
    $scope.icono = "file-text-o";
    $scope.Almacenes = AlmacenesResource.get({
      id: $routeParams.id
    });
    $scope.removeAlmacen = function(id){
      AlmacenesResource.delete({
        id: id
      });
      $timeout(function(){
        $location.path('/almacen');
      }, 100);
    };

  })
  .controller('EditAlmacenCtrl', function($scope, AlmacenesResource, $location, $timeout, $routeParams){
    $scope.title = "ALMACENES - EDITAR";
    $scope.botonIcono = "fa fa-pencil";
    $scope.button = "Actualizar";
    $scope.accion = "btn btn-primary";
    $scope.icono = "file-text-o";
    $scope.Almacenes = AlmacenesResource.get({
      id: $routeParams.id
    });
    $scope.saveAlmacen = function(){
      AlmacenesResource.update($scope.Almacenes);
      $scope.msj = "Se Actualizo correctamente!";
      $scope.panel = "alert alert-warning";
      $timeout(function(){
        $location.path('/almacen');
      }, 1000);
    }
  });
