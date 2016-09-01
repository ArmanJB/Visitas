function setDetails(id){
	$.get('/usuarios/detalle/'+id, function(res){
		$('#user_type').html(res[0].tipo);
		$('#user_type').attr('value', res[0].id);
		$('#user_area').html(res[0].area);
		$('#user_area').attr('value', res[0].id_area);
		$('#user_oficial').attr('value', res[0].oficial);

		if(res[0].id_area != null && res[0].id_area != '3'){
		$('#tallerEdu').fadeOut();
		}
	});
}

function mostrar(id){
	$.get('/usuario/'+id+'/edit', function(res){
		$('#idn').val(res.id);
		$('#nombreU').val(res.name);
		$('#emailU').val(res.email);
		$('#passwordU').val('');
		$('#confirmU').val('');
		$('#actualU').val('');
	})	
}

$('#actualizarU').on('click', function(){
	$('#parentUserPass').find('.has-error').each(function(){
		$(this).removeClass('has-error');
	});

	if ($('#passwordU').val() != $('#confirmU').val()) {
		$('#passwordU').parents('.form-group').addClass('has-error');
		$('#confirmU').parents('.form-group').addClass('has-error');
		$('#msjuserU').removeClass('alert-success');
		$('#msjuserU').addClass('alert-danger');
		$('#msjuserU'+'-text').html('Las contraseñas ingresadas no coinciden!');
		$('#msjuserU').fadeIn();
		window.setTimeout(function(){$('#msjuserU').fadeOut();}, 2000);
		return;
	}

	if ($('#passwordU').val() == '' || $('#confirmU').val() == ''){
		$('#passwordU').parents('.form-group').addClass('has-error');
		$('#confirmU').parents('.form-group').addClass('has-error');
		$('#msjuserU').removeClass('alert-success');
		$('#msjuserU').addClass('alert-danger');
		$('#msjuserU'+'-text').html('Existen campos obligatorios vacíos!');
		$('#msjuserU').fadeIn();
		window.setTimeout(function(){$('#msjuserU').fadeOut();}, 2000);
		return;
	}

	$.ajax({
		url: '/usuario/'+$('#idn').val(),
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		type: 'PUT',
		dataType: 'json',
		data: {name: $('#nombreU').val(), email: $('#emailU').val(), password: $('#passwordU').val()},
		success: function(res){
			$('#parentUserPass').find('.has-error').each(function(){
				$(this).removeClass('has-error');
			});
			$('#nombreU').val('');
			$('#emailU').val('');
			$('#passwordU').val('');
			$('#confirmU').val('');

			$('#msjuserU').removeClass('alert-danger');
			$('#msjuserU').addClass('alert-success');
			$('#msjuserU'+'-text').html('Registro actualizado exitosamente!');
			$('#msjuserU').fadeIn();
			window.setTimeout(function(){$('#msjuserU').fadeOut();$('#modalUserPass').modal('toggle');}, 2000);
		}
	});
})