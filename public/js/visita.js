$(document).ready(function(){
	setAreas();
	setOficial();
	setEscuelas();
	setDepartamentos();
	listar();
});

function listar(){
	var tablaDatos = $('#datos');
	var route = '/visitas';

	$('#datos').empty();
	$.get(route, function(res){
		$(res).each(function(key, value){
			tablaDatos.append('<tr><td>'+value.fecha+'</td><td>'+value.oficial+'</td><td>'+value.escuela+'</td>'+
				'<td><button dep="'+value.dep+'"" value='+value.id+' OnClick="mostrarDet(this);" class="btn btn-primary" data-toggle="modal" data-target="#modalDet"><i class="fa fa-list-ol fa-fw"></i> Detalles</button> '+
				'<button value='+value.id+' OnClick="mostrar(this);" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Editar</button> '+
				'<button value='+value.id+' OnClick="eliminar(this);" class="btn btn-danger">Eliminar</button></td></tr>');
		})
	});
}

function setAreas(){
	var select = $('#areas');
	var route = '/areas';

	$.get(route, function(res){
		$(res).each(function(key, value){
			select.append('<option value="'+value.id+'">'+value.nombre+'</option>');
		})
	});
}
function setOficial(){
	var select = $('#oficiales');
	var route = '/oficiales';

	select.empty();

	$.get(route, function(res){
		$(res).each(function(key, value){
			select.append('<option value="'+value.id+'">'+value.nombres+' '+value.apellidos+'</option>');
		})
	});
}
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
function setDepartamentos(){
	var select = $('#departamentos');
	var route = '/departamentos';

	$.get(route, function(res){
		$(res).each(function(key, value){
			select.append('<option value="'+value.id+'">'+value.nombre+'</option>');
		})
	});
}
$('#departamentos').change(function(){
	var select = $('#escuelas');
	var route = '/escuela/byDep/'+$('#departamentos').val();

	select.empty();

	$.get(route, function(res){
		$(res).each(function(key, value){
			select.append('<option value="'+value.id+'">'+value.nombre+'</option>');
		})
	});
});

$('#areas').change(function(){
	$('.row').show(1000);
	//
	if ($('#areas').val() != 'placeholder') {
		$('#otrosMotivosList').show();
		$('#otrosMotivosList').attr('data', 'on');

		$('#motivosList').empty();
		$('#otrosMotivosList').empty();
		setMotivos($('#areas').val());
		setOtrosMotivos(4);
		setOficiales($('#areas').val());
		if ($('#areas').val() == 4) {
			$('#otrosMotivosList').hide();
			$('#otrosMotivosList').attr('data', 'off');
		}
	}else{
		$('.row').hide(1000);
	}
});

function setMotivos(id){
	var select = $('#motivosList');
	var route = '/motivo/byArea/'+id;

	select.empty();

	$.get(route, function(res){
		$(res).each(function(key, value){
			//select.append('<option value="'+value.id+'">'+value.nombre+'</option>');
			select.append('<p><input type="checkbox" class="filled-in" id="box-'+value.id+'" value="'+value.id+'"/><label for="box-'+value.id+'">'+value.nombre+'</label></p>');
		})
	});
}
function setOtrosMotivos(id){
	var select = $('#otrosMotivosList');
	var route = '/motivo/byArea/'+id;

	select.empty();

	$.get(route, function(res){
		$(res).each(function(key, value){
			select.append('<p><input type="checkbox" class="filled-in" id="box-'+value.id+'" value="'+value.id+'"/><label for="box-'+value.id+'">'+value.nombre+'</label></p>');
		})
	});
}
function setOficiales(id){
	var select = $('#oficiales');
	var route = '/oficial/byArea/'+id;

	select.empty();

	$.get(route, function(res){
		$(res).each(function(key, value){
			select.append('<option value="'+value.id+'">'+value.nombres+' '+value.apellidos+'</option>');
		})
	});
}

$('#registro').on('click', function(){
	var fecha = $('#fecha').val();
	var escuela = $('#escuelas').val();
	var oficial = $('#oficiales').val();
	var route = '/visita';
	var token = $('#token').val();

	if (fecha.length==0 || escuela=="" || oficial=="") {
		$('#msj').html("Existen campos incompletos!");
		$('#msj-error').fadeIn();
		window.setTimeout(function(){$('#msj-error').fadeOut();}, 1000);
		return;
	}else if ($('#pendientes').val().length < 10) {
		$('#msj').html("Campo pendientes debe tener al menos 10 caracteres!");
		$('#msj-error').fadeIn();
		window.setTimeout(function(){$('#msj-error').fadeOut();}, 1000);
		return;
	}else if ($('#motivosList p input:checkbox:checked').length==0 && $('#otrosMotivosList p input:checkbox:checked').length==0){
		$('#msj').html("Se debe seleccionar al menos un motivo!");
		$('#msj-error').fadeIn();
		window.setTimeout(function(){$('#msj-error').fadeOut();}, 1000);
		return;
	}	
	$.ajax({
		url: route,
		headers: {'X-CSRF-TOKEN': token},
		type: 'POST',
		dataType: 'json',
		data: {fecha: fecha, id_escuela: escuela, id_oficial: oficial},

		success: function(resp){
			$('#msj-success').fadeIn();
			//console.log(resp.resp);
			addMotivos(resp.resp);
			addPendiente(resp.resp);
			//
			$('#areas').change();
			$('#fecha').val('');
			$('#pendientes').val('');
			window.setTimeout(function(){$('#msj-success').fadeOut();}, 2000);
		},
		error:function(msj){
			$('#msj').html(msj.responseJSON.fecha);
			$('#msj-error').fadeIn();
			window.setTimeout(function(){$('#msj-error').fadeOut();}, 2000);
		}
	})
});

