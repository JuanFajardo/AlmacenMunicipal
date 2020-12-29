'use strict';

angular.module('Almacenes')
  .controller('IndexAutomovilCtrl', function($scope, $http, AutomovilResource, UnidadesResource, ClasificadoresResource, AlmacenesResource, $location, $timeout){//, DTOptionsBuilder, DTColumnBuilder){
    $scope.title = "Automovil";
    $scope.icono = "file-text-o";

    $http({url: 'index.php/Automovil?page=1', method: "GET"}).success(function(response) {
      $scope.Bienes       =response[0].data;
      $scope.totalPages   = response[0].last_page;
      $scope.currentPage  = response[0].current_page;
      var pages = [];
      for(var i=1;i<=response[0].last_page;i++) {
        pages.push(i);
      }
      $scope.range = pages;
    });

    $scope.cargar = function(){
      $http({url: 'index.php/Automovil/buscar/'+$scope.buscar, method: "GET"}).success(function(response) {
        $scope.Bienes = response[0].data;
      });
    }

    $scope.UnidadesResource = UnidadesResource.query();
    $scope.Clasificadores = ClasificadoresResource.query();
    $scope.Almacenes = AlmacenesResource.query();

  })

  .controller('CreateAutomovilCtrl', function($scope, AutomovilResource, UnidadesResource, ClasificadoresResource, AlmacenesResource, $location, $timeout){
    $scope.botonIcono = "fa fa-plus-circle";
    $scope.icono = "file-text-o";
    $scope.title = "Automovil - Nuevo";
    $scope.button = "Guardar";
    $scope.accion = "btn btn-primary";
    $scope.Bienes={};

    $scope.Unidades = UnidadesResource.query();
    $scope.Clasificadores = ClasificadoresResource.query();
    $scope.Almacenes = AlmacenesResource.query();

    $scope.saveAutomovil = function(){
      AutomovilResource.save($scope.Automovil);
      $scope.panel = "alert alert-info";
      $scope.msj = "Se inserto el dato correctamente!";
      $timeout(function(){
        $location.path('/automovil');
      }, 1000);
    };
  })

  .controller('ViewAutomovilCtrl', function($scope, AutomovilResource, UnidadesResource, ClasificadoresResource, AlmacenesResource, $routeParams){
    $scope.title = "Automovil - Detalles";
    $scope.icono = "file-text-o";
    $scope.Unidades = UnidadesResource.query();
    $scope.Clasificadores = ClasificadoresResource.query();
    $scope.Almacenes = AlmacenesResource.query();
    $scope.Bienes = BienesResource.get({
      id: $routeParams.id
    });
  })

  .controller('DelBienCtrl', function($scope, BienesResource, $routeParams, $location, $timeout  ){
    $scope.title = "Bienes - Eliminar";
    $scope.icono = "file-text-o";
    $scope.Bienes = BienesResource.get({
      id: $routeParams.id
    });
    $scope.removeBien = function(id){
      BienesResource.delete({
        id: id
      });
      $timeout(function(){
        $location.path('/bien');
      }, 100);
    };
  })

  .controller('EditBienCtrl', function($scope, BienesResource, UnidadesResource, ClasificadoresResource, AlmacenesResource, $location, $timeout, $routeParams){
    $scope.title = "Bienes - Editar";
    $scope.botonIcono = "fa fa-pencil";
    $scope.button = "Actualizar";
    $scope.accion = "btn btn-warning";
    $scope.icono = "file-text-o";
    $scope.Unidades = UnidadesResource.query();
    $scope.Clasificadores = ClasificadoresResource.query();
    $scope.Almacenes = AlmacenesResource.query();
    $scope.Bienes = BienesResource.get({
      id: $routeParams.id
    });
    $scope.saveBien = function(){
      BienesResource.update($scope.Bienes);
      $scope.msj = "Se Actualizo correctamente!";
      $scope.panel = "alert alert-warning";
      $timeout(function(){
        $location.path('/bien');
      }, 1000);
    }
  });
