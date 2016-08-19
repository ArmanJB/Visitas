@extends('layouts.admin')

@section('content')
	{!!Html::style('css/checkbox.css')!!}
	{!!Html::style('css/bootstrap-timepicker.min.css')!!}
	
	<section class="content">
		<div class="row">
		<div class="col-md-1"></div>
			<div class="col-md-10">
				<div class="box box-success">
					<div class="box-header with-border">
						<h2 class="box-title"><i class="fa fa-pencil-square-o"></i> Agregar Taller</h2>
						<div class="pull-right">
							<input type="checkbox" class="filled-in" id="viewAll" value=""/><label for="viewAll" style="color:black;"id="labelView">Ver todo</label>
						</div>
					</div>
					<div class="box-body" id="box-parent">
						<div id="msjcreate" class="alert alert-danger alert-dismissible" role="alert" style="display:none">
							<strong id="msjcreate-text"></strong>
						</div>
						<br>
						@include('taller.forms.taller')
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
	{!!Html::script('js/taller.js')!!}
@endsection
