<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>FZT | Iniciar sesión</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	
	{!!Html::style('css/bootstrap.min.css')!!}
	{!!Html::style('css/AdminLTE.min.css')!!}
	{!!Html::style('css/style.css')!!}
	{!!Html::style('css/login.css')!!}
</head>
<body>
	<div class="login-box">
		
		<div class="login-box-body">
			<div class="login-logo"><a href="#" style="color: #fff;text-shadow: 0.5px 0.4px #000">Control de Visitas <b>FZT</b></a></div>
			<div id="divider"></div>
			<p class="login-box-msg" style="color: #fff;text-shadow: 0.5px 0.4px #000">Ingresa tus datos para iniciar sesión</p>
			{!!Form::open(['route'=>'log.store', 'method'=>'POST'])!!}
				<div class="form-group has-feedback">
					{!!Form::email('email', null, ['class'=>'form-control', 'placeholder'=>'Correo electrónico'])!!}
					<span class="glyphicon glyphicon-envelope form-control-feedback" style="color: #fff"></span>
				</div>
				<div class="form-group has-feedback">
					{!!Form::password('password', ['class'=>'form-control', 'placeholder'=>'Contraseña'])!!}
					<span class="glyphicon glyphicon-lock form-control-feedback" style="color: #fff"></span>
				</div>
				<div class="row">
					<div class="col-xs-8"><p></p></div>
					<div class="col-xs-4">{!!Form::submit('Iniciar', ['class'=>'btn btn-primary btn-block btn-flat', 'id'=>'logbutton'])!!}</div>
				</div>
			{!!Form::close()!!}
			<div id="divider"></div>
			@include('alerts.errors')
			@include('alerts.request')
		</div>
	</div>
	
	{!!Html::script('js/jquery.min.js')!!}
	{!!Html::script('js/bootstrap.min.js')!!}
</body>
</html>
