<div id="msj-error" class="alert alert-danger alert-dismissible" role="alert" style="display:none">
	<strong id="metaMsj"></strong>
</div>
<div class="form-group">
	{!!Form::label('Nombres: ')!!}
	{!!Form::text('nombres', null, ['id'=>'nombres', 'class'=>'form-control', 'placeholder'=>'Ingresa el nombre'])!!}
</div>
<div class="form-group">
	{!!Form::label('Apellidos: ')!!}
	{!!Form::text('apellidos', null, ['id'=>'apellidos', 'class'=>'form-control', 'placeholder'=>'Ingresa el apellido'])!!}
</div>
<div class="form-group">
	{!!Form::label('Meta mensual: ')!!}
	{!!Form::text('meta', null, ['id'=>'meta', 'class'=>'form-control', 'placeholder'=>'Ingresa la meta'])!!}
</div>
<div class="form-group">
	{!!Form::label('Area: ')!!}
	{!!Form::select('areas', ['placeholder'=>'Selecciona'], null, ['id'=>'areas'])!!}
</div>