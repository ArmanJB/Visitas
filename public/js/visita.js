$(document).ready(function(){
	setEscuelas();
	setOficiales();
	listar();
});

function setEscuelas(){
	var select = $('#escuelas');
	var route = '/escuelas';

	select.empty();

	$.get(route, function(res){
		$(res).each(function(key, value){
			select.append('<option value="'+value.id+'">'+value.nombre+'</option>');
		})
	});
}

function setOficiales(){
	var select = $('#oficiales');
	var route = '/oficiales';

	select.empty();

	$.get(route, function(res){
		$(res).each(function(key, value){
			select.append('<option value="'+value.id+'">'+value.nombres+' '+value.apellidos+'</option>');
		})
	});
}

function listar(){
	var tablaDatos = $('#datos');
	var route = '/visitas';

	$('#datos').empty();
	$.get(route, function(res){
		$(res).each(function(key, value){
			tablaDatos.append('<tr><td>'+value.fecha+'</td><td>'+value.oficial+'</td><td>'+value.escuela+'</td>'+
				'<td><button value='+value.id+' class="btn btn-primary"><i class="fa fa-list-ol fa-fw"></i> Detalles</button> '+
				'<button value='+value.id+' OnClick="mostrar(this);" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Editar</button> '+
				'<button value='+value.id+' OnClick="eliminar(this);" class="btn btn-danger">Eliminar</button></td></tr>');
		})
	});
}

$('#registro').on('click', function(){
	var fecha = $('#fecha').val();
	var escuela = $('#escuelas').val();
	var oficial = $('#oficiales').val();
	var route = '/visita';
	var token = $('#token').val();
	
	$.ajax({
		url: route,
		headers: {'X-CSRF-TOKEN': token},
		type: 'POST',
		dataType: 'json',
		data: {fecha: fecha, id_escuela: escuela, id_oficial: oficial},

		success: function(){
			$('#msj-success').fadeIn();
		},
		error:function(msj){
			$('#msj').html(msj.responseJSON.nombre);
			$('#msj-error').fadeIn();
		}
	})
});

function eliminar(btn){
	var route = '/visita/'+btn.value+'';
	var token = $('#token').val();

	$.ajax({
		url: route,
		headers: {'X-CSRF-TOKEN': token},
		type: 'DELETE',
		dataType: 'json',

		success: function(){
			listar();
			$('#msj-success').fadeIn();
		}
	});
}

function mostrar(btn){
	var route = '/visita/'+btn.value+'/edit';

	$.get(route, function(res){
		$('#id').val(res.id);
		$('#fecha').val(res.fecha);
		$('#escuelas').val(res.id_escuela);
		$('#oficiales').val(res.id_oficial);
	})	
}

$('#actualizar').on('click', function(){
	var value = $('#id').val();
	var fecha = $('#fecha').val();
	var escuela = $('#escuelas').val();
	var oficial = $('#oficiales').val();

	var route = '/visita/'+value+'';
	var token = $('#token').val();

	$.ajax({
		url: route,
		headers: {'X-CSRF-TOKEN': token},
		type: 'PUT',
		dataType: 'json',
		data: {fecha: fecha, id_escuela: escuela, id_oficial: oficial},

		success: function(){
			listar();
			$('#myModal').modal('toggle');
			$('#msj-success').fadeIn();
		}
	});
})