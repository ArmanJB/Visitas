@extends('layouts.admin')

@section('content')
	@include('catalogos.modals.danger')
	@include('catalogos.modals.edit')
	<section class="content">
		<div class="row">
			<div class="col-lg-12">
				<h3><a class="linkInfo"><i class="fa fa-circle-o"></i> <b>Catálogos para Visitas</b></a></h3><hr>
				<section class="col-lg-6 connectedSortable">
					<div class="box box-solid bg-light-blue-gradient collapsed-box">
						<div class="box-header">
							<div class="pull-right box-tools">
								<button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Minimizar" style="margin-right: 5px;">
								<i class="fa fa-plus"></i></button>
							</div>
							<i class="fa fa-sitemap"></i><h3 class="box-title">Áreas</h3>
						</div>
						<div class="box-body">
							<div id="msjarea" class="alert alert-success alert-dismissible" role="alert" style="display:none">
								<strong id="msjarea-text"></strong>
							</div>
							
							<form class="form-inline">
								<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
								@include('area.forms.area')
							</form>
							<br>
							<table class="table">
								<thead><th>Nombre</th><th>Opciones</th></thead>
								<tbody id="datosarea"></tbody>
							</table>

						</div>
					</div>
				</section>
				<section class="col-lg-6 connectedSortable">
					<div class="box box-solid bg-light-blue-gradient collapsed-box">
						<div class="box-header">
							<div class="pull-right box-tools">
								<button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Minimizar" style="margin-right: 5px;">
								<i class="fa fa-plus"></i></button>
							</div>
							<i class="fa fa-map"></i><h3 class="box-title">Departamentos</h3>
						</div>
						<div class="box-body">
							<div id="msjdepartamento" class="alert alert-success alert-dismissible" role="alert" style="display:none">
								<strong id="msjdepartamento-text"></strong>
							</div>
							
							<form class="form-inline">
								<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
								@include('departamento.forms.departamento')
							</form>
							<br>
							<table class="table">
								<thead><th>Nombre</th><th>Opciones</th></thead>
								<tbody id="datosdepartamento"></tbody>
							</table>

						</div>
					</div>
				</section>
			</div>
			<div class="col-lg-12">
				<h3><a class="linkInfo"><i class="fa fa-circle-o"></i> <b>Catálogos para Talleres</b></a></h3><hr>
				<section class="col-lg-6 connectedSortable">
					<div class="box box-solid bg-light-blue-gradient collapsed-box">
						<div class="box-header">
							<div class="pull-right box-tools">
								<button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Minimizar" style="margin-right: 5px;">
								<i class="fa fa-plus"></i></button>
							</div>
							<i class="fa fa-book"></i><h3 class="box-title">Contenidos</h3>
						</div>
						<div class="box-body">
							<div id="msjcontenido" class="alert alert-success alert-dismissible" role="alert" style="display:none">
								<strong id="msjcontenido-text"></strong>
							</div>
							
							<form class="form-inline">
								<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
								@include('contenido.forms.contenido')
							</form>
							<br>
							<table class="table">
								<thead><th>Nombre</th><th>Opciones</th></thead>
								<tbody id="datoscontenido"></tbody>
							</table>

						</div>
					</div>

					<div class="box box-solid bg-light-blue-gradient collapsed-box">
						<div class="box-header">
							<div class="pull-right box-tools">
								<button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Minimizar" style="margin-right: 5px;">
								<i class="fa fa-plus"></i></button>
							</div>
							<i class="fa fa-flag"></i><h3 class="box-title">Lugares</h3>
						</div>
						<div class="box-body">
							<div id="msjlugar" class="alert alert-success alert-dismissible" role="alert" style="display:none">
								<strong id="msjlugar-text"></strong>
							</div>
							
							<form class="form-inline">
								<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
								@include('lugar.forms.lugar')
							</form>
							<br>
							<table class="table">
								<thead><th>Nombre</th><th>Opciones</th></thead>
								<tbody id="datoslugar"></tbody>
							</table>

						</div>
					</div>

					<div class="box box-solid bg-light-blue-gradient collapsed-box">
						<div class="box-header">
							<div class="pull-right box-tools">
								<button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Minimizar" style="margin-right: 5px;">
								<i class="fa fa-plus"></i></button>
							</div>
							<i class="fa fa-globe"></i><h3 class="box-title">Internacionales</h3>
						</div>
						<div class="box-body">
							<div id="msjinternacional" class="alert alert-success alert-dismissible" role="alert" style="display:none">
								<strong id="msjinternacional-text"></strong>
							</div>
							
							<form class="form-inline">
								<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
								@include('internacional.forms.internacional')
							</form>
							<br>
							<table class="table">
								<thead><th>Nombre</th><th>Opciones</th></thead>
								<tbody id="datosinternacional"></tbody>
							</table>

						</div>
					</div>
				</section>
				<section class="col-lg-6 connectedSortable">
					<div class="box box-solid bg-light-blue-gradient collapsed-box">
						<div class="box-header">
							<div class="pull-right box-tools">
								<button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Minimizar" style="margin-right: 5px;">
								<i class="fa fa-plus"></i></button>
							</div>
							<i class="fa fa-eye"></i><h3 class="box-title">Audiencias</h3>
						</div>
						<div class="box-body">
							<div id="msjaudiencia" class="alert alert-success alert-dismissible" role="alert" style="display:none">
								<strong id="msjaudiencia-text"></strong>
							</div>
							
							<form class="form-inline">
								<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
								@include('audiencia.forms.audiencia')
							</form>
							<br>
							<table class="table">
								<thead><th>Nombre</th><th>Opciones</th></thead>
								<tbody id="datosaudiencia"></tbody>
							</table>

						</div>
					</div>

					<div class="box box-solid bg-light-blue-gradient collapsed-box">
						<div class="box-header">
							<div class="pull-right box-tools">
								<button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Minimizar" style="margin-right: 5px;">
								<i class="fa fa-plus"></i></button>
							</div>
							<i class="fa fa-thumb-tack"></i><h3 class="box-title">Actividades</h3>
						</div>
						<div class="box-body">
							<div id="msjactividad" class="alert alert-success alert-dismissible" role="alert" style="display:none">
								<strong id="msjactividad-text"></strong>
							</div>
							
							<form class="form-inline">
								<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
								@include('actividad.forms.actividad')
							</form>
							<br>
							<table class="table">
								<thead><th>Nombre</th><th>Opciones</th></thead>
								<tbody id="datosactividad"></tbody>
							</table>

						</div>
					</div>

					<div class="box box-solid bg-light-blue-gradient collapsed-box">
						<div class="box-header">
							<div class="pull-right box-tools">
								<button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Minimizar" style="margin-right: 5px;">
								<i class="fa fa-plus"></i></button>
							</div>
							<i class="fa fa-bookmark"></i><h3 class="box-title">Zonas receptoras</h3>
						</div>
						<div class="box-body">
							<div id="msjzonareceptora" class="alert alert-success alert-dismissible" role="alert" style="display:none">
								<strong id="msjzonareceptora-text"></strong>
							</div>
							
							<form class="form-inline">
								<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
								@include('zonareceptora.forms.zonareceptora')
							</form>
							<br>
							<table class="table">
								<thead><th>Nombre</th><th>Opciones</th></thead>
								<tbody id="datoszonareceptora"></tbody>
							</table>

						</div>
					</div>
				</section>
			</div>
		</div>
	</section>
@endsection

@section('scripts')
	{!!Html::script('js/catalogos1.js')!!}
@endsection