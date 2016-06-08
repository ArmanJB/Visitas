@extends('layouts.visitaAdmin')

@section('content')
	<div class="content-visita">
		<div id="divider"></div>
		{!!Form::open()!!}
			<div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
				<strong>Visita Agregada Correctamente.</strong>
			</div>
			<div id="msj-error" class="alert alert-danger alert-dismissible" role="alert" style="display:none">
				<strong id="msj"></strong>
			</div>

			<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
			@include('visita.forms.visita')
			{!!link_to('#', $title='Registrar', $attributes = ['id'=>'registro', 'class'=>'btn btn-primary'], $secure = null)!!}
		{!!Form::close()!!}
	</div>
@endsection

@section('scripts')
	{!!Html::script('js/visita.js')!!}
@endsection