<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document" id="modal-edit-visita">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Actualizar Visita</h4>
			</div>
			<div class="modal-body">
				<div id="msj-fail" class="alert alert-danger alert-dismissible" role="alert" style="display:none">
					<strong id="msgUpdDanger"> </strong>
				</div>
				<div class="row">
					<div class="col-md-6">
						<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
						<input type="hidden" id="id">
						@include("visita.forms.visita")
					</div>
					<div class="col-md-6">
						<div class="form-group">
							{!!Form::label('Nuevo Motivo: ')!!}
							<br>
							{!!Form::select('newMotivo', ['placeholder'=>'Selecciona'], null, ['id'=>'newMotivo'])!!}
							{!!link_to('#', $title='Agregar', $attributes = ['id'=>'addMotivo', 'class'=>'btn btn-default'], $secure = null)!!}
						</div>
						<label >Motivos: </label>
						<div id="list-motivos2" class="list-group">
							
						</div>
						<label >Nuevos motivos: </label>
						<div id="list-newMotivos" class="list-group">
							
						</div>
					</div>
				</div>
				
				<div class="row">
					
				</div>
			</div>
			<div class="modal-footer">
				{!!link_to('#', $title='Actualizar', $attributes=['id'=>'actualizar', 'class'=>'btn btn-primary'], $secure=null)!!}
			</div>
		</div>
	</div>
</div>