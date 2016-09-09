<div class="form-group">
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-user" style="color:black;"></i></span>
		{!!Form::text('nombres', null, ['id'=>'nombresvoluntario', 'class'=>'form-control', 'placeholder'=>'Nombres'])!!}
	</div>
</div>
<div class="form-group">
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-user" style="color:black;"></i></span>
		{!!Form::text('apellidos', null, ['id'=>'apellidosvoluntario', 'class'=>'form-control', 'placeholder'=>'Apellidos'])!!}
	</div>
</div>
<div class="pull-right">
	{!!link_to('#', $title='Registrar', $attributes = ['id'=>'registrarV', 'class'=>'btn btn-primary btn-flat', 'data'=>'voluntario', 'onclick'=>'registrar(this)' ], $secure = null)!!}
</div>

