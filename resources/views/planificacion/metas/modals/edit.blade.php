<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Actualizar Registro</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
				<input type="hidden" id="idn">
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon" style="color:black;">
						{!!Form::label('Oficial', null, ['id'=>'labeln'])!!}</span>
						{!!Form::select('selectn', ['placeholder'=>'Selecciona un oficial'], null, ['id'=>'selectn', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon" style="color:black;">{!!Form::label('Periodo', null, ['id'=>'labeln'])!!}</span>
						{!!Form::select('selectn', ['placeholder'=>'Selecciona un periodo'], null, ['id'=>'selectn', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon" style="color:black;">{!!Form::label('Meta', null, ['id'=>'labeln'])!!}
						</span>
						{!!Form::number('meta', null, ['id'=>'meta', 'class'=>'form-control', 'min'=>0, 'max'=>150, 'style'=>'width:20%;'])!!}
					</div>
				</div>
			</div>
				
			<div class="modal-footer">
				{!!link_to('#', $title='Actualizar', $attributes=['id'=>'actualizar', 'class'=>'btn btn-primary'], $secure=null)!!}
			</div>
		</div>
	</div>
</div>