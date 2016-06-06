@extends('layouts.admin')

@section('content')
	@include('departamento.modal')
	<div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
		<strong>Departamento Editado Exitosamente!</strong>
	</div>
	<table class="table">
		<thead>
			<th>Nombre</th>
			<th>Operaciones</th>
		</thead>
		<tbody id="datos"></tbody>
	</table>
@endsection

@section('scripts')
	{!!Html::script('js/scripts.js')!!}
@endsection