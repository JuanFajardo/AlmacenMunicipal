'use strict';
angular.module('Almacenes')
  .factory('UnidadesResource', function($resource){
    return $resource('index.php/Unidades/:id',
      { id:"@id"},
      { update: { method: "PUT" } }
      );
  })
  .factory('GestionesResource', function($resource){
    return $resource('index.php/Gestiones/:id',
      { id:"@id"},
      { update: { method: "PUT" } }
      );
  });
