$(document).ready(function(){
	setDepartamentos();
	listar();
});

function setDepartamentos(){
	var select = $('#departamentos');
	var route = '/departamentos';

	select.empty();

	$.get(route, function(res){
		$(res).each(function(key, value){
			select.append('<option value="'+value.id+'">'+value.nombre+'</option>');
			//
			$('#deps').append('<li><a href="#" class="option-dep" data="'+value.id+'" OnClick="cambiarFiltro(this);">'+value.nombre+'</a></li>');
			$('#label-dep').html(value.nombre);
			$('#label-dep').attr('data', value.id);
		})
	});
}

function listar(){
	var tablaDatos = $('#datos');
	var route = '/escuelas';

	$('#datos').empty();
	$.get(route, function(res){
		$(res).each(function(key, value){
			tablaDatos.append('<tr><td>'+value.nombre+'</td><td>'+value.nombreDep+'</td>'+
				'<td><button value='+value.id+' OnClick="mostrar(this);" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Editar</button> '+
				'<button value='+value.id+' OnClick="eliminar(this);" class="btn btn-danger">Eliminar</button></td></tr>');
		})
	});
}

$('#registro').on('click', function(){
	var nombreData = $('#nombre').val();
	var depData = $('#departamentos').val();
	var route = '/escuela';
	var token = $('#token').val();
	
	$.ajax({
		url: route,
		headers: {'X-CSRF-TOKEN': token},
		type: 'POST',
		dataType: 'json',
		data: {nombre: nombreData, id_departamento: depData},

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

function eliminar(btn){
	var route = '/escuela/'+btn.value+'';
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
	var route = '/escuela/'+btn.value+'/edit';

	$.get(route, function(res){
		$('#nombre').val(res.nombre);
		$('#id').val(res.id);
		$('#departamentos').val(res.id_departamento);
	})	
}

$('#actualizar').on('click', function(){
	var value = $('#id').val();
	var dato = $('#nombre').val();
	var datoDep = $('#departamentos').val();
	var route = '/escuela/'+value+'';
	var token = $('#token').val();

	$.ajax({
		url: route,
		headers: {'X-CSRF-TOKEN': token},
		type: 'PUT',
		dataType: 'json',
		data: {nombre: dato, id_departamento: datoDep},

		success: function(){
			listar();
			$('#myModal').modal('toggle');
			$('#msj-success').fadeIn();
			window.setTimeout(function(){$('#msj-success').fadeOut();}, 2000);
		}
	});
})


/******************************************/
$('#select-esc').on('click', function(){
	$('#filtrar').html('Escuela');
	$('#search-dep').addClass('hide');
	$('#search-esc').removeClass('hide');
});
$('#select-dep').on('click', function(){
	$('#filtrar').html('Departamento');
	$('#search-dep').removeClass('hide');
	$('#search-esc').addClass('hide');
});
function cambiarFiltro(btn){
	$('#label-dep').html(btn.text);
	$('#label-dep').attr('data', btn.getAttribute('data'));
}
$('#search').on('click', function(){
	if ($('#filtrar').html() == 'Escuela') {
		if ($('#search-esc').val()!="") {
			$('#datos').empty();
			$.get('/escuelas/bySearch/'+$('#search-esc').val(), function(res){
				$(res).each(function(key, value){
					$('#datos').append('<tr><td>'+value.nombre+'</td><td>'+value.nombreDep+'</td>'+
						'<td><button value='+value.id+' OnClick="mostrar(this);" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Editar</button> '+
						'<button value='+value.id+' OnClick="eliminar(this);" class="btn btn-danger">Eliminar</button></td></tr>');
				})
			});
		}else{
			listar();
		}
	}else{
		$('#datos').empty();
		$.get('/escuelas/bySearchDep/'+$('#label-dep').attr('data'), function(res){
			$(res).each(function(key, value){
				$('#datos').append('<tr><td>'+value.nombre+'</td><td>'+value.nombreDep+'</td>'+
					'<td><button value='+value.id+' OnClick="mostrar(this);" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Editar</button> '+
					'<button value='+value.id+' OnClick="eliminar(this);" class="btn btn-danger">Eliminar</button></td></tr>');
			})
		});
	}
});