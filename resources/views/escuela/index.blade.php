@extends('layouts.admin')

@section('content')
	@include('escuela.modal')
	<div id="divider"></div>
	<div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
		<strong>Escuelas Actualizadas Exitosamente!</strong>
	</div>
	<table class="table">
		<thead>
			<th>Nombre</th>
			<th>Departamento</th>
			<th>Opciones</th>
		</thead>
		<tbody id="datos"></tbody>
	</table>
@endsection

@section('scripts')
	{!!Html::script('js/escuela.js')!!}
@endsection