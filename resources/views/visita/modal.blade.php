<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Actualizar Visita</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-7">
						<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
						<input type="hidden" id="id">
						@include("visita.forms.visita")
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-6">
						<label for="Motivos">Motivos: </label>
						<div id="list-motivos2" class="list-group">
							
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				{!!link_to('#', $title='Actualizar', $attributes=['id'=>'actualizar', 'class'=>'btn btn-primary'], $secure=null)!!}
			</div>
		</div>
	</div>
</div>