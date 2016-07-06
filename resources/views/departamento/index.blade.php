@extends('layouts.admin')

@section('content')
	@include('departamento.modal')
	@include('alerts.dangerRemove')
	<div id="divider"></div>
	<div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
		<strong>Departamentos Actualizados Exitosamente!</strong>
	</div>
	<table class="table">
		<thead>
			<th>Nombre</th>
			<th>Opciones</th>
		</thead>
		<tbody id="datos"></tbody>
	</table>
@endsection

@section('scripts')
	{!!Html::script('js/scripts.js')!!}
@endsection