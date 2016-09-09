<div class="form-group">
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-user" style="color:black;"></i></span>
		{!!Form::text('nombres', null, ['id'=>'nombresoficial', 'class'=>'form-control', 'placeholder'=>'Nombres'])!!}
	</div>
</div>
<div class="form-group">
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-user" style="color:black;"></i></span>
		{!!Form::text('apellidos', null, ['id'=>'apellidosoficial', 'class'=>'form-control', 'placeholder'=>'Apellidos'])!!}
	</div>
</div>
<div class="form-group">
	{!!Form::label('Fecha de nacimiento: ')!!}
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-calendar" style="color:black;"></i></span>
		{!!Form::date('fecha', \Carbon\Carbon::now(), ['id'=>'fecha', 'class'=>'form-control ', 'dataDate'=>\Carbon\Carbon::now()->toDateString()])!!}
	</div>
</div>
<div class="form-group">
	{!!Form::label('Área: ')!!}
	{!!Form::select('areas', ['placeholder'=>'Selecciona'], null, ['id'=>'areas', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
</div>
<div class="pull-right">
	{!!link_to('#', $title='Registrar', $attributes = ['id'=>'registrarO', 'class'=>'btn btn-primary btn-flat', 'data'=>'oficial', 'onclick'=>'registrar(this)' ], $secure = null)!!}
</div>