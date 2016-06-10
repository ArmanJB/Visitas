@extends('layouts.visitaAdmin')

@section('content')
	@include('visita.modal')
	@include('visita.modalDet')
	<div id="divider"></div>
	<div id="divider"></div>
	<div class="content-visita">
		<div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
			<strong>Visita Editada Exitosamente!</strong>
		</div>
		<table id="tabla-visitas" class="table">
			<thead>
				<th>Fecha</th>
				<th>Oficial</th>
				<th>Escuela</th>
				<th>Opciones</th>
			</thead>
			<tbody id="datos"></tbody>
		</table>
	</div>

@endsection

@section('scripts')
	{!!Html::script('js/visita.js')!!}
@endsection