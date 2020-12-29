'use strict';
angular.module('Almacenes')
  .factory('ConfiguracionesResource', function($resource){
    return $resource('index.php/Configuraciones/:id',
      { id:"@id"},
      { update: { method: "PUT" } }
      );
  });
