'use strict';

angular.module('Almacenes')
  .controller('IndexRutaCtrl', function($scope, RutasResource, $location, $timeout, DTOptionsBuilder, DTColumnBuilder){
    $scope.title = "Usuarios";
    $scope.icono = "file-text-o";
    $scope.Rutas = RutasResource.query();
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
  .controller('CreateRutaCtrl', function($scope, RutasResource, AlmacenesResource, $location, $timeout){
    $scope.botonIcono = "fa fa-plus-circle";
    $scope.icono = "file-text-o";
    $scope.title = "Usuario - Nuevo";
    $scope.button = "Guardar";
    $scope.accion = "btn btn-primary";
    $scope.Rutas={};
    $scope.Grupos=[{'id':'1', 'grupo':'Administrador'}, {'id':'2', 'grupo':'Encargado'}, {'id':'3', 'grupo':'Auxiliar'}, {'id':'4', 'grupo':'Reportes'} ];
    $scope.Almacenes = AlmacenesResource.query();
    $scope.saveRutas = function(){
      RutasResource.save($scope.Rutas);
      $scope.panel = "alert alert-info";
      $scope.msj = "Se inserto el dato correctamente!";
      $timeout(function(){
        $location.path('/ruta');
      }, 1000);
    };
  })

  .controller('ViewRutaCtrl', function($scope, RutasResource, AlmacenesResource, $routeParams){
    $scope.title = "Usuario - Detalles";
    $scope.icono = "file-text-o";
    $scope.Almacenes = AlmacenesResource.query();
    $scope.Grupos=[{'id':'1', 'grupo':'Administrador'}, {'id':'2', 'grupo':'Encargado'}, {'id':'3', 'grupo':'Auxiliar'}, {'id':'4', 'grupo':'Reportes'} ];
    $scope.Rutas = RutasResource.get({
      id: $routeParams.id
    });
  })

  .controller('DelRutaCtrl', function($scope, RutasResource, $routeParams, $location, $timeout  ){
    $scope.title = "Usuario - Eliminar";
    $scope.icono = "file-text-o";
    $scope.Rutas = RutasResource.get({
      id: $routeParams.id
    });
    $scope.removeRutas = function(id){
      RutasResource.delete({
        id: id
      });
      $timeout(function(){
        $location.path('/ruta');
      }, 100);
    };
  })

  .controller('EditRutaCtrl', function($scope, RutasResource, AlmacenesResource, $location, $timeout, $routeParams){
    $scope.title = "Usuario - Editar";
    $scope.botonIcono = "fa fa-pencil";
    $scope.button = "Actualizar";
    $scope.accion = "btn btn-warning";
    $scope.icono = "file-text-o";
    $scope.Almacenes = AlmacenesResource.query();
    $scope.Grupos=[{'id':'1', 'grupo':'Administrador'}, {'id':'2', 'grupo':'Encargado'}, {'id':'3', 'grupo':'Auxiliar'}, {'id':'4', 'grupo':'Reportes'} ];
    $scope.Rutas = RutasResource.get({
      id: $routeParams.id
    });
    $scope.saveRutas = function(){
      RutasResource.update($scope.Rutas);
      $scope.msj = "Se Actualizo correctamente!";
      $scope.panel = "alert alert-warning";
      $timeout(function(){
        $location.path('/ruta');
      }, 1000);
    }
  });
