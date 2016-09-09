$(function(){
	$(".select2").select2();
	setAreas();
	setMotivos();
	listar();
});

function setAreas(){
	$('#areas').empty();
	$.get('/areas', function(res){
		$('#areas').append('<option value="placeholder">Selecciona un Área</option>');
		$(res).each(function(key, value){
			$('#areas').append('<option value="'+value.id+'">'+value.nombre+'</option>');
		});
	});
}

function setMotivos(){
	$('#motivos').empty();
	$.get('/motivos', function(res){
		$('#motivos').append('<option value="placeholder">Selecciona un Motivo</option>');
		$(res).each(function(key, value){
			$('#motivos').append('<option value="'+value.id+'">'+value.nombre+'</option>');
		});
	});
}

function setSelect(model){
	(model=='motivo')?$('#labeln').html('Área:'):$('#labeln').html('Motivo:');
	$('#selectn').empty();
	$.get('/'+((model=='motivo')?'areas':'motivos'), function(res){
		//$('#selectn').append('<option value="placeholder">Selecciona</option>');
		$(res).each(function(key, value){
			$('#selectn').append('<option value="'+value.id+'">'+value.nombre+'</option>');
		});
	});
}

function listar(){
	$('#datosmotivos').empty();
	$.get('/motivos', function(res){
		$.get('/detalles', function(resp){
			$(res).each(function(key, value){
				$('#datosmotivos').append('<tr><td>'+(key+1)+'</td><td>'+value.nombre+'</td><td>'+value.nombreAr+'</td><td><span class="fa fa-arrow-down"></td><td>'+
					'<button value='+value.id+' data="motivo" OnClick="mostrar(this);" class="btn btn-primary" data-toggle="modal" data-target="#modalEdit">Editar</button> '+
					'<button value='+value.id+' data="motivo" OnClick="danger(this);" class="btn btn-danger" data-toggle="modal" data-target="#modalRemove">Eliminar</button></td></tr>');
				$(resp).each(function(key2, value2){
					if (value.id == value2.id_motivo) {
						$('#datosmotivos').append('<tr><td></td><td></td><td></td><td>'+value2.nombre+'</td><td>'+
							'<button value='+value2.id+' data="detalle" OnClick="mostrar(this);" class="btn btn-default" data-toggle="modal" data-target="#modalEdit">Editar</button> '+
							'<button value='+value2.id+' data="detalle" OnClick="danger(this);" class="btn btn-danger" data-toggle="modal" data-target="#modalRemove">Eliminar</button></td></tr>');
					}
				});
			});
		});
	});
}

$('#registrarM').on('click', function(){
	if ($('#areas').val() == 'placeholder') {
		$('#msjmotivo').removeClass('alert-success');
		$('#msjmotivo').addClass('alert-danger');
		$('#msjmotivo'+'-text').html('Debe seleccionar un área!');
		$('#msjmotivo').fadeIn();
		window.setTimeout(function(){$('#msjmotivo').fadeOut();}, 2000);
		return;
	}
	$.ajax({
		url: '/motivo',
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		type: 'POST',
		dataType: 'json',
		data: {nombre: $('#nombreM').val(), id_area: $('#areas').val()},
		success: function(){
			listar();
			$('#nombreM').val('');
			$('#areas').val('placeholder').trigger('change');
			$('#msjmotivo').removeClass('alert-danger');
			$('#msjmotivo').addClass('alert-success');
			$('#msjmotivo'+'-text').html('Registro agregado exitosamente!');
			$('#msjmotivo').fadeIn();
			window.setTimeout(function(){$('#msjmotivo').fadeOut();}, 2000);
			setMotivos();
		},
		error:function(msj){
			$('#msjmotivo').removeClass('alert-success');
			$('#msjmotivo').addClass('alert-danger');
			$('#msjmotivo'+'-text').html(msj.responseJSON.nombre);
			$('#msjmotivo').fadeIn();
			window.setTimeout(function(){$('#msjmotivo').fadeOut();}, 2000);
		}
	});
});

