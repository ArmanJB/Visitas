@extends('layouts.admin')

@section('content')
	@include('planificacion.escuelas.modals.danger')
	@include('planificacion.escuelas.modals.edit')
	<section class="content">
		<div class="row">
			<section class="col-lg-1 connectedSortable"></section>
			<section class="col-lg-10 connectedSortable">
				<div class="box box-primary collapsed-box">
					<div class="box-header">
						<div class="pull-right box-tools">
							<button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Minimizar" style="margin-right: 5px;">
							<i class="fa fa-plus"></i></button>
						</div>
						<h3 class="box-title"><span class="fa fa-edit"></span> Agregar Escuelas</h3>
					</div>
					<div class="box-body table-responsive no-padding">
						<form class="form-personas">
							<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
							@include('escuela.forms.escuela')
						</form>
					</div>
				</div>
				<div class="box">
					<div class="box-header">
						<h3 class="box-title"><span class="fa fa-graduation-cap"></span> Escuelas</h3>

						<div class="box-tools">
							<div class="input-group input-group-sm" style="width: 200px;">
								<input type="text" name="table_search" id="toSearch" class="form-control pull-right" placeholder="Search">
								<div class="input-group-btn">
									<button type="submit" id="search" class="btn btn-default"><i class="fa fa-search"></i></button>
								</div>
							</div>
						</div>

					</div>
					<div class="box-body table-responsive no-padding">
						<br>
						<div id="msjescuela" class="alert alert-success alert-dismissible" role="alert" style="display:none">
							<strong id="msjescuela-text"></strong>
						</div>
						<table class="table table-hover">
							<thead><th>#</th><th>Nombre</th><th>Departamento</th><th>Opciones</th></thead>
							<tbody id="datosescuela">

							</tbody>
						</table>
					</div>
				</div>
			</section>
		</div>
	</section>
@endsection

@section('scripts')
	{!!Html::script('js/escuelasF.js')!!}
	{!!Html::script('js/select2.full.min.js')!!}
@endsection