$(document).ready(function(){
	listar();
});

function listar(){
	var tablaDatos = $('#datos');
	var route = '/areas';

	$('#datos').empty();
	$.get(route, function(res){
		$(res).each(function(key, value){
			tablaDatos.append('<tr><td>'+value.nombre+'</td><td><button value='+value.id+' OnClick="mostrar(this);" class="btn btn-default" data-toggle="modal" data-target="#myModal">Editar</button> '+
				'<button value='+value.id+' OnClick="mostrarDanger(this);" class="btn btn-danger" data-toggle="modal" data-target="#modalRemove">Eliminar</button></td></tr>');
		})
	});
}

function mostrar(btn){
	var route = '/area/'+btn.value+'/edit';

	$.get(route, function(res){
		$('#nombre').val(res.nombre);
		$('#meta').val(res.meta);
		$('#id').val(res.id);
	})	
}

function mostrarDanger(btn){
	$('#confirmRemove').val(btn.value);
}

function eliminar(btn){

	var route = '/area/'+btn.value+'';
	var token = $('#token').val();

	$.ajax({
		url: route,
		headers: {'X-CSRF-TOKEN': token},
		type: 'DELETE',
		dataType: 'json',

		success: function(){
			listar();
			$('#modalRemove').modal('toggle');
			$('#msj-success').fadeIn();
			window.setTimeout(function(){$('#msj-success').fadeOut();}, 2000);
		}
	});
}

$('#registro').on('click', function(){
	var nombreData = $('#nombre').val();
	var metaData = $('#meta').val();
	var route = '/area';
	var token = $('#token').val();

	$.ajax({
		url: route,
		headers: {'X-CSRF-TOKEN': token},
		type: 'POST',
		dataType: 'json',
		data: {nombre: nombreData, meta: metaData},

		success: function(){
			$('#msj-success').fadeIn();
			$('#nombre').val('');
			$('#meta').val('');
			window.setTimeout(function(){$('#msj-success').fadeOut();}, 2000);
		},
		error:function(msj){
			$('#msj').html(msj.responseJSON.nombre);
			$('#msj-error').fadeIn();
			window.setTimeout(function(){$('#msj-error').fadeOut();}, 2000);
		}
	})
});

$('#actualizar').on('click', function(){
	var value = $('#id').val();
	var dato = $('#nombre').val();
	var meta = $('#meta').val();
	var route = '/area/'+value+'';
	var token = $('#token').val();

	$.ajax({
		url: route,
		headers: {'X-CSRF-TOKEN': token},
		type: 'PUT',
		dataType: 'json',
		data: {nombre: dato, meta: meta},

		success: function(){
			listar();
			$('#myModal').modal('toggle');
			$('#msj-success').fadeIn();
			window.setTimeout(function(){$('#msj-success').fadeOut();}, 2000);
		}
	});
})