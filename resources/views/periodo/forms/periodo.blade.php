<div class="row">
	<section class="col-lg-6">
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon" style="color:black;">{!!Form::label('Año: ')!!}</span>
				{!!Form::select('anio', ['placeholder'=>'Selecciona'], null, ['id'=>'anio', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
			</div>
		</div>
	</section>
	<section class="col-lg-6">
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon" style="color:black;">{!!Form::label('Mes: ')!!}</span>
				{!!Form::select('mes', ['placeholder'=>'Selecciona'], null, ['id'=>'mes', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
			</div>
		</div>
	</section>
	<section class="col-lg-12">
		<div class="pull-right">
			{!!link_to('#', $title='Crear', $attributes=['id'=>'registrarP', 'class'=>'btn btn-primary btn-flat'], $secure = null)!!}
		</div>
	</section>
</div>
<br>


	
