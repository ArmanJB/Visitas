$(document).ready(function(){
	setAreas();
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
				'<td><button value='+value.id+' OnClick="mostrarDet(this);" class="btn btn-primary" data-toggle="modal" data-target="#modalDet"><i class="fa fa-list-ol fa-fw"></i> Detalles</button> '+
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
		$('#motivosList').empty();
		$('#otrosMotivosList').empty();
		setMotivos($('#areas').val());
		setOtrosMotivos(4);
		setOficiales($('#areas').val());
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
	
	$.ajax({
		url: route,
		headers: {'X-CSRF-TOKEN': token},
		type: 'POST',
		dataType: 'json',
		data: {fecha: fecha, id_escuela: escuela, id_oficial: oficial},

		success: function(resp){
			$('#msj-success').fadeIn();
			//console.log(resp.resp);
			addMotivos(resp.resp)
		},
		error:function(msj){
			$('#msj').html(msj.responseJSON.fecha);
			$('#msj-error').fadeIn();
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
}

function eliminarV(id){
	var route = '/visita/'+id+'';
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

function eliminar(btn){
	var route = '/detalle/byVisita/'+btn.value;

	$.get(route, function(res){
		var cant = res.length;
		if (cant == 0) {
			eliminarV(btn.value);
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
							eliminarV(btn.value);
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

	$('#title-det').html(oficial+' / '+fecha+'</br>'+escuela);

	var route = '/detalle/sbyVisita/'+btn.value;
	var datos = $('#list-motivos');
	datos.empty();
	$.get(route, function(res){
		$(res).each(function(key, value){
			console.log(value)
			datos.append('<a href="#" class="list-group-item" data="'+value.id+'">'+value.nombre+'</a>');
		})
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