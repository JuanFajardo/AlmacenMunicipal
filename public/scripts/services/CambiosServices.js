'use strict';
angular.module('Almacenes')
  .factory('CambiosResource', function($resource){
    return $resource('index.php/Cambios/:id',
      { id:"@id"},
      { update: { method: "PUT" } }
      );
  });
