@extends('layouts.admin')

@section('content')
	@include('escuela.modal')
	@include('alerts.dangerRemove')
	<div id="divider"></div>
	<div class="row">
		<div class="col-lg-7">
			<p></p>	
		</div>
		<div class="col-lg-5">
			<div class="input-group">
				<div class="input-group-btn">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><b id="filtrar">Escuela</b> <span class="caret"></span></button>
					<ul class="dropdown-menu">
						<li><a href="#" id="select-esc">Escuela</a></li>
						<li><a href="#" id="select-dep">Departamento</a></li>
					</ul>
				</div>

				<div class="input-group-btn hide" id="search-dep">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i id="label-dep"></i> <span class="caret"></span></button>
					<ul class="dropdown-menu" id="deps"></ul>
				</div>
				<input type="text" class="form-control" id="search-esc" placeholder="filtrar...">

				<span class="input-group-btn">
					<button id="search" class="btn btn-default" type="button">Buscar</button>
				</span>
			</div>
		</div>
	</div>
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