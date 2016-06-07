<div class="form-group">
	{!!Form::label('Nombre: ')!!}
	{!!Form::text('nombre', null, ['id'=>'nombre', 'class'=>'form-control', 'placeholder'=>'Ingresa el nombre'])!!}
</div>
<div class="form-group">
	{!!Form::label('Departamento: ')!!}
	{!!Form::select('departamentos', ['placeholder'=>'Selecciona'], null, ['id'=>'departamentos'])!!}
</div>