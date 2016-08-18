@extends('layouts.admin')

@section('content')
	@include('visita.modal')
	@include('alerts.dangerRemove')
	@include('visita.modalDet')
	@include('alerts.dangerRemove')
	@if (Auth::user()->id <= 5)
	<div id="divider"></div>
	<div class="row">
		<div class="col-lg-8">
			<p></p>	
		</div>
		<div class="col-lg-3">
			<div class="input-group">
				<div class="input-group-btn">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><b id="filtrar">Fecha</b> <span class="caret"></span></button>
					<ul class="dropdown-menu">
						<li><a href="#" id="select-fec">Fecha</a></li>
						<li><a href="#" id="select-ofc">Oficial</a></li>
						<li><a href="#" id="select-esc">Escuela</a></li>
						<li><a href="#" id="select-are">Area</a></li>
					</ul>
				</div>

				<div class="input-group-btn hide" id="search-ofc">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i id="label-ofc"></i> <span class="caret"></span></button>
					<ul class="dropdown-menu" id="ofcs"></ul>
				</div>
				<input type="text" class="form-control hide" id="search-esc" placeholder="filtrar...">
				<input type="date" class="form-control" id="search-fec" aria-describedby="sizing-addon2">
				<div class="input-group-btn hide" id="search-are">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i id="label-are"></i> <span class="caret"></span></button>
					<ul class="dropdown-menu" id="ares"></ul>
				</div>

				<span class="input-group-btn">
					<button id="search" class="btn btn-default" type="button">Buscar</button>
				</span>
			</div>
		</div>
	</div>
	@endif
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