<div class="form-group">
	{!!Form::label('Fecha: ')!!}
	{!!Form::date('fecha', \Carbon\Carbon::now(), ['id'=>'fecha', 'class'=>'form-control ', 'placeholder'=>'2016-06-08', 'dataDate'=>\Carbon\Carbon::now()->toDateString()])!!}
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
	{!!Form::label('Cantidad de aulas Visitadas: ')!!}
	{!!Form::number('aulas', null, ['id'=>'aulas', 'class'=>'form-control', 'min'=>1, 'max'=>15])!!}
</div>
<div class="form-group">
	{!!Form::label('Pendientes: ')!!}<p><input type="checkbox" class="filled-in" id="noPend" /><label for="noPend" id="noPend">Si</label></p>
	{!!Form::textArea('pendientes', null, 
	['id'=>'pendientes', 'class'=>'form-control', 'placeholder'=>'Pendientes...', 'style'=>'resize: vertical', 'disabled'=>'true'])!!}
</div>