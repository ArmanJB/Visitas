<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Actualizar Registro</h4>
			</div>
			<div class="modal-body">
				<div id="msjuserA" class="alert alert-success alert-dismissible" role="alert" style="display:none">
					<strong id="msjuserA-text"></strong>
				</div>
				<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
				<input type="hidden" id="idn">
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user" style="color:black;width:15px;"></i></span>
						{!!Form::text('nombre', null, ['id'=>'nombreA', 'class'=>'form-control', 'placeholder'=>'Nombre del usuario'])!!}
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-envelope" style="color:black;width:15px;"></i></span>
						{!!Form::email('email', null, ['id'=>'emailA', 'class'=>'form-control', 'placeholder'=>'Correo del usuario'])!!}
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock" style="color:black;width:15px;"></i></span>
						{!!Form::password('password', ['id'=>'passwordA', 'class'=>'form-control', 'placeholder'=>'Contraseña del usuario'])!!}
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock" style="color:black;width:15px;"></i></span>
						{!!Form::password('confirm', ['id'=>'confirmA', 'class'=>'form-control', 'placeholder'=>'Confirmar contraseña'])!!}
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon" style="color:black;">{!!Form::label('Tipo de usuario: ', null, ['style'=>'width:100px;'])!!}</span>
						{!!Form::select('tiposA', ['placeholder'=>'Selecciona'], null, ['id'=>'tiposA', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
					</div>
				</div>
				<div class="form-group" id="oficial-groupA">
					<div class="input-group ">
						<span class="input-group-addon" style="color:black;">{!!Form::label('Oficial: ', null, ['style'=>'width:100px;'])!!}</span>
						{!!Form::select('oficialesA', ['placeholder'=>'Selecciona'], null, ['id'=>'oficialesA', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
					</div>
				</div>
			</div>
			<div class="modal-footer">
				{!!link_to('#', $title='Actualizar', $attributes=['id'=>'actualizar', 'class'=>'btn btn-primary'], $secure=null)!!}
			</div>
		</div>
	</div>
</div>