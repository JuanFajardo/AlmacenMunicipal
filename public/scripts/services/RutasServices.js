'use strict';
angular.module('Almacenes')
  .factory('RutasResource', function($resource){
    return $resource('index.php/Rutas/:id',
      { id:"@id"},
      { update: { method: "PUT" } }
      );
  });
