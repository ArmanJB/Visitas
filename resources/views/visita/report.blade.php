@extends('layouts.admin')

@section('content')
	{!!Html::style('css/checkbox.css')!!}
	<section class="content">
		<div class="row">
		<div class="col-md-1"></div>
			<div class="col-md-12">

				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><span class="glyphicon glyphicon-copy"></span> Informes de visitas</h3>

						<div class="box-tools">
							<div class="input-group input-group-sm" style="width: 100px;">
								<div class="input-group-btn" style="background-color:#3c8dbc;">
									<span class="input-group-addon" style="border:none;color:white;background-color:#3c8dbc;"><b>Desde</b></span>
								</div>
								{!!Form::date('fecha', \Carbon\Carbon::now(), ['id'=>'desde', 'class'=>'form-control ', 'dataDate'=>\Carbon\Carbon::now()->toDateString()])!!}
								<div class="input-group-btn" style="background-color:#3c8dbc;">
									<span class="input-group-addon" style="border:none;color:white;background-color:#3c8dbc;"><b>hasta</b></span>
								</div>
								{!!Form::date('fecha', \Carbon\Carbon::now(), ['id'=>'hasta', 'class'=>'form-control ', 'dataDate'=>\Carbon\Carbon::now()->toDateString()])!!}
								<div class="input-group-btn">
									<button type="submit" id="actualizar" class="btn btn-primary" data-toggle="tooltip" title="Actualizar"><i class="fa fa-refresh"></i></button>
								</div>
							</div>
						</div>
					</div>
					<div class="box-header">
						<div class="row" id="areas">
						</div>
					</div>
					
					<div class="box-body table-responsive no-padding">
						<div id="report-container">
							<div class="col-md-12">
								<div class="col-md-6">
									<table class="table table-hover informe">
										<thead><th colspan="2">Rango</th><th>Área</th><th>Cantidad</th><th>% alcanzado</th></thead>
										<tbody id="consolidado"></tbody>
									</table>
								</div>
							</div>
									
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

@endsection

@section('scripts')
	{!!Html::script('js/report.js')!!}
	{!!Html::script('js/highcharts.js')!!}
	{!!Html::script('js/exporting.js')!!}
	{!!Html::script('js/materialize.min.js')!!}
@endsection