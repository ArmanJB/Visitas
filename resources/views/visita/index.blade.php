	<!--<div class="row">
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
	</div>-->
@extends('layouts.admin')

@section('content')
	@include('visita.modals.danger')
	@include('visita.modals.detail')
	<section class="content">
		<div class="row">
		<div class="col-md-1"></div>
			<div class="col-md-10">

				<div class="box box-success">
					<div class="box-header with-border">
						<h3 class="box-title"><span class="fa fa-suitcase"></span> Visitas</h3>

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
							<thead>
								<th>#</th>
								<th>Fecha</th>
								<th>Oficial</th>
								<th>Escuela</th>
								<th>Opciones</th>
							</thead>
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
	{!!Html::script('js/visitas.js')!!}
@endsection