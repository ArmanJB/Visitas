var list = null;
$(function(){
	setTimeout(function(){ listar(); }, 1500);
});

$('#listing').on('click', function(){listar();});

function listar(){
	$.get('/talleres', function(res){
		list = res;
		$('#datos').empty();
		if ($('#user_type').attr('value') == '1') {
			$(res.group).each(function(key, value){
				var ofcs = "";
				$(res.taller).each(function(key2, value2){
					if (value.id==value2.id) {ofcs+=' ║ '+value2.nombres+' '+value2.apellidos;}
				});
				$('#datos').append('<tr><td>'+(key+1)+'</td><td>'+value.fecha+'</td><td>'+value.nombre+'</td><td>'+ofcs+'</td><td>'+
					'<button value='+value.id+' OnClick="detalle(this);" class="btn btn-default" data-toggle="modal" data-target="#modalDetail">Detalles</button> '+
					'<a value='+value.id+' href="/taller/'+value.id+'/edit" class="btn btn-primary">Editar</a> '+
					'<button value='+value.id+' OnClick="danger(this);" class="btn btn-danger" data-toggle="modal" data-target="#modalRemove">Eliminar</button></td></tr>');
			})
		}else{
			$(res.group).each(function(key, value){
				var ofcs = "";
				$(res.taller).each(function(key2, value2){
					if (value.id==value2.id) {ofcs+=' ║ '+value2.nombres+' '+value2.apellidos;}
				});
				$('#datos').append('<tr><td>'+(key+1)+'</td><td>'+value.fecha+'</td><td>'+value.nombre+'</td><td>'+ofcs+'</td><td>'+
					'<button value='+value.id+' OnClick="detalle(this);" class="btn btn-default" data-toggle="modal" data-target="#modalDetail">Detalles</button></td></tr>');
			})
		}	
	});
}

function detalle(btn){
	$.get('taller/detail/'+btn.value, function(res){
		$('#fecha').html(res.taller[0].fecha);
		$('#lugar').html(res.taller[0].lugar);
		$('#duracion').html(res.taller[0].duracion);
		$('#actividad').html(res.taller[0].actividad);
		$('#observaciones').html('');
		$('#observaciones').html(res.taller[0].observaciones);
		$('#viaticos').html(res.taller[0].viaticos);
		$('#cant_mujeres').html(res.taller[0].cant_mujeres);
		$('#cant_hombres').html(res.taller[0].cant_hombres);
		$('#total').html(res.taller[0].cant_mujeres+res.taller[0].cant_hombres);
		//
		$('#oficiales').empty();
		$(res.oficiales).each(function(key, value){
			$('#oficiales').append('<li style="list-style-type: circle;">'+value.oficial+'</li>');
		});
		$('#contenidos').empty();
		$(res.contenidos).each(function(key, value){
			$('#contenidos').append('<li style="list-style-type: circle;">'+value.contenido+'</li>');
		});
		$('#audiencias').empty();
		$(res.audiencias).each(function(key, value){
			$('#audiencias').append('<li style="list-style-type: circle;">'+value.audiencia+'</li>');
		});
		$('#zonas').empty();
		$(res.detalles).each(function(key, value){
			if (value.escuela!=null) {
				$('#zonas').append('<li style="list-style-type: circle;">Escuela <i class="fa fa-long-arrow-right"></i> '+value.escuela+' (<b>'+value.departamento+'</b>)</li>');
			}else if (value.pais!=null) {
				$('#zonas').append('<li style="list-style-type: circle;">Internacional <i class="fa fa-long-arrow-right"></i> '+value.pais+'</li>');
			}else if (value.zona!=null) {
				$('#zonas').append('<li style="list-style-type: circle;">'+value.zona+'</li>');
			}
		});
	});
}

function danger(btn){
	$('#confirmRemove').val(btn.value);
}

function eliminar(btn){
	$.ajax({
		url: '/taller/'+btn.value,
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
		if ($('#user_type').attr('value') == '1') {
			$(list.group).each(function(key, value){
				var ofcs = "";
				$(list.taller).each(function(key2, value2){
					if (value.id==value2.id) {ofcs+=' ║ '+value2.nombres+' '+value2.apellidos;}
				});
				if (value.fecha >= $('#desde').val() && value.fecha <= $('#hasta').val() ) {
					$('#datos').append('<tr><td>'+(key+1)+'</td><td>'+value.fecha+'</td><td>'+value.nombre+'</td><td>'+ofcs+'</td><td>'+
						'<button value='+value.id+' OnClick="detalle(this);" class="btn btn-default" data-toggle="modal" data-target="#modalDetail">Detalles</button> '+
						'<a value='+value.id+' href="/taller/'+value.id+'/edit" class="btn btn-primary">Editar</a> '+
						'<button value='+value.id+' OnClick="danger(this);" class="btn btn-danger" data-toggle="modal" data-target="#modalRemove">Eliminar</button></td></tr>');
				}
			})
		}else{
			$(list.group).each(function(key, value){
				var ofcs = "";
				$(list.taller).each(function(key2, value2){
					if (value.id==value2.id) {ofcs+=' ║ '+value2.nombres+' '+value2.apellidos;}
				});
				if (value.fecha >= $('#desde').val() && value.fecha <= $('#hasta').val() ) {
					$('#datos').append('<tr><td>'+(key+1)+'</td><td>'+value.fecha+'</td><td>'+value.nombre+'</td><td>'+ofcs+'</td><td>'+
						'<button value='+value.id+' OnClick="detalle(this);" class="btn btn-default" data-toggle="modal" data-target="#modalDetail">Detalles</button></td></tr>');
				}
			})
		}
	}
});