'use strict';

angular.module('Almacenes')
  .controller('IndexFuncionarioCtrl', function($scope, FuncionariosResource, $location, $timeout, DTOptionsBuilder, DTColumnBuilder){
    $scope.title = "Funcionarios";
    $scope.icono = "file-text-o";
    $scope.Funcionarios = FuncionariosResource.query();
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
  .controller('CreateFuncionarioCtrl', function($scope, FuncionariosResource, EstructurasResource, $location, $timeout){
    $scope.botonIcono = "fa fa-plus-circle";
    $scope.icono = "file-text-o";
    $scope.title = "Funcionarios - Nuevo";
    $scope.button = "Guardar";
    $scope.accion = "btn btn-primary";
    $scope.Funcionarios={};
    $scope.Estructuras = EstructurasResource.query();

    $scope.saveFuncionarios = function(){
      FuncionariosResource.save($scope.Funcionarios);
      $scope.panel = "alert alert-info";
      $scope.msj = "Se inserto el dato correctamente!";
      $timeout(function(){
        $location.path('/funcionario');
      }, 1000);
    };
  })
  .controller('ViewFuncionarioCtrl', function($scope, FuncionariosResource, EstructurasResource, $routeParams){
    $scope.title = "Funcionarios - Detalles";
    $scope.icono = "file-text-o";
    $scope.Estructuras = EstructurasResource.query();
    $scope.Funcionarios = FuncionariosResource.get({
      id: $routeParams.id
    });
  })
  .controller('DelFuncionarioCtrl', function($scope, FuncionariosResource, $routeParams, $location, $timeout  ){
    $scope.title = "Funcionarios - Eliminar";
    $scope.icono = "file-text-o";
    $scope.Funcionarios = FuncionariosResource.get({
      id: $routeParams.id
    });
    $scope.removeFuncionarios = function(id){
      FuncionariosResource.delete({
        id: id
      });
      $timeout(function(){
        $location.path('/funcionario');
      }, 100);
    };

  })
  .controller('EditFuncionarioCtrl', function($scope, FuncionariosResource, EstructurasResource, $location, $timeout, $routeParams){
    $scope.title = "Funcionarios - Editar";
    $scope.botonIcono = "fa fa-pencil";
    $scope.button = "Actualizar";
    $scope.accion = "btn btn-warning";
    $scope.icono = "file-text-o";
    $scope.Estructuras = EstructurasResource.query();
    $scope.Funcionarios = FuncionariosResource.get({
      id: $routeParams.id
    });
    $scope.saveFuncionarios = function(){
      FuncionariosResource.update($scope.Funcionarios);
      $scope.msj = "Se Actualizo correctamente!";
      $scope.panel = "alert alert-warning";
      $timeout(function(){
        $location.path('/funcionario');
      }, 1000);
    }
  });
