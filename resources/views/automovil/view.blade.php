   
<div class="panel panel-default">
    <div class="panel-heading clean">
      <h3><i class="fa fa-users"></i>  <b>{{title}}</b> </h3>
    </div>
   
    <div class="panel-body">

      <form  autocomplete="off" class="form-horizontal" role="form" ng-submit="saveConceptos()">
        <!--<div class="form-group">
          <label class="col-lg-4 control-label">Fecha de Nacimiento</label>
          <div class="col-lg-4">
            <input type="text" class="form-control" ng-model="Funcionarios.fech_nacimiento">
          </div>
        </div>-->
        <div class="form-group">
          <label class="col-lg-4 control-label">Nombres</label>
          <div class="col-lg-4">
            <input type="text" class="form-control" ng-model="Funcionarios.nombres" style="margin:10px">
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-4 control-label">Apellido Paterno</label>
          <div class="col-lg-4">
             <input type="text" class="form-control" ng-model="Funcionarios.paterno" style="margin:10px">
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-4 control-label">Apellido Materno</label>
          <div class="col-lg-4">
            <input type="text" class="form-control" ng-model="Funcionarios.materno" style="margin:10px">
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-4 control-label">C.I.</label>
          <div class="col-lg-4">
            <input type="text" class="form-control" ng-model="Funcionarios.ci" style="margin:10px">
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-4 control-label">Telefono/Celular</label>
          <div class="col-lg-4">
            <input type="text" class="form-control" ng-model="Funcionarios.telefono" style="margin:10px">
          </div>
        </div>
        <!--<div class="form-group">
          <label class="col-lg-4 control-label">Zona</label>
          <div class="col-lg-4">
            <input type="text" class="form-control"  placeholder="Zona" ng-model="Funcionarios.zona" style="margin:10px">
          </div>
        </div>-->
        <div class="form-group">
          <label class="col-lg-4 control-label">Direccion</label>
          <div class="col-lg-4">
            <input type="text" class="form-control"  placeholder="Direccion" ng-model="Funcionarios.direccion" style="margin:10px">
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-4 control-label">Cargo</label>
          <div class="col-lg-4">
            <select class="form-control" ng-model="Funcionarios.id_estructura">
              <option ng-repeat="Estructura in Estructuras"  ng-selected="Funcionarios.id_estructura == Estructura.id"  value="{{Estructura.id}}"> {{Estructura.estructura}} </option>
            </select>
          </div>
        </div>
      </div>
      <div class="rows">
        <div class="col-md-3">
        </div>
        <div class="col-md-3">
          <a href="#/funcionario/" class="btn btn-info"> <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Atras</a>          
        </div>
      </div>
      </form>
      <div id="splineArea-chart" style="height:280px;"></div>
    </div>
</div>
