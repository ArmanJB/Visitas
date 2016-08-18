<div class="form-group">
	<div class="input-group">
		<span class="input-group-addon" style="color:black;">{!!Form::label('Periodo: ', null, ['style'=>'width:80px;'])!!}</span>
		{!!Form::select('periodo', ['placeholder'=>'Selecciona'], null, ['id'=>'periodo', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
	</div>
</div>
<div class="form-group">
	<div class="input-group">
		<span class="input-group-addon" style="color:black;">{!!Form::label('Oficial: ', null, ['style'=>'width:80px;'])!!}</span>
		{!!Form::select('oficial', ['placeholder'=>'Selecciona'], null, ['id'=>'oficial', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
	</div>
</div>
<div class="row">
	<section class="col-lg-7">
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon" style="color:black;">{!!Form::label('Meta: ', null, ['style'=>'width:80px;'])!!}</span>
				{!!Form::number('meta', null, ['id'=>'meta', 'class'=>'form-control', 'min'=>0, 'max'=>150])!!}
			</div>
		</div>
	</section>
	<section class="col-lg-5">
		<div class="pull-right">
			{!!link_to('#', $title='Crear', $attributes=['id'=>'registrarM', 'class'=>'btn btn-primary btn-flat'], $secure = null)!!}
		</div>
	</section>
</div>
<br>
