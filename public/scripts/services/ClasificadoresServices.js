'use strict';
angular.module('Almacenes')
  .factory('ClasificadoresResource', function($resource){
    return $resource('index.php/Clasificadores/:id',
      { id:"@id"},
      { update: { method: "PUT" } }
      );
  });
