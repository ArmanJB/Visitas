$(function(){
	$(".select2").select2();
	setTypes();
	setOficiales();
	listar();
});

function setTypes(){
	$.get('/types', function(res){
		$('#tipos').empty(); $('#tiposA').empty();
		$('#tipos').append('<option value="placeholder">seleccione un tipo</option>');
		$(res).each(function(key, value){
			$('#tipos').append('<option value="'+value.id+'">'+value.name+'</option>');
			$('#tiposA').append('<option value="'+value.id+'">'+value.name+'</option>');
		});
	});
}

function setOficiales(){
	$.get('/oficials', function(res){
		$('#oficiales').empty(); $('#oficialesA').empty();
		$('#oficiales').append('<option value="placeholder">seleccione un oficial</option>');
		$('#oficialesA').append('<option value="placeholder">seleccione un oficial</option>');
		$(res).each(function(key, value){
			$('#oficiales').append('<option value="'+value.id+'">'+value.nombres+' '+value.apellidos+'</option>');
			$('#oficialesA').append('<option value="'+value.id+'">'+value.nombres+' '+value.apellidos+'</option>');
		});
	});
}

function listar(){
	$('#datos').empty();
	$.get('/usuarios', function(res){
		$(res).each(function(key, value){
			$('#datos').append('<tr><td>'+(key+1)+'</td>'+
				'<td>'+value.name+'</td>'+
				'<td>'+value.email+'</td>'+
				'<td>'+((value.type!=null)?value.type:'')+'</td>'+
				'<td>'+((value.oficial!=null)?value.oficial:'')+'</td><td>'+
				'<button value='+value.id+' OnClick="mostrar(this);" class="btn btn-primary" data-toggle="modal" data-target="#modalEdit">Editar</button> '+
				((value.id==1)?'':'<button value='+value.id+' OnClick="danger(this);" class="btn btn-danger" data-toggle="modal" data-target="#modalRemove">Eliminar</button>')+'</td></tr>');
		});
	});
}

$('#search').on('click', function(){
	if($('#toSearch').val() != ''){
		$('#datos').empty();
		$.get('/usuarios/bySearch/'+$('#toSearch').val(), function(res){
			if (res.length == 0) {
				$('#msjuser').removeClass('alert-success');
				$('#msjuser').addClass('alert-danger');
				$('#msjuser'+'-text').html('No se encontraron resultados!');
				$('#msjuser').fadeIn();
				window.setTimeout(function(){$('#msjuser').fadeOut();}, 2000);
			}
			$(res).each(function(key, value){
				$('#datos').append('<tr><td>'+(key+1)+'</td>'+
				'<td>'+value.name+'</td>'+
				'<td>'+value.email+'</td>'+
				'<td>'+((value.type!=null)?value.type:'')+'</td>'+
				'<td>'+((value.oficial!=null)?value.oficial:'')+'</td><td>'+
				'<button value='+value.id+' OnClick="mostrar(this);" class="btn btn-primary" data-toggle="modal" data-target="#modalEdit">Editar</button> '+
				((value.id==1)?'':'<button value='+value.id+' OnClick="danger(this);" class="btn btn-danger" data-toggle="modal" data-target="#modalRemove">Eliminar</button>')+'</td></tr>');
			})
		});
	}else{
		listar();
	}
});

$('#tipos').on('change', function(){
	if ($('#tipos').val()==2 || $('#tipos').val()==3) {
		$('#oficial-group').fadeIn();
	}else{
		$('#oficial-group').fadeOut();
	}
});
$('#tiposA').on('change', function(){
	if ($('#tiposA').val()==2 || $('#tiposA').val()==3) {
		$('#oficial-groupA').fadeIn();
	}else{
		$('#oficial-groupA').fadeOut();
	}
});

$('#registrar').on('click', function(){
	if ($('#password').val() == '' || ($('#password').val() != $('#confirm').val())) {
		$('#msjuser').removeClass('alert-success');
		$('#msjuser').addClass('alert-danger');
		$('#msjuser'+'-text').html('Las contraseñas ingresadas no coinciden!');
		$('#msjuser').fadeIn();
		window.setTimeout(function(){$('#msjuser').fadeOut();}, 2000);
		return;
	}
	if ($('#tipos').val()=='placeholder') {
		$('#msjuser').removeClass('alert-success');
		$('#msjuser').addClass('alert-danger');
		$('#msjuser'+'-text').html('Debe seleccionar un tipo!');
		$('#msjuser').fadeIn();
		window.setTimeout(function(){$('#msjuser').fadeOut();}, 2000);
		return;
	}
	var JData;
	if ($('#tipos').val()==2 || $('#tipos').val()==3) {
		if ($('#oficiales').val()=='placeholder') {
			$('#msjuser').removeClass('alert-success');
			$('#msjuser').addClass('alert-danger');
			$('#msjuser'+'-text').html('Debe seleccionar un oficial!');
			$('#msjuser').fadeIn();
			window.setTimeout(function(){$('#msjuser').fadeOut();}, 2000);
			return;
		}
		JData = {
			name: $('#nombre').val(), email: $('#email').val(), password: $('#password').val(),
			id_type: $('#tipos').val(), id_oficial: $('#oficiales').val()
		};
	}else{
		JData = {
			name: $('#nombre').val(), email: $('#email').val(), password: $('#password').val(),
			id_type: $('#tipos').val()
		};
	}

	$.ajax({
		url: '/usuario',
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		type: 'POST',
		dataType: 'json',
		data: JData,

		success: function(){
			listar();
			$('#nombre').val('');
			$('#email').val('');
			$('#password').val('');
			$('#confirm').val('');
			$('#tipos').val('placeholder').trigger('change');
			$('#oficiales').val('placeholder').trigger('change');
			$('#oficial-group').fadeOut();

			$('#msjuser').removeClass('alert-danger');
			$('#msjuser').addClass('alert-success');
			$('#msjuser'+'-text').html('Registro agregado exitosamente!');
			$('#msjuser').fadeIn();
			window.setTimeout(function(){$('#msjuser').fadeOut();}, 2000);
		},
		error:function(msj){
			$('#msjuser').removeClass('alert-success');
			$('#msjuser').addClass('alert-danger');
			$('#msjuser'+'-text').html((msj.responseJSON.name!=undefined)?msj.responseJSON.name:''+'<br>'+
				(msj.responseJSON.email!=undefined)?msj.responseJSON.email:''+'<br>'+
				(msj.responseJSON.password!=undefined)?msj.responseJSON.password:'');
			$('#msjuser').fadeIn();
			window.setTimeout(function(){$('#msjuser').fadeOut();}, 2000);
		}
	});
});

