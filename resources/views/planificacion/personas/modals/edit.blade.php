<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Actualizar Registro</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
				<input type="hidden" id="idn">
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user" style="color:black;"></i></span>
						{!!Form::text('nombres', null, ['id'=>'nombresn', 'class'=>'form-control', 'placeholder'=>'Nombres'])!!}
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user" style="color:black;"></i></span>
						{!!Form::text('apellidos', null, ['id'=>'apellidosn', 'class'=>'form-control', 'placeholder'=>'Apellidos'])!!}
					</div>
				</div>
				<div id="edit-oficial" class="hide">
					<div class="form-group">
						{!!Form::label('Fecha de nacimiento: ')!!}
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar" style="color:black;"></i></span>
							{!!Form::date('fecha', \Carbon\Carbon::now(), ['id'=>'fechaO', 'class'=>'form-control ', 'dataDate'=>\Carbon\Carbon::now()->toDateString()])!!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::label('Área: ')!!}
						{!!Form::select('areas', ['placeholder'=>'Selecciona'], null, ['id'=>'areasO', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
					</div>
				</div>
			</div>
			<div class="modal-footer">
				{!!link_to('#', $title='Actualizar', $attributes=['id'=>'actualizarn', 'class'=>'btn btn-primary'], $secure=null)!!}
			</div>
		</div>
	</div>
</div>