@include('alerts.errors')
@include('alerts.request')
{!!Form::open(['route'=>'log.store', 'method'=>'POST'])!!}
	<div class="form-group">
		{!!Form::label('correo', 'Correo:')!!}
		{!!Form::email('email', null, ['class'=>'form-control', 'placeholder'=>'Ingresa tu correo'])!!}
	</div>
	<div class="form-group">
		{!!Form::label('contrasena', 'Contraseña:')!!}
		{!!Form::password('password', ['class'=>'form-control', 'placeholder'=>'Ingresa tu contraseña'])!!}
	</div>
	{!!Form::submit('Iniciar', ['class'=>'btn btn-primary'])!!}
{!!Form::close()!!}