$('#registrarD').on('click', function(){
	if ($('#motivos').val() == 'placeholder') {
		$('#msjdetalle').removeClass('alert-success');
		$('#msjdetalle').addClass('alert-danger');
		$('#msjdetalle'+'-text').html('Debe seleccionar un motivo!');
		$('#msjdetalle').fadeIn();
		window.setTimeout(function(){$('#msjdetalle').fadeOut();}, 2000);
		return;
	}
	$.ajax({
		url: '/detalle',
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		type: 'POST',
		dataType: 'json',
		data: {nombre: $('#nombreD').val(), id_motivo: $('#motivos').val()},
		success: function(){
			listar();
			$('#nombreD').val('');
			$('#motivos').val('placeholder').trigger('change');
			$('#msjdetalle').removeClass('alert-danger');
			$('#msjdetalle').addClass('alert-success');
			$('#msjdetalle'+'-text').html('Registro agregado exitosamente!');
			$('#msjdetalle').fadeIn();
			window.setTimeout(function(){$('#msjdetalle').fadeOut();}, 2000);
		},
		error:function(msj){
			$('#msjdetalle').removeClass('alert-success');
			$('#msjdetalle').addClass('alert-danger');
			$('#msjdetalle'+'-text').html(msj.responseJSON.nombre);
			$('#msjdetalle').fadeIn();
			window.setTimeout(function(){$('#msjdetalle').fadeOut();}, 2000);
		}
	});
});

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
			listar();
			$('#modalRemove').modal('toggle');
			$('#msjlist').removeClass('alert-danger');
			$('#msjlist').addClass('alert-success');
			$('#msjlist'+'-text').html('Registros actualizados exitosamente!');
			$('#msjlist').fadeIn();
			window.setTimeout(function(){$('#msjlist').fadeOut();}, 2000);
		}
	});
}

function mostrar(btn){
	setSelect($(btn).attr('data'));
	$.get('/'+$(btn).attr('data')+'/'+btn.value+'/edit', function(res){
		$('#idn').val(res.id);
		$('#nombren').val(res.nombre);
		if ($(btn).attr('data')=='motivo') {
			$('#selectn').val(res.id_area).trigger('change');
		}else{
			$('#selectn').val(res.id_motivo).trigger('change');
		}
		
		$('#actualizar').attr('data', $(btn).attr('data'));
	})	
}

$('#actualizar').on('click', function(){
	var tab = $(this).attr('data');
	var dJson;
	if ($(this).attr('data') == 'motivo') {
		dJson = {nombre: $('#nombren').val(), id_area: $('#selectn').val()}
	}else{
		dJson = {nombre: $('#nombren').val(), id_motivo: $('#selectn').val()}
	}
	$.ajax({
		url: '/'+$(this).attr('data')+'/'+$('#idn').val(),
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		type: 'PUT',
		dataType: 'json',
		data: dJson,
		success: function(){
			listar();
			$('#modalEdit').modal('toggle');
			$('#nombren').val('');
			$('#msjlist').removeClass('alert-danger');
			$('#msjlist').addClass('alert-success');
			$('#msjlist'+'-text').html('Registros actualizados exitosamente!');
			$('#msjlist').fadeIn();
			window.setTimeout(function(){$('#msjlist').fadeOut();}, 2000);
		}
	});
})

$('#nombren').on('input', function(){
	if($('#nombren').val()==''){
		$('#actualizar').attr('disabled','');
	}else{
		$('#actualizar').removeAttr('disabled');
	}
});

$('#search').on('click', function(){
	if($('#toSearch').val() != ''){
		$('#datosmotivos').empty();
		$.get('/motivos/bySearch/'+$('#toSearch').val(), function(res){
			if (res.length == 0) {
				$('#msjlist').removeClass('alert-success');
				$('#msjlist').addClass('alert-danger');
				$('#msjlist'+'-text').html('No se encontraron resultados!');
				$('#msjlist').fadeIn();
				window.setTimeout(function(){$('#msjlist').fadeOut();}, 2000);
				return;
			}
			$.get('/detalles', function(resp){
				$(res).each(function(key, value){
					$('#datosmotivos').append('<tr><td>'+(key+1)+'</td><td>'+value.nombre+'</td><td>'+value.nombreAr+'</td><td><span class="fa fa-arrow-down"></td><td>'+
						'<button value='+value.id+' data="motivo" OnClick="mostrar(this);" class="btn btn-primary" data-toggle="modal" data-target="#modalEdit">Editar</button> '+
						'<button value='+value.id+' data="motivo" OnClick="danger(this);" class="btn btn-danger" data-toggle="modal" data-target="#modalRemove">Eliminar</button></td></tr>');
					$(resp).each(function(key2, value2){
						if (value.id == value2.id_motivo) {
							$('#datosmotivos').append('<tr><td></td><td></td><td></td><td>'+value2.nombre+'</td><td>'+
								'<button value='+value2.id+' data="detalle" OnClick="mostrar(this);" class="btn btn-default" data-toggle="modal" data-target="#modalEdit">Editar</button> '+
								'<button value='+value2.id+' data="detalle" OnClick="danger(this);" class="btn btn-danger" data-toggle="modal" data-target="#modalRemove">Eliminar</button></td></tr>');
						}
					});
				});
			});
		});
	}else{
		listar();
	}
});