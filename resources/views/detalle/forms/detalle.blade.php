<div class="form-group">
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-thumb-tack" style="color:black;"></i></span>
		{!!Form::text('nombre', null, ['id'=>'nombreD', 'class'=>'form-control', 'placeholder'=>'Nombre del detalle'])!!}
	</div>
</div>
<div class="form-group">
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-bookmark" style="color:black;"></i> </span>
		{!!Form::select('motivos', ['placeholder'=>'Selecciona un Motivo'], null, ['id'=>'motivos', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
	</div>
</div>
<div class="pull-right">
	{!!link_to('#', $title='Crear', $attributes=['id'=>'registrarD', 'class'=>'btn btn-primary btn-flat'], $secure = null)!!}
</div>



	
