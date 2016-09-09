@extends('layouts.admin')

@section('content')
	@include('taller.modals.danger')
	@include('taller.modals.detail')
	<section class="content">
		<div class="row">
		<div class="col-md-1"></div>
			<div class="col-md-10">

				<div class="box box-success">
					<div class="box-header with-border">
						<h3 class="box-title"><a href="#" style="color:black;" id="listing"><span class="fa fa-suitcase"></span> Talleres</a></h3>

						<div class="box-tools">
							<div class="input-group input-group-sm" style="width: 100px;">
								<div class="input-group-btn">
									<span class="input-group-addon" style="border:none;color:black;">Desde</span>
								</div>
								{!!Form::date('fecha', \Carbon\Carbon::now(), ['id'=>'desde', 'class'=>'form-control ', 'dataDate'=>\Carbon\Carbon::now()->toDateString()])!!}
								<div class="input-group-btn">
									<span class="input-group-addon" style="border:none;color:black;">hasta</span>
								</div>
								{!!Form::date('fecha', \Carbon\Carbon::now(), ['id'=>'hasta', 'class'=>'form-control ', 'dataDate'=>\Carbon\Carbon::now()->toDateString()])!!}
								<div class="input-group-btn">
									<button type="submit" id="search" class="btn btn-success"><i class="fa fa-search"></i></button>
								</div>
							</div>
						</div>

					</div>
					<div class="box-body table-responsive no-padding">
						<br>
						<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
						<div id="msjindex" class="alert alert-success alert-dismissible" role="alert" style="display:none">
							<strong id="msjindex-text"></strong>
						</div>
						<table class="table table-hover">
							<thead><th>#</th><th>Fecha</th><th>Actividad</th><th>Oficiales a cargo</th><th>Opciones</th></thead>
							<tbody id="datos">

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>

@endsection

@section('scripts')
	{!!Html::script('js/talleres.js')!!}
@endsection