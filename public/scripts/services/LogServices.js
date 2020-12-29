'use strict';
angular.module('Almacenes')
  .factory('LogSesionesResources', function($resource){
    return $resource('index.php/LogSesiones/:id',
      { id:"@id"},
      { update: { method: "PUT" } }
      );
  })
  .factory('LogNavegacionesResources', function($resource){
    return $resource('index.php/LogNavegaciones/:id',
      { id:"@id"},
      { update: { method: "PUT" } }
      );
  });
