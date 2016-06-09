@extends('layouts.visitaAdmin')

@section('content')
	<div class="content-visita">
		<div id="divider"></div>
		<div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
			<strong>Visita Agregada Correctamente.</strong>
		</div>
		<div id="msj-error" class="alert alert-danger alert-dismissible" role="alert" style="display:none">
			<strong id="msj"></strong>
		</div>
		{!!Form::open()!!}
			<div class="form-group areas">
				{!!Form::label('Área: ')!!}
				{!!Form::select('areas', ['placeholder'=>'Selecciona'], null, ['id'=>'areas'])!!}
			</div>
		{!!Form::close()!!}
		<div class="row" style="display: none;">
			<div class="col-md-6">
				{!!Form::open()!!}
					<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
					@include('visita.forms.visita')
				{!!Form::close()!!}
			</div>
			<div class="col-md-6">
				@include('visita.forms.motivo')
				<div class="motivos-content">
					<h5><b>Motivos: </b></h5>
					<div id="motivosList" class="list-group">
						<!--<a href="#" class="list-group-item active">Hola</a>-->
					</div>
				</div>
			</div>
			<div class="col-md-12" style="text-align: center;">
				{!!link_to('#', $title='Registrar', $attributes = ['id'=>'registro', 'class'=>'btn btn-primary'], $secure = null)!!}
			</div>
		</div>
		
	</div>
@endsection

@section('scripts')
	{!!Html::script('js/visita.js')!!}
@endsection