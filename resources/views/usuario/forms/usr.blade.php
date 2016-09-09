<div class="row">
	<br>
	<section class="col-lg-6">
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-user" style="color:black;width:15px;"></i></span>
				{!!Form::text('nombre', null, ['id'=>'nombre', 'class'=>'form-control', 'placeholder'=>'Nombre del usuario'])!!}
			</div>
		</div>
	</section>
	<section class="col-lg-6">
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-envelope" style="color:black;width:15px;"></i></span>
				{!!Form::email('email', null, ['id'=>'email', 'class'=>'form-control', 'placeholder'=>'Correo del usuario'])!!}
			</div>
		</div>
	</section>
	<section class="col-lg-6">
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-lock" style="color:black;width:15px;"></i></span>
				{!!Form::password('password', ['id'=>'password', 'class'=>'form-control', 'placeholder'=>'Contraseña del usuario'])!!}
			</div>
		</div>
	</section>
	<section class="col-lg-6">
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-lock" style="color:black;width:15px;"></i></span>
				{!!Form::password('confirm', ['id'=>'confirm', 'class'=>'form-control', 'placeholder'=>'Confirmar contraseña'])!!}
			</div>
		</div>
	</section>

	<section class="col-lg-6 ">
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon" style="color:black;">{!!Form::label('Tipo de usuario: ', null, ['style'=>'width:100px;'])!!}</span>
				{!!Form::select('tipos', ['placeholder'=>'Selecciona'], null, ['id'=>'tipos', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
			</div>
		</div>
	</section>
	<section class="col-lg-6" id="oficial-group" style="display:none;">
		<div class="form-group">
			<div class="input-group ">
				<span class="input-group-addon" style="color:black;">{!!Form::label('Oficial: ', null, ['style'=>'width:100px;'])!!}</span>
				{!!Form::select('oficiales', ['placeholder'=>'Selecciona'], null, ['id'=>'oficiales', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
			</div>
		</div>
	</section>


	<div class="pull-right" style="padding-right:15px;"">
		{!!link_to('#', $title='Registrar', $attributes=['id'=>'registrar', 'class'=>'btn btn-primary btn-flat'], $secure = null)!!}
	</div>
</div>
<br>