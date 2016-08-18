var tables = ['area', 'departamento', 'contenido', 'audiencia', 'lugar', 'actividad', 'internacional', 'zonareceptora'];
$(document).ready(function(){
	tables.forEach(function(item){listar(item); });
});

function listar(model){
	$('#datos'+model).empty();
	$.get('/'+model+'s', function(res){
		$(res).each(function(key, value){
			$('#datos'+model).append('<tr><td>'+value.nombre+'</td><td>'+
				'<button value='+value.id+' data="'+model+'" OnClick="mostrar(this);" class="btn btn-default" data-toggle="modal" data-target="#modalEdit">Editar</button> '+
				'<button value='+value.id+' data="'+model+'" OnClick="danger(this);" class="btn btn-danger" data-toggle="modal" data-target="#modalRemove">Eliminar</button></td></tr>');
		})
	});
}

function mostrar(btn){
	$.get('/'+$(btn).attr('data')+'/'+btn.value+'/edit', function(res){
		$('#idn').val(res.id);
		$('#nombren').val(res.nombre);
		$('#actualizarn').attr('data', $(btn).attr('data'));
	})	
}

function danger(btn){
	$('#confirmRemove').val(btn.value);
	$('#confirmRemove').attr('data', $(btn).attr('data'));
}

function eliminar(btn){
	$.ajax({
		url: '/'+$(btn).attr('data')+'/'+btn.value,
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		type: 'DELETE',
		dataType: 'json',
		success: function(){
			listar($(btn).attr('data'));
			$('#modalRemove').modal('toggle');
			$('#msj'+$(btn).attr('data')).removeClass('alert-danger');
			$('#msj'+$(btn).attr('data')).addClass('alert-success');
			$('#msj'+$(btn).attr('data')+'-text').html('Registros actualizados exitosamente!');
			$('#msj'+$(btn).attr('data')).fadeIn();
			window.setTimeout(function(){$('#msj'+$(btn).attr('data')).fadeOut();}, 2000);
		}
	});
}

function registrar(btn){
	$.ajax({
		url: '/'+$(btn).attr('data'),
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		type: 'POST',
		dataType: 'json',
		data: {nombre: $('#nombre'+$(btn).attr('data')).val()},
		success: function(){
			listar($(btn).attr('data'));
			$('#nombre'+$(btn).attr('data')).val('');
			$('#msj'+$(btn).attr('data')).removeClass('alert-danger');
			$('#msj'+$(btn).attr('data')).addClass('alert-success');
			$('#msj'+$(btn).attr('data')+'-text').html('Registro agregado exitosamente!');
			$('#msj'+$(btn).attr('data')).fadeIn();
			window.setTimeout(function(){$('#msj'+$(btn).attr('data')).fadeOut();}, 2000);
		},
		error:function(msj){
			$('#msj'+$(btn).attr('data')).removeClass('alert-success');
			$('#msj'+$(btn).attr('data')).addClass('alert-danger');
			$('#msj'+$(btn).attr('data')+'-text').html(msj.responseJSON.nombre);
			$('#msj'+$(btn).attr('data')).fadeIn();
			window.setTimeout(function(){$('#msj'+$(btn).attr('data')).fadeOut();}, 2000);
		}
	});
}

$('#actualizarn').on('click', function(){
	var tab = $(this).attr('data');
	$.ajax({
		url: '/'+$(this).attr('data')+'/'+$('#idn').val(),
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		type: 'PUT',
		dataType: 'json',
		data: {nombre: $('#nombren').val()},
		success: function(){
			listar(tab);
			$('#modalEdit').modal('toggle');
			$('#nombren').val('');
			$('#msj'+tab).removeClass('alert-danger');
			$('#msj'+tab).addClass('alert-success');
			$('#msj'+tab+'-text').html('Registros actualizados exitosamente!');
			$('#msj'+tab).fadeIn();
			window.setTimeout(function(){$('#msj'+tab).fadeOut();}, 2000);
		}
	});
})