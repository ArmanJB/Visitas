
	<!--<div class="row row-chart">
		<div class="col-md-2 col-chart">
			<div id="divider"></div>
			<div id="divider"></div>
			<div id="divider"></div>
			<div class="list-group">
				<a href="#" id="Dep" class="list-group-item active" onclick="active(this);">Visitas por Departamento</a>
				<a href="#" id="Esc" class="list-group-item" onclick="active(this);">Visitas por Oficial (Escuelas)</a>
				<a href="#" id="Ofi" class="list-group-item" onclick="active(this);">Visitas por Oficial (Motivos)</a>
				@if (Auth::user()->id <= 5)
				<a href="#" id="Area" class="list-group-item" onclick="active(this);">Visitas por Área (Oficiales)</a>
				<a href="#" id="Mot" class="list-group-item" onclick="active(this);">Visitas por Área (Motivos)</a>
				@endif
			</div>
		</div>
		<div class="col-md-10 col-chart" id="chart-content">
			<div class="col-md-2"><p></p></div>
			<div class="col-md-8">
				<div class="input-group input-chart">
					<span class="input-group-addon" id="sizing-addon2">Desde: </span>
					<input id="fechaIni" type="date" class="form-control" aria-describedby="sizing-addon2">
					<span class="input-group-addon" id="sizing-addon2">Hasta: </span>
					<input id="fechaFin" type="date" class="form-control" aria-describedby="sizing-addon2">
					<span class="input-group-btn">
						<button id="actualizar" class="btn btn-default" type="button" disabled>Actualizar</button>
					</span>
				</div>
			</div>
		</div>
	</div>-->



@extends('layouts.admin')

@section('content')
	{!!Html::style('css/checkbox.css')!!}
	<section class="content">
		<div class="row">
		<div class="col-md-1"></div>
			<div class="col-md-12">

				<div class="box box-success">
					<div class="box-header with-border">
						<h3 class="box-title"><span class="fa fa-pie-chart"></span> Resumen de visitas</h3>

						<div class="box-tools">
							<div class="input-group input-group-sm" style="width: 100px;">
								<div class="input-group-btn" style="background-color:#00a65a;">
									<span class="input-group-addon" style="border:none;color:white;background-color:#00a65a;"><b>Desde</b></span>
								</div>
								{!!Form::date('fecha', \Carbon\Carbon::now(), ['id'=>'desde', 'class'=>'form-control ', 'dataDate'=>\Carbon\Carbon::now()->toDateString()])!!}
								<div class="input-group-btn" style="background-color:#00a65a;">
									<span class="input-group-addon" style="border:none;color:white;background-color:#00a65a;"><b>hasta</b></span>
								</div>
								{!!Form::date('fecha', \Carbon\Carbon::now(), ['id'=>'hasta', 'class'=>'form-control ', 'dataDate'=>\Carbon\Carbon::now()->toDateString()])!!}
								<div class="input-group-btn">
									<button type="submit" id="actualizar" class="btn btn-success" data-toggle="tooltip" title="Actualizar"><i class="fa fa-refresh"></i></button>
								</div>
							</div>
						</div>

					</div>
					<div class="box-header" id="chart_type" style="display:none;">
						<div class="row">
							<div class="col-md-1">
								<input type="checkbox" class="filled-in" id="areasChart" value=""/><label for="areasChart" style="color:black;" id="labelView">Áreas</label>	
							</div>
							<div class="col-md-1">
								<input type="checkbox" class="filled-in" id="depChart" value=""/><label for="depChart" style="color:black;" id="labelView">Departamentos</label>	
							</div>	
						</div>
					</div>
					<div class="box-body table-responsive no-padding">
						<div id="container"></div>	
					</div>
				</div>
			</div>
		</div>
	</section>

@endsection

@section('scripts')
	{!!Html::script('js/charts.js')!!}
	{!!Html::script('js/highcharts.js')!!}
	{!!Html::script('js/data.js')!!}
	{!!Html::script('js/drilldown.js')!!}
	{!!Html::script('js/materialize.min.js')!!}
@endsection