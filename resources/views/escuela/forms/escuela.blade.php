<div class="row">
	<br>
	<section class="col-lg-5 connectedSortable">
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-graduation-cap" style="color:black;"></i></span>
				{!!Form::text('nombre', null, ['id'=>'nombre', 'class'=>'form-control', 'placeholder'=>'Nombre'])!!}
			</div>
		</div>
	</section>
	<section class="col-lg-5 connectedSortable">
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon" style="color:black;">{!!Form::label('Departamento: ')!!}</span>
				{!!Form::select('departamentos', ['placeholder'=>'Selecciona'], null, ['id'=>'departamentos', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
			</div>
		</div>
	</section>
	<section class="col-lg-2 connectedSortable">
		{!!link_to('#', $title='Registrar', $attributes=['id'=>'registrar', 'class'=>'btn btn-primary btn-flat'], $secure = null)!!}
	</section>
</div>
	
