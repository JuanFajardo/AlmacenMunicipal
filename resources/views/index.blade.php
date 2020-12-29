@extends('sisoftComBo')

@section('index')
active
@endsection

@section('contenido')
<div class="warper container-fluid">
    <div class="row">
        <div class="col-lg-12">
        	<div ng-view></div>
    	</div>
    </div>
</div>
@endsection