function addMotivos(id){
	var token = $('#token').val();
	var total = $('#motivosList p input:checkbox:checked').length;
	
	$('#motivosList p input:checkbox:checked').each(function(index){
		//console.log(this.value);
		$.ajax({
			url: '/detalle',
			headers: {'X-CSRF-TOKEN': token},
			type: 'POST',
			dataType: 'json',
			data: {id_visita: id, id_motivo: this.value}
			
		});
	});

	if ($('#otrosMotivosList').attr('data') == 'on') {
		var total = $('#otrosMotivosList p input:checkbox:checked').length;
	
		$('#otrosMotivosList p input:checkbox:checked').each(function(index){
			$.ajax({
				url: '/detalle',
				headers: {'X-CSRF-TOKEN': token},
				type: 'POST',
				dataType: 'json',
				data: {id_visita: id, id_motivo: this.value}
				
			});
		});
	}
}

function addPendiente(id){
	var token = $('#token').val();
	var pendiente = $('#pendientes').val();

	$.ajax({
		url: '/pendiente',
		headers: {'X-CSRF-TOKEN': token},
		type: 'POST',
		dataType: 'json',
		data: {nombre: pendiente, finalizado: false, id_visita: id}
	});
}

function eliminarV(id){
	$.ajax({
		url: '/visita/'+id+'',
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		type: 'DELETE',
		dataType: 'json',

		success: function(){
			listar();
			$('#msj-success').fadeIn();
			window.setTimeout(function(){$('#msj-success').fadeOut();}, 2000);
		}
	});
}

function eliminarP(id){
	$.get('pendiente/byVisita/'+id, function(res){
		var cant = res.length;
		if(cant == 0){
			eliminarV(id);
		}else{
			$(res).each(function(key, value){
				//console.log(value.id)
				$.ajax({
					url: '/pendiente/'+value.id,
					headers: {'X-CSRF-TOKEN': $('#token').val()},
					type: 'DELETE',
					dataType: 'json',
					success: function(){
						if (key == (cant-1)) {
							//
							eliminarV(id);
							//
						}
					}
				});
			});
		}
	});

}

function eliminar(btn){
	var route = '/detalle/byVisita/'+btn.value;

	$.get(route, function(res){
		var cant = res.length;
		if (cant == 0) {
			eliminarP(btn.value);
		}else{
			$(res).each(function(key, value){
				//console.log(value.id);
				$.ajax({
					url: '/detalle/'+value.id,
					headers: {'X-CSRF-TOKEN': $('#token').val()},
					type: 'DELETE',
					dataType: 'json',
					success: function(){
						if (key == (cant-1)) {
							eliminarP(btn.value);
						}
					}
				});
			})
		}
	});
}

function mostrarDet(btn){
	var index = $(btn).closest('tr').index() +1;
	var tabla = document.getElementById("tabla-visitas");
	var fecha = tabla.rows[index].cells[0].innerHTML;
	var oficial = tabla.rows[index].cells[1].innerHTML;
	var escuela = tabla.rows[index].cells[2].innerHTML;
	var dep = btn.getAttribute('dep');
	
	$('#title-det').html('Oficial: '+oficial+'</br>Fecha: '+fecha+'</br>Departamento: '+dep+'</br>Escuela: '+escuela);

	var route = '/detalle/sbyVisita/'+btn.value;
	var datos = $('#list-motivos');
	var datosO = $('#list-otrosMotivos');
	datos.empty();
	datosO.empty();
	$.get(route, function(res){
		$(res).each(function(key, value){
			//console.log(value.id_area)
			if (value.id_area != 4) {
				datos.append('<a href="#" class="list-group-item" data="'+value.id+'">'+value.nombre+'</a>');
			}else{
				datosO.append('<a href="#" class="list-group-item" data="'+value.id+'">'+value.nombre+'</a>');
			}
		})
	});

	route = '/pendiente/sbyVisita/'+btn.value;
	var pendiente = $('#list-pendientes');
	pendiente.empty();
	$.get(route, function(res){
		//console.log(res)
		$(res).each(function(key, value){
			//console.log(value)
			pendiente.append('<a href="#" class="list-group-item" data="'+value.id+'">'+value.nombre+'</a>');
		});
	});
}

function mostrar(btn){
	var route = '/visita/'+btn.value+'/edit';

	$.get(route, function(res){
		$('#id').val(res.id);
		$('#fecha').val(res.fecha);
		$('#escuelas').val(res.id_escuela);
		$('#oficiales').val(res.id_oficial);
	});

	var datos = $('#list-motivos2');
	datos.empty();
	$.get('/detalle/sbyVisita/'+btn.value, function(res){
		$(res).each(function(key, value){
			datos.append('<a href="#" class="list-group-item" data="'+value.id+'">'+value.nombre+'</a>');
		})
	});
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