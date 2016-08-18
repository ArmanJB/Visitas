$(function(){
	$(".select2").select2();
	setDepartamentos();
	listar();
});

function setDepartamentos(){
	$('#departamentos').empty();
	$('#departamentosA').empty();
	$.get('/departamentos', function(res){
		$(res).each(function(key, value){
			$('#departamentos').append('<option value="'+value.id+'">'+value.nombre+'</option>');
			$('#departamentosA').append('<option value="'+value.id+'">'+value.nombre+'</option>');
		})
	});
}

function listar(){
	$('#datosescuela').empty();
	$.get('/escuelas', function(res){
		$(res).each(function(key, value){
			$('#datosescuela').append('<tr><td>'+(key+1)+'</td><td>'+value.nombre+'</td><td>'+value.nombreDep+'</td><td>'+
				'<button value='+value.id+' OnClick="mostrar(this);" class="btn btn-primary" data-toggle="modal" data-target="#modalEdit">Editar</button> '+
				'<button value='+value.id+' OnClick="danger(this);" class="btn btn-danger" data-toggle="modal" data-target="#modalRemove">Eliminar</button></td></tr>');
		})
	});
}

$('#registrar').on('click', function(){
	$.ajax({
		url: '/escuela',
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		type: 'POST',
		dataType: 'json',
		data: {nombre: $('#nombre').val(), id_departamento: $('#departamentos').val()},

		success: function(){
			listar();
			$('#nombre').val('');
			$('#msj'+'escuela').removeClass('alert-danger');
			$('#msj'+'escuela').addClass('alert-success');
			$('#msj'+'escuela'+'-text').html('Registro agregado exitosamente!');
			$('#msj'+'escuela').fadeIn();
			window.setTimeout(function(){$('#msj'+'escuela').fadeOut();}, 2000);
		},
		error:function(msj){
			$('#msj'+'escuela').removeClass('alert-success');
			$('#msj'+'escuela').addClass('alert-danger');
			$('#msj'+'escuela'+'-text').html(msj.responseJSON.nombre);
			$('#msj'+'escuela').fadeIn();
			window.setTimeout(function(){$('#msj'+'escuela').fadeOut();}, 2000);
		}
	})
});

function mostrar(btn){
	$.get('/escuela/'+btn.value+'/edit', function(res){
		$('#idn').val(res.id);
		$('#nombreA').val(res.nombre);
		$('#departamentosA').val(res.id_departamento).trigger('change');
	})	
}

$('#actualizar').on('click', function(){
	$.ajax({
		url: '/escuela/'+$('#idn').val(),
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		type: 'PUT',
		dataType: 'json',
		data: {nombre: $('#nombreA').val(), id_departamento: $('#departamentosA').val()},
		success: function(){
			listar();
			$('#modalEdit').modal('toggle');
			$('#nombreA').val('');
			$('#msjescuela').removeClass('alert-danger');
			$('#msjescuela').addClass('alert-success');
			$('#msjescuela'+'-text').html('Registros actualizados exitosamente!');
			$('#msjescuela').fadeIn();
			window.setTimeout(function(){$('#msjescuela').fadeOut();}, 2000);
		}
	});
})


function danger(btn){
	$('#confirmRemove').val(btn.value);
}

function eliminar(btn){
	$.ajax({
		url: '/escuela/'+btn.value,
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		type: 'DELETE',
		dataType: 'json',
		success: function(){
			listar();
			$('#modalRemove').modal('toggle');
			$('#msjescuela').removeClass('alert-danger');
			$('#msjescuela').addClass('alert-success');
			$('#msjescuela'+'-text').html('Registros actualizados exitosamente!');
			$('#msjescuela').fadeIn();
			window.setTimeout(function(){$('#msjescuela').fadeOut();}, 2000);
		}
	});
}
$('#search').on('click', function(){
	if($('#toSearch').val() != ''){
		$('#datosescuela').empty();
		$.get('/escuelas/bySearch/'+$('#toSearch').val(), function(res){
			if (res.length == 0) {
				$('#msjescuela').removeClass('alert-success');
				$('#msjescuela').addClass('alert-danger');
				$('#msjescuela'+'-text').html('No se encontraron resultados!');
				$('#msjescuela').fadeIn();
				window.setTimeout(function(){$('#msjescuela').fadeOut();}, 2000);
			}
			$(res).each(function(key, value){
				$('#datosescuela').append('<tr><td>'+(key+1)+'</td><td>'+value.nombre+'</td><td>'+value.nombreDep+'</td><td>'+
					'<button value='+value.id+' OnClick="mostrar(this);" class="btn btn-primary" data-toggle="modal" data-target="#modalEdit">Editar</button> '+
					'<button value='+value.id+' OnClick="danger(this);" class="btn btn-danger" data-toggle="modal" data-target="#modalRemove">Eliminar</button></td></tr>');
			})
		});
	}else{
		listar();
	}
});