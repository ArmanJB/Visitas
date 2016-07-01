@extends('layouts.visitaAdmin')

@section('content')
<div id="group-informe">
	<div id="divider"></div>
	<div class="row">
		<div class="col-lg-4"><p></p></div>
		<div class="col-lg-4">
			<div class="input-group">
				<div class="input-group-btn">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><b id="filtrar">Mes</b> <span class="caret"></span></button>
					<ul class="dropdown-menu">
						<li><a href="#" onclick="setMes(this);">Enero</a></li>
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
	</div>
		
</div>
<div id="toPrint">

</div>

@endsection

@section('scripts')
	{!!Html::script('js/informe.js')!!}
	{!!Html::script('js/jspdf.js')!!}
@endsection