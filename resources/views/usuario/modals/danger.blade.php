<div class="modal fade" id="modalRemove" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document" id="dangerRemoveDialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Está seguro de eliminar este registro?</h4>
			</div>
			
			<div class="modal-footer">
				<button value='' class="btn btn-default" OnClick="$('#modalRemove').modal('toggle');">No</button>
				<button value='' id="confirmRemove" class="btn btn-danger" OnClick="eliminar(this);">Si, Eliminar</button>
			</div>
		</div>
	</div>
</div>