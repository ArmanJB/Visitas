@extends('layouts.admin')

@section('content')
	@include('usuario.modals.danger')
	@include('usuario.modals.edit')

	<section class="content">
		<div class="row">
			<section class="col-lg-1 connectedSortable"></section>
			<section class="col-lg-10 connectedSortable">
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title"><span class="fa fa-edit"></span> Agregar Usuarios</h3>
					</div>
					<div class="box-body table-responsive no-padding">
						<form class="form-personas">
							<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
							@include('usuario.forms.usr')
						</form>
					</div>
				</div>
				<div class="box">
					<div class="box-header">
						<h3 class="box-title"><span class="fa fa-users"></span> Usuarios</h3>

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
						<div id="msjuser" class="alert alert-success alert-dismissible" role="alert" style="display:none">
							<strong id="msjuser-text"></strong>
						</div>
						<table class="table table-hover">
							<thead><th>#</th><th>Nombre</th><th>Correo</th><th>Tipo</th><th>Oficial</th><th>Opciones</th></thead>
							<tbody id="datos">

							</tbody>
						</table>
					</div>
				</div>
			</section>
		</div>
	</section>
@endsection

@section('scripts')
	{!!Html::script('js/usuarios.js')!!}
	{!!Html::script('js/select2.full.min.js')!!}
@endsection