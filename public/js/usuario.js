function mostrarUser(id){
	$.get('/usuario'+'/correct/'+id, function(res){
		$('#name').val(res.name);
		$('#email').val(res.email);
		$('#id').val(res.id);
	})	
}

$('#password').on('input', function(){
	if( $(this).val().length > 5){
		$('#actualizarUsuario').removeAttr('disabled');		
	}else{
		$('#actualizarUsuario').attr('disabled', '');	
	}
});

$('#actualizarUsuario').on('click', function(){
	var id = $('#id').val();
	var name = $('#name').val();
	var email = $('#email').val();
	var pass = $('#password').val();

	$.get('/usuario/upd/'+id+'/'+name+'/'+email+'/'+pass, function(res){
		if (res.mensaje == 'actualizado') {window.alert('Contraseña actualizada!');$('#modalUser').modal('toggle');}
	});

	/*$.ajax({
		url: '/usuario/'+id+'',
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		type: 'PUT',
		dataType: 'json',
		data: {name: name, email: email, password: pass},

		success: function(){
			$('#modalUser').modal('toggle');
		}
	});*/
})