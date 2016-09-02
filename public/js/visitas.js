var list = null;
$(function(){
	setTimeout(function(){ listar(); }, 1500);
});

function listar(){
	if ($('#user_type').attr('value')=='1') {
		$.get('/visitas', function(res){
			list = res;
			$('#datos').empty();
			$(res).each(function(key, value){
				$('#datos').append('<tr><td>'+(key+1)+'</td><td>'+value.fecha+'</td><td>'+value.oficial+'</td><td>'+value.escuela+'</td><td>'+
					'<button value='+value.id+' OnClick="detalle(this);" class="btn btn-default" data-toggle="modal" data-target="#modalDetail">Detalles</button> '+
					'<a value='+value.id+' href="/visita/'+value.id+'/edit" class="btn btn-primary">Editar</a> '+
					'<button value='+value.id+' OnClick="danger(this);" class="btn btn-danger" data-toggle="modal" data-target="#modalRemove">Eliminar</button></td></tr>');
			})
		});
	}else if($('#user_type').attr('value')=='2'){
		$.get('/visitas/c/'+$('#user_area').attr('value'), function(res){
			list = res;
			$('#datos').empty();
			$(res).each(function(key, value){
				$('#datos').append('<tr><td>'+(key+1)+'</td><td>'+value.fecha+'</td><td>'+value.oficial+'</td><td>'+value.escuela+'</td><td>'+
					'<button value='+value.id+' OnClick="detalle(this);" class="btn btn-default" data-toggle="modal" data-target="#modalDetail">Detalles</button></td></tr>');
			})
		});
	}else if($('#user_type').attr('value')=='3'){
		$.get('/visitas/o/'+$('#user_oficial').attr('value'), function(res){
			list = res;
			$('#datos').empty();
			$(res).each(function(key, value){
				$('#datos').append('<tr><td>'+(key+1)+'</td><td>'+value.fecha+'</td><td>'+value.oficial+'</td><td>'+value.escuela+'</td><td>'+
					'<button value='+value.id+' OnClick="detalle(this);" class="btn btn-default" data-toggle="modal" data-target="#modalDetail">Detalles</button</td>></tr>');
			})
		});
	}
}

function detalle(btn){
	$.get('visita/detail/'+btn.value, function(res){
		$('#fecha').html(res.visita[0].fecha);
		$('#escuela').html(res.visita[0].escuela+' ('+res.visita[0].dep+')');
		$('#oficial').html(res.visita[0].oficial);
		$('#aulas').html(res.visita[0].aulas);
		$('#viaticos').html(res.visita[0].viaticos);
		$('#pendientes').html('');
		$('#pendientes').html(res.visita[0].pendientes);
		$('#observaciones').html('');
		$('#observaciones').html(res.visita[0].observaciones);
		//
		$('#motivos').empty();
		$(res.motivos).each(function(key, value){
			$('#motivos').append('<li style="list-style-type: circle;">'+value.motivo+' <i class="fa fa-long-arrow-right"></i> <i class="fa fa-clock-o"></i> '+value.tiempo+'</li>');
		});
		$('#voluntarios').empty();
		$(res.voluntarios).each(function(key, value){
			$('#voluntarios').append('<li style="list-style-type: circle;">'+value.voluntario+' <i class="fa fa-long-arrow-right"></i> <i class="fa fa-clock-o"></i> '+value.tiempo+'</li>');
		});
	});
}

function danger(btn){
	$('#confirmRemove').val(btn.value);
}

function eliminar(btn){
	$.ajax({
		url: '/visita/'+btn.value,
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		type: 'DELETE',
		dataType: 'json',
		success: function(){
			listar();
			$('#modalRemove').modal('toggle');
			$('#msjindex').removeClass('alert-danger');
			$('#msjindex').addClass('alert-success');
			$('#msjindex'+'-text').html('Registros actualizados exitosamente!');
			$('#msjindex').fadeIn();
			window.setTimeout(function(){$('#msjindex').fadeOut();}, 2000);
		}
	});
}

$('#search').on('click', function(){
	if ($('#desde').val() != '' && $('#hasta').val() != '') {
		$('#datos').empty();
		if ($('#user_type').attr('value')=='1') {
			$(list).each(function(key, value){
				if (value.fecha >= $('#desde').val() && value.fecha <= $('#hasta').val() ) {
					$('#datos').append('<tr><td>'+(key+1)+'</td><td>'+value.fecha+'</td><td>'+value.oficial+'</td><td>'+value.escuela+'</td><td>'+
						'<button value='+value.id+' OnClick="detalle(this);" class="btn btn-default" data-toggle="modal" data-target="#modalDetail">Detalles</button> '+
						'<a value='+value.id+' href="/visita/'+value.id+'/edit" class="btn btn-primary">Editar</a> '+
						'<button value='+value.id+' OnClick="danger(this);" class="btn btn-danger" data-toggle="modal" data-target="#modalRemove">Eliminar</button></td></tr>');
				}
			})
		}else{
			$(list).each(function(key, value){
				if (value.fecha >= $('#desde').val() && value.fecha <= $('#hasta').val() ) {
					$('#datos').append('<tr><td>'+(key+1)+'</td><td>'+value.fecha+'</td><td>'+value.oficial+'</td><td>'+value.escuela+'</td><td>'+
					'<button value='+value.id+' OnClick="detalle(this);" class="btn btn-default" data-toggle="modal" data-target="#modalDetail">Detalles</button></td></tr>');
				}
			})
		}
	}else{
		listar();
	}
});
