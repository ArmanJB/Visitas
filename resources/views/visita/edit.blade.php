@extends('layouts.admin')

@section('content')
	{!!Html::style('css/checkbox.css')!!}
	{!!Html::style('css/bootstrap-timepicker.min.css')!!}
	
	<section class="content">
		<div class="row">
		<div class="col-md-1"></div>
			<div class="col-md-10">
				<div class="box box-info">
					<div class="box-header with-border">
						<h2 class="box-title"><i class="fa fa-pencil-square-o"></i> Editar Visita</h2>
						<div class="pull-right" id="view_group" >
							<a href="/visita" class="btn btn-primary btn-flat">Cancelar</a>
						</div>
					</div>
					<div class="box-body" id="box-parent">
						<div id="msjcreate" class="alert alert-danger alert-dismissible" role="alert" style="display:none">
							<strong id="msjcreate-text"></strong>
						</div>
						<input type="hidden" id="idv" value="{{$visita->id}}">
						<br>
						@include('visita.forms.visita')
					</div>
				</div>
			</div>
		</div>
	</section>

@endsection

@section('scripts')
	{!!Html::script('js/materialize.min.js')!!}
	{!!Html::script('js/bootstrap-timepicker.min.js')!!}
	{!!Html::script('js/select2.full.min.js')!!}
	{!!Html::script('js/visitaE.js')!!}
@endsection