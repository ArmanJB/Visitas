$(document).ready(function(){
	listar();
});

function listar(){
	var tablaDatos = $('#datos');
	var route = '/departamentos';

	$('#datos').empty();
	$.get(route, function(res){
		$(res).each(function(key, value){
			tablaDatos.append('<tr><td>'+value.nombre+'</td><td><button value='+value.id+' OnClick="mostrar(this);" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Editar</button> '+
				'<button value='+value.id+' OnClick="eliminar(this);" class="btn btn-danger">Eliminar</button></td></tr>');
		})
	});
}

function mostrar(btn){
	var route = '/departamento/'+btn.value+'/edit';

	$.get(route, function(res){
		$('#nombre').val(res.nombre);
		$('#id').val(res.id);
	})	
}

function eliminar(btn){
	var route = '/departamento/'+btn.value+'';
	var token = $('#token').val();

	$.ajax({
		url: route,
		headers: {'X-CSRF-TOKEN': token},
		type: 'DELETE',
		dataType: 'json',

		success: function(){
			listar();
			$('#msj-success').fadeIn();
			window.setTimeout(function(){$('#msj-success').fadeOut();}, 2000);
		}
	});
}

$('#registro').on('click', function(){
	var nombreData = $('#nombre').val();
	var route = '/departamento';
	var token = $('#token').val();

	$.ajax({
		url: route,
		headers: {'X-CSRF-TOKEN': token},
		type: 'POST',
		dataType: 'json',
		data: {nombre: nombreData},

		success: function(){
			$('#msj-success').fadeIn();
			$('#nombre').val('');
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
	var route = '/departamento/'+value+'';
	var token = $('#token').val();

	$.ajax({
		url: route,
		headers: {'X-CSRF-TOKEN': token},
		type: 'PUT',
		dataType: 'json',
		data: {nombre: dato},

		success: function(){
			listar();
			$('#myModal').modal('toggle');
			$('#msj-success').fadeIn();
			window.setTimeout(function(){$('#msj-success').fadeOut();}, 2000);
		}
	});
})