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
				{!!Form::text('nombren', null, ['id'=>'nombren', 'class'=>'form-control ', 'placeholder'=>'Ingresa el nombre'])!!}
			</div>
			<div class="modal-footer">
				{!!link_to('#', $title='Actualizar', $attributes=['id'=>'actualizarn', 'class'=>'btn btn-primary'], $secure=null)!!}
			</div>
		</div>
	</div>
</div>