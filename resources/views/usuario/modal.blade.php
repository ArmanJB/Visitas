<div class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Actualizar contraseña</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" id="id">
				<div class="form-group">
					{!!Form::label('Nombre:')!!}
					{!!Form::text('name', null, ['id'=>'name', 'class'=>'form-control', 'placeholder'=>'Ingresa el nombre del usuario', 'disabled'=>''])!!}
				</div>
				<div class="form-group">
					{!!Form::label('Correo:')!!}
					{!!Form::text('email', null, ['id'=>'email', 'class'=>'form-control', 'placeholder'=>'Ingresa el correo del usuario', 'disabled'=>''])!!}
				</div>
				<div class="form-group">
					{!!Form::label('Nueva cotraseña:')!!}
					{!!Form::password('password', ['id'=>'password', 'class'=>'form-control', 'placeholder'=>'Ingresa la contraseña del usuario'])!!}
				</div>
			</div>
			<div class="modal-footer">
				{!!link_to('#', $title='Actualizar', $attributes=['id'=>'actualizarUsuario', 'class'=>'btn btn-primary', 'disabled'=>''], $secure=null)!!}
			</div>
		</div>
	</div>
</div>