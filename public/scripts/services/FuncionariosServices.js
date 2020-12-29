'use strict';
angular.module('Almacenes')
  .factory('FuncionariosResource', function($resource){
    return $resource('index.php/Funcionarios/:id',
      { id:"@id"},
      { update: { method: "PUT" } }
      );
  });
