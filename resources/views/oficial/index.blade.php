@extends('layouts.admin')

@section('content')
	@include('oficial.modal')
	<div id="divider"></div>
	<div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
		<strong>Oficiales Actualizados Exitosamente!</strong>
	</div>
	<table class="table">
		<thead>
			<th>Nombres</th>
			<th>Apellidos</th>
			<th>Área</th>
			<th>Meta mensual</th>
			<th>Opciones</th>
		</thead>
		<tbody id="datos"></tbody>
	</table>
@endsection

@section('scripts')
	{!!Html::script('js/oficial.js')!!}
@endsection