function danger(btn){
	$('#confirmRemove').val(btn.value);
}

function eliminar(btn){
	$.ajax({
		url: '/usuario/'+btn.value,
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		type: 'DELETE',
		dataType: 'json',
		success: function(){
			listar();
			$('#modalRemove').modal('toggle');
			$('#msjuser').removeClass('alert-danger');
			$('#msjuser').addClass('alert-success');
			$('#msjuser'+'-text').html('Registros actualizados exitosamente!');
			$('#msjuser').fadeIn();
			window.setTimeout(function(){$('#msjuser').fadeOut();}, 2000);
		}
	});
}

function mostrar(btn){
	$.get('/usuario/'+btn.value+'/edit', function(res){
		$('#idn').val(res.id);
		$('#nombreA').val(res.name);
		$('#emailA').val(res.email);
		$('#tiposA').val(res.id_type).trigger('change');
		$('#oficialesA').val(((res.id_oficial!=null)?res.id_oficial:'placeholder')).trigger('change');

		if (res.id_type==1) {
			$('#oficial-groupA').fadeOut();
		}else{
			$('#oficial-groupA').fadeIn();
		}

		$('#passwordA').val('');
		$('#confirmA').val('');
	})	
}

$('#actualizar').on('click', function(){
	if ($('#passwordA').val() != $('#confirmA').val()) {
		$('#msjuserA').removeClass('alert-success');
		$('#msjuserA').addClass('alert-danger');
		$('#msjuserA'+'-text').html('Las contraseñas ingresadas no coinciden!');
		$('#msjuserA').fadeIn();
		window.setTimeout(function(){$('#msjuserA').fadeOut();}, 2000);
		return;
	}
	var JData;
	if ($('#tiposA').val()==2 || $('#tiposA').val()==3) {
		if ($('#oficialesA').val()=='placeholder') {
			$('#msjuserA').removeClass('alert-success');
			$('#msjuserA').addClass('alert-danger');
			$('#msjuserA'+'-text').html('Debe seleccionar un oficial!');
			$('#msjuserA').fadeIn();
			window.setTimeout(function(){$('#msjuserA').fadeOut();}, 2000);
			return;
		}
		if ($('#passwordA').val()=='') {
			JData = {
				name: $('#nombreA').val(), email: $('#emailA').val(),
				id_type: $('#tiposA').val(), id_oficial: $('#oficialesA').val()
			};
		}else{
			JData = {
				name: $('#nombreA').val(), email: $('#emailA').val(), password: $('#passwordA').val(),
				id_type: $('#tiposA').val(), id_oficial: $('#oficialesA').val()
			};
		}
	}else{
		if ($('#passwordA').val()=='') {
			JData = {
				name: $('#nombreA').val(), email: $('#emailA').val(), id_type: $('#tiposA').val()
			};
		}else{
			JData = {
				name: $('#nombreA').val(), email: $('#emailA').val(), password: $('#passwordA').val(), id_type: $('#tiposA').val()
			};
		}
	}

	$.ajax({
		url: '/usuario/'+$('#idn').val(),
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		type: 'PUT',
		dataType: 'json',
		data: JData,
		success: function(){
			listar();
			$('#modalEdit').modal('toggle');
			$('#nombreA').val('');
			$('#emailA').val('');
			$('#passwordA').val('');
			$('#confirmA').val('');
			$('#tiposA').val('placeholder').trigger('change');
			$('#oficialesA').val('placeholder').trigger('change');
			$('#oficial-groupA').fadeOut();

			$('#msjuser').removeClass('alert-danger');
			$('#msjuser').addClass('alert-success');
			$('#msjuser'+'-text').html('Registros actualizados exitosamente!');
			$('#msjuser').fadeIn();
			window.setTimeout(function(){$('#msjuser').fadeOut();}, 2000);
		},
		error:function(msj){
			$('#msjuser').removeClass('alert-success');
			$('#msjuserA').addClass('alert-danger');
			$('#msjuserA'+'-text').html((msj.responseJSON.name!=undefined)?msj.responseJSON.name:''+'<br>'+
				(msj.responseJSON.email!=undefined)?msj.responseJSON.email:''+'<br>'+
				(msj.responseJSON.password!=undefined)?msj.responseJSON.password:'');
			$('#msjuserA').fadeIn();
			window.setTimeout(function(){$('#msjuserA').fadeOut();}, 2000);
		}
	});
})