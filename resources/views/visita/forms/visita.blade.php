<div class="form-group">
	{!!Form::label('Fecha: ')!!}
	{!!Form::date('fecha', null, ['id'=>'fecha', 'class'=>'form-control ', 'placeholder'=>'2016-06-08'])!!}
</div>
<div class="form-group">
	{!!Form::label('Departamento: ')!!}
	{!!Form::select('departamentos', ['placeholder'=>'Selecciona'], null, ['id'=>'departamentos'])!!}
</div>
<div class="form-group">
	{!!Form::label('Escuela: ')!!}
	{!!Form::select('escuelas', ['placeholder'=>'Selecciona'], null, ['id'=>'escuelas'])!!}
</div>
<div class="form-group">
	{!!Form::label('Oficial: ')!!}
	{!!Form::select('oficiales', ['placeholder'=>'Selecciona'], null, ['id'=>'oficiales'])!!}
</div>
<div class="form-group">
	{!!Form::label('Pendientes: ')!!}
	{!!Form::textArea('pendientes', null, 
	['id'=>'pendientes', 'class'=>'form-control', 'placeholder'=>'Pendientes...', 'style'=>'resize: vertical'])!!}
</div>