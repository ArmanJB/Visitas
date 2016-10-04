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
									<h3 id="report-container-label"><a href="#report-container-label" data-toggle="collapse" data-target="#report-container">Meta mensual por área</a></h3>
									<div id="divider"></div>
								</div>
								<div class="col-md-12" id="report-container" class="collapse"></div>
							</div>

							<div class="col-md-12">
								<div class="col-md-2"></div>
								<div class="col-md-8">
									<h3 id="report-motivos-label"><a href="#report-motivos-label" data-toggle="collapse" data-target="#report-motivos">Motivos de visita</a></h3>
									<div id="divider"></div>
								</div>
								<div class="col-md-12" id="report-motivos" class="collapse"></div>
							</div>

							<div class="col-md-12">
								<div class="col-md-2"></div>
								<div class="col-md-8">
									<h3 id="report-oficiales-label"><a href="#report-oficiales-label" data-toggle="collapse" data-target="#report-oficiales">Cumplimiento de metas por oficial</a></h3>
									<div id="divider"></div>
								</div>
								<div class="col-md-12" id="report-oficiales" class="collapse"></div>
							</div>

							<div class="col-md-12">
								<div class="col-md-2"></div>
								<div class="col-md-8">
									<h3 id="report-viaticos-label"><a href="#report-viaticos-label" data-toggle="collapse" data-target="#report-viaticos">Viáticos por oficial</a></h3>
									<div id="divider"></div>
								</div>
								<div class="col-md-12" id="report-viaticos" class="collapse"></div>
							</div>

							<div class="col-md-12">
								<div class="col-md-2"></div>
								<div class="col-md-8">
									<h3 id="report-voluntarios-label"><a href="#report-voluntarios-label" data-toggle="collapse" data-target="#report-voluntarios">Voluntarios participantes</a></h3>
									<div id="divider"></div>
								</div>
								<div class="col-md-12" id="report-voluntarios" class="collapse"></div>
							</div>

							<div class="col-md-12">
								<div class="col-md-2"></div>
								<div class="col-md-8">
									<h3 id="report-articuladas-label"><a href="#report-articuladas-label" data-toggle="collapse" data-target="#report-articuladas">Visitas articuladas</a></h3>
									<div id="divider"></div>
								</div>
								<div class="col-md-12" id="report-articuladas" class="collapse"></div>
							</div>

							<!--Escuelas **-->
							<div class="col-md-12">
								<div class="col-md-2"></div>
								<div class="col-md-8">
									<h3 id="report-escuelas-label"><a href="#report-escuelas-label" data-toggle="collapse" data-target="#report-escuelas">Escuelas visitadas</a></h3>
									<div id="divider"></div>
								</div>
								<div class="col-md-12" id="report-escuelas" class="collapse"></div>
							</div>

							<div class="col-md-12">
								<div class="col-md-2"></div>
								<div class="col-md-8">
									<h3 id="report-escuelasP-label"><a href="#report-escuelasP-label" data-toggle="collapse" data-target="#report-escuelasP">Escuelas pendientes de visitar</a></h3>
									<div id="divider"></div>
								</div>
								<div class="col-md-12" id="report-escuelasP" class="collapse"></div>
							</div>

							<div class="col-md-12">
							<div class="col-md-2"></div>
								<div class="col-md-8"><div id="comparativoVisitas"></div><div id="divider"></div></div>
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