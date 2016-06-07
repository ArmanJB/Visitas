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
			select.append('<option value="'+value.id+'">'+value.nombre+'</option>');
		})
	});
}

function listar(){
	var tablaDatos = $('#datos');
	var route = '/motivos';

	$('#datos').empty();
	$.get(route, function(res){
		$(res).each(function(key, value){
			tablaDatos.append('<tr><td>'+value.nombreAr+'</td><td>'+value.nombre+'</td>'+
				'<td><button value='+value.id+' OnClick="mostrar(this);" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Editar</button> '+
				'<button value='+value.id+' OnClick="eliminar(this);" class="btn btn-danger">Eliminar</button></td></tr>');
		})
	});
}

$('#registro').on('click', function(){
	var nombreData = $('#nombre').val();
	var depData = $('#areas').val();
	var route = '/motivo';
	var token = $('#token').val();
	
	$.ajax({
		url: route,
		headers: {'X-CSRF-TOKEN': token},
		type: 'POST',
		dataType: 'json',
		data: {nombre: nombreData, id_area: depData},

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
	var route = '/motivo/'+btn.value+'';
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
	var route = '/motivo/'+btn.value+'/edit';

	$.get(route, function(res){
		$('#nombre').val(res.nombre);
		$('#id').val(res.id);
		$('#areas').val(res.id_area);
	})	
}

$('#actualizar').on('click', function(){
	var value = $('#id').val();
	var dato = $('#nombre').val();
	var datoDep = $('#areas').val();
	var route = '/motivo/'+value+'';
	var token = $('#token').val();

	$.ajax({
		url: route,
		headers: {'X-CSRF-TOKEN': token},
		type: 'PUT',
		dataType: 'json',
		data: {nombre: dato, id_area: datoDep},

		success: function(){
			listar();
			$('#myModal').modal('toggle');
			$('#msj-success').fadeIn();
		}
	});
})