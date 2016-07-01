$(document).ready(function(){
	setAreas();
	listar();
});

function setAreas(){
	var select = $('#areas');
	var route = '/areas';

	select.empty();

	$.get(route, function(res){
		$(res).each(function(key, value){
			select.append('<option value="'+value.id+'" data="'+value.meta+'">'+value.nombre+'</option>');
		})
	});
}

function listar(){
	var tablaDatos = $('#datos');
	var route = '/oficiales';

	$('#datos').empty();
	$.get(route, function(res){
		$(res).each(function(key, value){
			tablaDatos.append('<tr><td>'+value.nombres+'</td><td>'+value.apellidos+'</td><td>'+value.nombre+'</td><td>'+value.meta+'</td>'+
				'<td><button value='+value.id+' OnClick="mostrar(this);" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Editar</button> '+
				'<button value='+value.id+' OnClick="eliminar(this);" class="btn btn-danger">Eliminar</button></td></tr>');
		})
	});
}

$('#registro').on('click', function(){
	var nombres = $('#nombres').val();
	var apellidos = $('#apellidos').val();
	var nombre = $('#areas').val();
	var meta = $('#meta').val();
	var route = '/oficial';
	var token = $('#token').val();
	
	$.ajax({
		url: route,
		headers: {'X-CSRF-TOKEN': token},
		type: 'POST',
		dataType: 'json',
		data: {nombres: nombres, apellidos: apellidos, id_area: nombre, meta: meta},

		success: function(){
			$('#msj-success').fadeIn();
			$('#nombres').val('');
			$('#apellidos').val('');
			$('#meta').val('');
			window.setTimeout(function(){$('#msj-success').fadeOut();}, 2000);
		},
		error:function(msj){
			if (msj.responseJSON.nombres == undefined) {
				$('#msj').html(msj.responseJSON.apellidos);
			}else if(msj.responseJSON.apellidos == undefined){
				$('#msj').html(msj.responseJSON.nombres);
			}else{
				$('#msj').html(msj.responseJSON.nombres+'</br>'+msj.responseJSON.apellidos);
			}
			
			$('#msj-error').fadeIn();
			window.setTimeout(function(){$('#msj-error').fadeOut();}, 2000);
		}
	})
});

function eliminar(btn){
	var route = '/oficial/'+btn.value+'';
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

function mostrar(btn){
	var route = '/oficial/'+btn.value+'/edit';

	$.get(route, function(res){
		$('#nombres').val(res.nombres);
		$('#apellidos').val(res.apellidos);
		$('#id').val(res.id);
		$('#areas').val(res.id_area);
		$('#meta').val(res.meta);
	})	
}

$('#actualizar').on('click', function(){
	var value = $('#id').val();
	var nombres = $('#nombres').val();
	var apellidos = $('#apellidos').val();
	var nombre = $('#areas').val();
	var meta = $('#meta').val();
	var route = '/oficial/'+value+'';
	var token = $('#token').val();

	$.ajax({
		url: route,
		headers: {'X-CSRF-TOKEN': token},
		type: 'PUT',
		dataType: 'json',
		data: {nombres: nombres, apellidos: apellidos, id_area: nombre, meta: meta},

		success: function(){
			listar();
			$('#myModal').modal('toggle');
			$('#msj-success').fadeIn();
			window.setTimeout(function(){$('#msj-success').fadeOut();}, 2000);
		}
	});
})