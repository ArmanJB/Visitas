@extends('layouts.admin')

@section('content')
	@include('motivo.modal')
	<div id="divider"></div>
	<div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
		<strong>Motivo Editado Exitosamente!</strong>
	</div>
	<table class="table">
		<thead>
			<th>Area</th>
			<th>Nombre</th>
			<th>Opciones</th>
		</thead>
		<tbody id="datos"></tbody>
	</table>
@endsection

@section('scripts')
	{!!Html::script('js/motivo.js')!!}
@endsection