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
							<div class="input-group input-group-sm" style="width: 300px;">
								<div class="input-group">
									<div class="input-group-btn">
										<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><b>Periodo</b> <span class="fa fa-caret-down"></span></button>
										<ul class="dropdown-menu" id="periodos"> </ul>
									</div>
									<input type="text" class="form-control" id="periodos-text" placeholder="Seleccione un periodo" data="0" disabled>
									<div class="input-group-btn">
									<button type="submit" id="actualizar" class="btn btn-primary" data-toggle="tooltip" title="Actualizar"><i class="fa fa-refresh"></i></button>
								</div>
								</div>								
								
							</div>
						</div>
					</div>
					<div class="box-header">
						<div class="panel panel-success">
					      <div class="panel-heading">Áreas</div>
					      <div class="panel-body" id="areas" style="text-align:center;"></div>
					    </div>
						
					</div>
					
					<div class="box-body table-responsive no-padding">
						<div >
							<div class="col-md-12">
								<div class="col-md-2"></div>
								<div class="col-md-8">
									<h3>Meta mensual general</h3>
									<table class="table table-hover informe">
										<thead><th>Periodo</th><th>Meta planeada</th><th>Meta ejecutada</th><th>% alcanzado</th></thead>
										<tbody id="consolidado"></tbody>
									</table>
									<div id="divider"></div>
								</div>
							</div>

							<!-- Agregadas automaticamente -->
							<div class="col-md-12">
								<div class="col-md-2"></div>
								<div class="col-md-8">
									<h3>Meta mensual por área</h3>
									<div id="divider"></div>
								</div>
								<div class="col-md-12" id="report-container"></div>
							</div>

							<div class="col-md-12">
								<div class="col-md-2"></div>
								<div class="col-md-8">
									<h3>Motivos de visita</h3>
									<div id="divider"></div>
								</div>
								<div class="col-md-12" id="report-motivos"></div>
							</div>

							<div class="col-md-12">
								<div class="col-md-2"></div>
								<div class="col-md-8">
									<h3>Cumplimiento de metas por oficial</h3>
									<div id="divider"></div>
								</div>
								<div class="col-md-12" id="report-oficiales"></div>
							</div>

							<div class="col-md-12">
								<div class="col-md-2"></div>
								<div class="col-md-8">
									<h3>Escuelas visitadas</h3>
									<div id="divider"></div>
								</div>
								<div class="col-md-12" id="report-escuelas"></div>
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