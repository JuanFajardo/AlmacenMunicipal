'use strict';
angular.module('Almacenes')
  .factory('ConceptosResource', function($resource){
    return $resource('index.php/Conceptos/:id',
      { id:"@id"},
      { update: { method: "PUT" } }
      );
  });
