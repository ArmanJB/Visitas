<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>Seguimiento</title>

	    {!!Html::style('css/bootstrap.min.css')!!}
	    {!!Html::style('css/style.css')!!}
	</head>
	<body>
		<div id="divider"></div>
		<div id="logbody">
			<h1 id="logh1">Inicia Sesión</h1>
			{!!Form::open(['route'=>'log.store', 'method'=>'POST'])!!}
				<div class="form-group">
					{!!Form::label('correo', 'Correo:', ['class'=>'loglabel'])!!}
					{!!Form::email('email', null, ['class'=>'form-control', 'placeholder'=>'Ingresa tu correo'])!!}
				</div>
				<div class="form-group">
					{!!Form::label('contrasena', 'Contraseña:', ['class'=>'loglabel'])!!}
					{!!Form::password('password', ['class'=>'form-control', 'placeholder'=>'Ingresa tu contraseña'])!!}
				</div>
				{!!Form::submit('Iniciar', ['class'=>'btn btn-primary', 'id'=>'logbutton'])!!}
			{!!Form::close()!!}
			<div id="divider"></div>

			@include('alerts.errors')
			@include('alerts.request')


			{!!Html::script('js/jquery.min.js')!!}
		    {!!Html::script('js/bootstrap.min.js')!!}
		</div>
	</body>
</html>