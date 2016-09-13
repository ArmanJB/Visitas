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
				<div class="row">
					<section class="col-lg-6">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon" style="color:black;">{!!Form::label('Periodo: ', null, ['style'=>'width:50px;'])!!}</span>
								{!!Form::select('periodo', ['placeholder'=>'Selecciona'], null, ['id'=>'periodoA', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
							</div>
						</div>
					</section>
					<section class="col-lg-6">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon" style="color:black;">{!!Form::label('Oficial: ', null, ['style'=>'width:50px;'])!!}</span>
								{!!Form::select('oficial', ['placeholder'=>'Selecciona'], null, ['id'=>'oficialA', 'class'=>'form-control select2', 'style'=>'width:100%;'])!!}
							</div>
						</div>
					</section>	
					<section class="col-lg-6">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon" style="color:black;">{!!Form::label('Meta: ', null, ['style'=>'width:50px;'])!!}</span>
								{!!Form::number('meta', null, ['id'=>'metaA', 'class'=>'form-control', 'min'=>0, 'max'=>150])!!}
							</div>
						</div>
					</section>
				</div>
			</div>
				
			<div class="modal-footer">
				{!!link_to('#', $title='Actualizar', $attributes=['id'=>'actualizar', 'class'=>'btn btn-primary'], $secure=null)!!}
			</div>
		</div>
	</div>
</div>