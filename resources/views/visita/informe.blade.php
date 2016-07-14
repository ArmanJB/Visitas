@extends('layouts.visitaAdmin')

@section('content')
{!!Html::style('css/checkbox.css')!!}
<div id="group-informe">
	<div id="divider"></div>
	<div class="row">
		<div class="col-lg-4"><p></p></div>
		<div class="col-lg-4">
			<div class="input-group">
				<div class="input-group-btn">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><b id="filtrarAnio">2016</b> <span class="caret"></span></button>
					<ul class="dropdown-menu">
						@for($i = 2016; $i <= 2030; $i++)
						<li><a href="#" onclick="setAnio(this);">{{$i}}</a></li>
						@endfor
					</ul>
				</div>
				
				<div class="input-group-btn">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><b id="filtrar">Mes</b> <span class="caret"></span></button>
					<ul class="dropdown-menu">
						<li><a href="#" onclick="setMes(this);">Febrero</a></li>
						<li><a href="#" onclick="setMes(this);">Marzo</a></li>
						<li><a href="#" onclick="setMes(this);">Abril</a></li>
						<li><a href="#" onclick="setMes(this);">Mayo</a></li>
						<li><a href="#" onclick="setMes(this);">Junio</a></li>
						<li><a href="#" onclick="setMes(this);">Julio</a></li>
						<li><a href="#" onclick="setMes(this);">Agosto</a></li>
						<li><a href="#" onclick="setMes(this);">Septiembre</a></li>
						<li><a href="#" onclick="setMes(this);">Octubre</a></li>
						<li><a href="#" onclick="setMes(this);">Noviembre</a></li>
					</ul>
				</div>
				<input type="text" class="form-control" id="mes" disabled>

				<span class="input-group-btn">
					<button type="button" class="btn btn-primary" id="print">Imprimir</button>
				</span>
			</div>
		</div>
		<div class="col-lg-12" style="text-align: center;"">
			<div id="divider"></div>
			<div class="panel panel-default" id="panelContainer">
			  <div class="panel-heading">
			    <h3 class="panel-title">Áreas</h3>
			  </div>
			  <div class="panel-body" id="areasPanel">
			    
			  </div>
			</div>
		</div>
	</div>
	<div id="divider"></div>
</div>


<div id="toPrint">
	<!--<table class="table informe">
		<h4>Área Educativa</h4>
		<thead>
			<th>Mes</th>
			<th>Meta Planeada</th>
			<th>Meta Ejecutada</th>
			<th>% Alcanzado</th>
		</thead>
		<tbody id="datos"></tbody>
	</table>-->
</div>
<eiv id="divider"></eiv>
@endsection

@section('scripts')
	{!!Html::script('js/informe.js')!!}
	{!!Html::script('js/jspdf.js')!!}
@endsection