<div class="modal fade" id="modalDet" tabindex="-1" role="dialog" aria-labelledby="title-det">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="title-det"></h4>
			</div>
			<div class="modal-body">
				<div id="list-motivos" class="list-group">
					
				</div>
			</div>
			<div class="modal-footer">
				{!!link_to('#', $title='Editar', $attributes=['id'=>'editarDet', 'class'=>'btn btn-primary', 'disabled'], $secure=null)!!}
			</div>
		</div>
	</div>
</div>