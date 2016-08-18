@extends('layouts.admin')

@section('content')
	@include('planificacion.personas.modals.danger')
	@include('planificacion.personas.modals.edit')
	<section class="content">
		<div class="row">
			<section class="col-lg-7 connectedSortable">
				<div class="box box-primary collapsed-box">
					<div class="box-header">
						<div class="pull-right box-tools">
							<button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Minimizar" style="margin-right: 5px;">
							<i class="fa fa-plus"></i></button>
						</div>
						<h3 class="box-title"><span class="fa fa-edit"></span> Agregar Oficiales</h3>
					</div>
					<div class="box-body table-responsive no-padding">
						<form class="form-personas">
							<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
							@include('oficial.forms.oficial')
						</form>
						<br><br>
					</div>
				</div>
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Oficiales</h3>
						<!--<div class="box-tools">
							<div class="input-group input-group-sm" style="width: 150px;">
								<input type="text" name="table_search" class="form-control pull-right" placeholder="Search">
								<div class="input-group-btn">
									<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
								</div>
							</div>
						</div>-->
					</div>
					<div class="box-body table-responsive no-padding">
						<br>
						<div id="msjoficial" class="alert alert-success alert-dismissible" role="alert" style="display:none">
							<strong id="msjoficial-text"></strong>
						</div>
						<table class="table table-hover">
							<thead><th>#</th><th>Nombres</th><th>Apellidos</th><th>Área</th><th>Opciones</th></thead>
							<tbody id="datosoficial">

							</tbody>
						</table>
					</div>
				</div>
			</section>

			<section class="col-lg-5 connectedSortable">
				<div class="box box-primary collapsed-box">
					<div class="box-header">
						<div class="pull-right box-tools">
							<button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Minimizar" style="margin-right: 5px;">
							<i class="fa fa-plus"></i></button>
						</div>
						<h3 class="box-title"><span class="fa fa-edit"></span> Agregar Voluntarios</h3>
					</div>
					<div class="box-body table-responsive no-padding">
						<form class="form-personas">
							<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
							@include('voluntario.forms.voluntario')
						</form>
						<br><br>
					</div>
				</div>
				<div class="box">
					<div class="box-header"><h3 class="box-title">Voluntarios</h3></div>
					<div class="box-body table-responsive no-padding">
						<br>
						<div id="msjvoluntario" class="alert alert-success alert-dismissible" role="alert" style="display:none">
							<strong id="msjvoluntario-text"></strong>
						</div>
						<table class="table table-hover">
							<thead><th>#</th><th>Nombres</th><th>Apellidos</th><th>Opciones</th></thead>
							<tbody id="datosvoluntario">

							</tbody>
						</table>
					</div>
				</div>
			</section>
		</div>
	</section>
@endsection

@section('scripts')
	{!!Html::script('js/personas.js')!!}
	{!!Html::script('js/select2.full.min.js')!!}
@endsection