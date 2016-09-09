<div class="form-group">
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-thumb-tack" style="color:black;"></i></span>
		{!!Form::text('nombre', null, ['id'=>'nombreM', 'class'=>'form-control', 'placeholder'=>'Nombre del motivo'])!!}
	</div>
</div>
<div class="form-group">
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-sitemap" style="color:black;"></i> </span>
		{!!Form::select('areas', ['placeholder'=>'Selecciona un Área'], null, ['id'=>'areas', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
	</div>
</div>
<div class="pull-right">
	{!!link_to('#', $title='Crear', $attributes=['id'=>'registrarM', 'class'=>'btn btn-primary btn-flat'], $secure = null)!!}
</div>



	
