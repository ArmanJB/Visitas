<div class="form-group">
	{!!Form::label('Nombres: ')!!}
	{!!Form::text('nombres', null, ['id'=>'nombres', 'class'=>'form-control', 'placeholder'=>'Ingresa el nombre'])!!}
</div>
<div class="form-group">
	{!!Form::label('Apellidos: ')!!}
	{!!Form::text('apellidos', null, ['id'=>'apellidos', 'class'=>'form-control', 'placeholder'=>'Ingresa el apellido'])!!}
</div>
<div class="form-group">
	{!!Form::label('Area: ')!!}
	{!!Form::select('areas', ['placeholder'=>'Selecciona'], null, ['id'=>'areas'])!!}
</div>