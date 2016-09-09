var tables = ['oficial', 'voluntario'];
$(function(){
	$(".select2").select2();
	setAreas();
	tables.forEach(function(item){listar(item); });
})

function setAreas(){
	$('#areas').empty(); $('#areasO').empty();
	$.get('/areas', function(res){
		$(res).each(function(key, value){
			$('#areas').append('<option value="'+value.id+'">'+value.nombre+'</option>');
			$('#areasO').append('<option value="'+value.id+'">'+value.nombre+'</option>');
		})
	});
}

function listar(model){
	$('#datos'+model).empty();
	$.get('/'+model+'s', function(res){
		$(res).each(function(key, value){
			$('#datos'+model).append('<tr><td>'+(key+1)+'</td><td>'+value.nombres+'</td><td>'+value.apellidos+'</td>'+((value.nombre!=undefined)?'<td>'+value.nombre+'</td>':' ')+'<td>'+
				'<button value='+value.id+' data="'+model+'" OnClick="mostrar(this);" class="btn btn-primary" data-toggle="modal" data-target="#modalEdit">Editar</button> '+
				'<button value='+value.id+' data="'+model+'" OnClick="danger(this);" class="btn btn-danger" data-toggle="modal" data-target="#modalRemove">Eliminar</button></td></tr>');
		})
	});
}

function registrar(btn){
	var dJson;
	if ($(btn).attr('data') == 'oficial') {
		dJson = {nombres: $('#nombres'+$(btn).attr('data')).val(), 
		apellidos: $('#apellidos'+$(btn).attr('data')).val(), 
		fecha_nac: $('#fecha').val(), id_area: $('#areas').val()}
	}else{
		dJson = {nombres: $('#nombres'+$(btn).attr('data')).val(), apellidos: $('#apellidos'+$(btn).attr('data')).val()}
	}
	$.ajax({
		url: '/'+$(btn).attr('data'),
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		type: 'POST',
		dataType: 'json',
		data: dJson,
		success: function(){
			listar($(btn).attr('data'));
			$('#nombres'+$(btn).attr('data')).val('');
			$('#apellidos'+$(btn).attr('data')).val('');
			$('#fecha').val('');

			$('#msj'+$(btn).attr('data')).removeClass('alert-danger');
			$('#msj'+$(btn).attr('data')).addClass('alert-success');
			$('#msj'+$(btn).attr('data')+'-text').html('Registro agregado exitosamente!');
			$('#msj'+$(btn).attr('data')).fadeIn();
			window.setTimeout(function(){$('#msj'+$(btn).attr('data')).fadeOut();}, 2000);
		},
		error:function(msj){
			$('#msj'+$(btn).attr('data')).removeClass('alert-success');
			$('#msj'+$(btn).attr('data')).addClass('alert-danger');
			$('#msj'+$(btn).attr('data')+'-text').html(msj.responseJSON.nombres+'<br>'+msj.responseJSON.apellidos);
			$('#msj'+$(btn).attr('data')).fadeIn();
			window.setTimeout(function(){$('#msj'+$(btn).attr('data')).fadeOut();}, 2000);
		}
	});
}

function mostrar(btn){
	$.get('/'+$(btn).attr('data')+'/'+btn.value+'/edit', function(res){
		$('#idn').val(res.id);
		$('#nombresn').val(res.nombres);
		$('#apellidosn').val(res.apellidos);
		$('#fechaO').val(res.fecha_nac);
		$('#areasO').val(res.id_area).trigger('change');
		$('#actualizarn').attr('data', $(btn).attr('data'));
		if ($(btn).attr('data') == 'oficial') {
			$('#edit-oficial').removeClass('hide');
		}else{
			$('#edit-oficial').addClass('hide');
		}
	})	
}

$('#actualizarn').on('click', function(){
	var tab = $(this).attr('data');
	var dJson;
	if ($(this).attr('data') == 'oficial') {
		dJson = {nombres: $('#nombresn').val(), apellidos: $('#apellidosn').val(), 
		fecha_nac: $('#fechaO').val(), id_area: $('#areasO').val()}
	}else{
		dJson = {nombres: $('#nombresn').val(), apellidos: $('#apellidosn').val()}
	}
	$.ajax({
		url: '/'+$(this).attr('data')+'/'+$('#idn').val(),
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		type: 'PUT',
		dataType: 'json',
		data: dJson,
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