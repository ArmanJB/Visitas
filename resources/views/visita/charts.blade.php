@extends('layouts.visitaAdmin')

@section('content')
	<div class="row row-chart">
		<div class="col-md-2 col-chart">
			<div id="divider"></div>
			<div id="divider"></div>
			<div id="divider"></div>
			<div class="list-group">
				<a href="#" id="Dep" class="list-group-item active" onclick="active(this);">Visitas por Departamento</a>
				<a href="#" id="Area" class="list-group-item" onclick="active(this);">Visitas por Área</a>
				<a href="#" id="Mot" class="list-group-item" onclick="active(this);">Visitas por Motivo</a>
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
			<div id="container"></div>	
		</div>
	</div>

@endsection

@section('scripts')
	{!!Html::script('js/charts.js')!!}
	{!!Html::script('js/highcharts.js')!!}
	{!!Html::script('js/data.js')!!}
	{!!Html::script('js/drilldown.js')!!}
@endsection