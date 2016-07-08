$(document).ready(function(){
	setAreas();
	setOficial();
	setEscuelas();
	setDepartamentos();
	listar();
	if ($('#metadata').attr('data')=='user') {setMetaData();}
});

function setMetaData(){
	$.get('/oficial/byName/'+$('#metadata').attr('nameU'), function(res){
		$(res).each(function(key, value){
			$('#areas').val(value.id_area);
			$('#areas').change();
			$('#metadata').attr('ofc', value.id)
		})
	});
}

function listar(){
	var tablaDatos = $('#datos');
	var route = '/visitas';
	$('#datos').empty();

	if ($('#metadata').attr('data')=='user'){
		$.get('/visitasU/'+$('#metadata').attr('nameU'), function(res){
			$(res).each(function(key, value){
				tablaDatos.append('<tr><td>'+value.fecha+'</td><td>'+value.oficial+'</td><td>'+value.escuela+'</td>'+
					'<td><button dep="'+value.dep+'"" aulas="'+value.aulas+'" value='+value.id+' OnClick="mostrarDet(this);" class="btn btn-primary" data-toggle="modal" data-target="#modalDet"><i class="fa fa-list-ol fa-fw"></i> Detalles</button></td></tr>');
			})
		});
	}else{
		$.get(route, function(res){
			$(res).each(function(key, value){
				tablaDatos.append('<tr><td>'+value.fecha+'</td><td>'+value.oficial+'</td><td>'+value.escuela+'</td>'+
					'<td><button dep="'+value.dep+'"" aulas="'+value.aulas+'" value='+value.id+' OnClick="mostrarDet(this);" class="btn btn-primary" data-toggle="modal" data-target="#modalDet"><i class="fa fa-list-ol fa-fw"></i> Detalles</button> '+
					'<button value='+value.id+' OnClick="mostrar(this);" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Editar</button> '+
					'<button value='+value.id+' OnClick="mostrarDanger(this);" class="btn btn-danger" data-toggle="modal" data-target="#modalRemove">Eliminar</button></td></tr>');
			})
		});
	}
}

function setAreas(){
	var select = $('#areas');
	var route = '/areas';

	$.get(route, function(res){
		$(res).each(function(key, value){
			select.append('<option value="'+value.id+'">'+value.nombre+'</option>');
			//
			$('#ares').append('<li><a href="#" class="option-dep" data="'+value.id+'" OnClick="cambiarFiltroA(this);">'+value.nombre+'</a></li>');
			$('#label-are').html(value.nombre);
			$('#label-are').attr('data', value.id);
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
			//
			$('#ofcs').append('<li><a href="#" class="option-dep" data="'+value.id+'" OnClick="cambiarFiltro(this);">'+value.nombres+' '+value.apellidos+'</a></li>');
			$('#label-ofc').html(value.nombres+' '+value.apellidos);
			$('#label-ofc').attr('data', value.id);
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

function setHora(btn){
	if ($('#box-'+btn.getAttribute('value')).is(':checked')) {
		$('#hora'+btn.getAttribute('value')).attr('disabled', true);
		$('#hora'+btn.getAttribute('value')).val('');
	}else{
		$('#hora'+btn.getAttribute('value')).removeAttr('disabled');
	}
}

function setMotivos(id){
	var select = $('#motivosList');
	var route = '/motivo/byArea/'+id;

	select.empty();

	$.get(route, function(res){
		$(res).each(function(key, value){
			//select.append('<option value="'+value.id+'">'+value.nombre+'</option>');
			select.append('<p><input type="checkbox" class="filled-in" id="box-'+value.id+'" value="'+value.id+
				'" /><label for="box-'+value.id+'" value="'+value.id+'" OnClick="setHora(this);">'+value.nombre+
				'</label> <input type="number" min="1" placeholder="Horas utilizadas para la actividad.." class="form-control number" id="hora'+
				value.id+'" disabled/></p>');
		})
	});
}
function setOtrosMotivos(id){
	var select = $('#otrosMotivosList');
	var route = '/motivo/byArea/'+id;

	select.empty();

	$.get(route, function(res){
		$(res).each(function(key, value){
			select.append('<p><input type="checkbox" class="filled-in" id="box-'+value.id+'" value="'+value.id+
				'" /><label for="box-'+value.id+'" value="'+value.id+'" OnClick="setHora(this);">'+value.nombre+
				'</label> <input type="number" min="1" placeholder="Horas utilizadas para la actividad.." class="form-control number" id="hora'+
				value.id+'" disabled/></p>');
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
		if ($('#metadata').attr('data')=='user'){
			$('#oficiales').val($('#metadata').attr('ofc'));
		}
	});
}

function getNumbers(){
	var len = 0;
	$('.number').each(function(key, value){
		if (this.value!="") {len++}
	});

	return len;
}

$('#registro').on('click', function(){
	var fecha = $('#fecha').val();
	var escuela = $('#escuelas').val();
	var oficial = $('#oficiales').val();
	var aulas = $('#aulas').val();
	var route = '/visita';
	var token = $('#token').val();

	if (fecha.length==0 || escuela=="" || oficial=="" || aulas.length==0) {
		$('#msj').html("Existen campos incompletos!");
		$('#msj-error').fadeIn();
		window.setTimeout(function(){$('#msj-error').fadeOut();}, 1000);
		return;
	}/*else if ($('#pendientes').val().length < 10) {
		$('#msj').html("Campo pendientes debe tener al menos 10 caracteres!");
		$('#msj-error').fadeIn();
		window.setTimeout(function(){$('#msj-error').fadeOut();}, 1000);
		return;
	}*/else if($('#noPend').is(':checked') && $('#pendientes').val().length == 0){
		$('#msj').html("No existen pendientes escritos!");
		$('#msj-error').fadeIn();
		window.setTimeout(function(){$('#msj-error').fadeOut();}, 1000);
		return;
	}else if ($('#motivosList p input:checkbox:checked').length==0 && $('#otrosMotivosList p input:checkbox:checked').length==0){
		$('#msj').html("Se debe seleccionar al menos un motivo!");
		$('#msj-error').fadeIn();
		window.setTimeout(function(){$('#msj-error').fadeOut();}, 1000);
		return;
	}else if(($('#motivosList p input:checkbox:checked').length + $('#otrosMotivosList p input:checkbox:checked').length) != getNumbers() ){
		$('#msj').html("Existen campos de horas por motivos vacíos!");
		$('#msj-error').fadeIn();
		window.setTimeout(function(){$('#msj-error').fadeOut();}, 1000);
		return;
	}else if (isNaN(aulas)){
		$('#msj').html("Campo aulas tiene caracteres no válidos!");
		$('#msj-error').fadeIn();
		window.setTimeout(function(){$('#msj-error').fadeOut();}, 1000);
		return;
	}
	$.ajax({
		url: route,
		headers: {'X-CSRF-TOKEN': token},
		type: 'POST',
		dataType: 'json',
		data: {fecha: fecha, id_escuela: escuela, id_oficial: oficial, aulas: aulas},

		success: function(resp){
			$('#msj-success').fadeIn();
			//console.log(resp.resp);
			addMotivos(resp.resp);
			addPendiente(resp.resp);
			//
			$('#areas').change();
			$('#fecha').val('');
			$('#aulas').val('');
			$('#pendientes').val('');
			window.setTimeout(function(){$('#msj-success').fadeOut();}, 2000);
		},
		error:function(msj){
			$('#msj').html(msj.responseJSON.fecha);
			$('#msj-error').fadeIn();
			window.setTimeout(function(){$('#msj-error').fadeOut();}, 2000);
		}
	});
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
			data: {id_visita: id, id_motivo: this.value, horas: $('#hora'+this.value).val()}
			
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
				data: {id_visita: id, id_motivo: this.value, horas: $('#hora'+this.value).val()}
				
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
			$('#modalRemove').modal('toggle');
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

function mostrarDanger(btn){
	$('#confirmRemove').val(btn.value);
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
				if (value.horas < 2){
					datos.append('<a href="#" class="list-group-item" data="'+value.id+'">'+value.nombre+' ... '+value.horas+' hora</a>');
				}else{
					datos.append('<a href="#" class="list-group-item" data="'+value.id+'">'+value.nombre+' ... '+value.horas+' horas</a>');
				}
			}else{
				if (value.horas < 2){
					datosO.append('<a href="#" class="list-group-item" data="'+value.id+'">'+value.nombre+' ... '+value.horas+' hora</a>');
				}else{
					datosO.append('<a href="#" class="list-group-item" data="'+value.id+'">'+value.nombre+' ... '+value.horas+' horas</a>');
				}
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
	$('#list-aulas').empty();
	$('#list-aulas').append('<a href="#" class="list-group-item">'+btn.getAttribute('aulas')+'</a>');
}

function mostrar(btn){
	$('#recargarUpd').val(btn.value);
	//
	var route = '/visita/'+btn.value+'/edit';

	$.get(route, function(res){
		$('#id').val(res.id);
		$('#fecha').val(res.fecha);
		$('#escuelas').val(res.id_escuela);
		$('#oficiales').val(res.id_oficial);
		$('#aulas').val(res.aulas);
	});

	$.get('/pendiente/byVisita/'+btn.value, function(res){
		var cant = res.length;
		if(cant == 0){
			$('#pendientes').val('');
		}else{
			$(res).each(function(key, value){
				$('#pendientes').val(value.nombre);
				$('#pendientes').attr('data', value.id);
			});
		}
	});

	var datos = $('#list-motivos2');
	datos.empty();
	var mot = [];
	$.get('/detalle/sbyVisita/'+btn.value, function(res){
		$(res).each(function(key, value){
			datos.append('<a href="#" onclick="delMot(this);" class="list-group-item active mot motOld" data="'+value.id_motivo+'" dataDet="'+value.id+'">'+value.nombre+'</a>');
			datos.append('<input type="number" min="1" placeholder="Horas utilizadas para la actividad.." class="form-control number" id="newHora'+value.id_motivo+'" >');
			$('#newHora'+value.id_motivo).val(value.horas);
			mot.push(value.id_motivo);
		})
	});
	//
	$('#list-newMotivos').empty();
	setNewMotivos(mot);
}

function setNewMotivos(mots){
	$('#newMotivo').empty();
	$.get('/motivos', function(res){
		$(res).each(function(key, value){
			var cont =0;
			mots.forEach(function(index){
				if (index == value.id) {
					cont++;
				}
			});
			if(cont == 0){
				$('#newMotivo').append('<option value="'+value.id+'">'+value.nombre+'</option>');
			}
		})
	});
}

$('#addMotivo').on('click', function(){
	$('#list-newMotivos').append('<a href="#" onclick="delMot(this);" class="list-group-item active mot motNew" data="'+$('#newMotivo').val()+'">'+$('#newMotivo option:selected').text()+'</a>');
	$('#list-newMotivos').append('<input type="number" min="1" placeholder="Horas utilizadas para la actividad.." class="form-control number" id="newHora'+$('#newMotivo').val()+'" >');
	$('#newMotivo option:selected').remove();
});
function delMot(btn){
	var id = btn.getAttribute('data');
	$('#newMotivo').append('<option value="'+id+'">'+btn.text+'</option>');
	btn.remove();
	$('#newHora'+id).remove();
}
$('#actualizar').on('click', function(){
	var value = $('#id').val();
	var fecha = $('#fecha').val();
	var escuela = $('#escuelas').val();
	var oficial = $('#oficiales').val();
	var aulas = $('#aulas').val();

	var route = '/visita/'+value+'';
	var token = $('#token').val();

	if ($('.mot').length == 0) {
		$('#msgUpdDanger').html('Se debe seleccionar al menos un motivo!')
		$('#msj-fail').fadeIn();
		window.setTimeout(function(){$('#msj-fail').fadeOut();}, 2000);
		return;
	}else if ($('.mot').length!=getNumbers()) {
		$('#msgUpdDanger').html('Existen campos vacíos de horas!')
		$('#msj-fail').fadeIn();
		window.setTimeout(function(){$('#msj-fail').fadeOut();}, 2000);
		return;
	}else if (fecha.length==0 || escuela=="" || oficial=="" || aulas.length==0) {
		$('#msgUpdDanger').html("Existen campos incompletos!");
		$('#msj-fail').fadeIn();
		window.setTimeout(function(){$('#msj-fail').fadeOut();}, 1000);
		return;
	}/*else if ($('#pendientes').val().length < 10) {
		$('#msgUpdDanger').html("Campo pendientes debe tener al menos 10 caracteres!");
		$('#msj-fail').fadeIn();
		window.setTimeout(function(){$('#msj-fail').fadeOut();}, 1000);
		return;
	}*/else if (isNaN(aulas)){
		$('#msgUpdDanger').html("Campo aulas tiene caracteres no válidos!");
		$('#msj-fail').fadeIn();
		window.setTimeout(function(){$('#msj-fail').fadeOut();}, 1000);
		return;
	}

	$.ajax({
		url: route,
		headers: {'X-CSRF-TOKEN': token},
		type: 'PUT',
		dataType: 'json',
		data: {fecha: fecha, id_escuela: escuela, id_oficial: oficial, aulas: aulas},

		success: function(){
			$.ajax({
				url: '/pendiente/'+$('#pendientes').attr('data'),
				headers: {'X-CSRF-TOKEN': token},
				type: 'PUT',
				dataType: 'json',
				data: {nombre: $('#pendientes').val()},
				success: function(){
					actualizarOldMotivos();
					actualizarNewMotivos();
					listar();
					$('#myModal').modal('toggle');
					$('#msj-success').fadeIn();
					window.setTimeout(function(){$('#msj-success').fadeOut();}, 2000);
				}
			});
		}
	});
});

function actualizarOldMotivos(){
	$.get('detalle/byVisita/'+$('#id').val(), function(res){
		if (res.length == $('.motOld').length){
			var oldMots = $('.motOld');
			$(res).each(function(key, value){
				oldMots.each(function(key2, index){
					if (value.id == index.getAttribute('datadet')) {
						$.ajax({
							url: '/detalle/'+index.getAttribute('datadet')+'',
							headers: {'X-CSRF-TOKEN': $('#token').val()},
							type: 'PUT',
							dataType: 'json',
							data: {horas: $('#newHora'+index.getAttribute('data')).val()},
							success: function(){
								console.log(index.getAttribute('datadet')+' actualizado');
							}
						});
					}
				});
			});		
		}else if($('.motOld').length > 0){
			var oldMots = $('.motOld');
			$(res).each(function(key, value){
				var cant = 0;
				oldMots.each(function(key2, index){
					if (value.id == index.getAttribute('datadet')) {
						$.ajax({
							url: '/detalle/'+index.getAttribute('datadet')+'',
							headers: {'X-CSRF-TOKEN': $('#token').val()},
							type: 'PUT',
							dataType: 'json',
							data: {horas: $('#newHora'+index.getAttribute('data')).val()},
							success: function(){
								console.log(index.getAttribute('datadet')+' actualizado');
							}
						});
						cant++;
					}
				});
				if (cant == 0) {
					$.ajax({
						url: '/detalle/'+value.id,
						headers: {'X-CSRF-TOKEN': $('#token').val()},
						type: 'DELETE',
						dataType: 'json',
						success: function(){
							console.log(value.id+' eliminado');
						}
					});
				}
			});
		}
	});
}
function actualizarNewMotivos(){
	if ($('.motNew').length > 0) {
		var newMots = $('.motNew');
		newMots.each(function(key, index){
			$.ajax({
				url: '/detalle',
				headers: {'X-CSRF-TOKEN': $('#token').val()},
				type: 'POST',
				dataType: 'json',
				data: {id_visita: $('#id').val(), id_motivo: index.getAttribute('data'), horas: $('#newHora'+index.getAttribute('data')).val()},
				success: function(){
					console.log(index.getAttribute('data')+' agregado')
				}
				
			});
		});
	}
}

$('#fecha').on('input', function(){
	if ($('#fecha').attr('dataDate') < $('#fecha').val()) {
		$('#fecha').val('');
	}
});
$('#noPend').on('click', function(){
	if ($('#noPend').is(':checked')) {
		$('#pendientes').removeAttr('disabled');
	}else{
		$('#pendientes').attr('disabled', '');
		$('#pendientes').val('');
	}
})
/******************************************/
$('#select-esc').on('click', function(){
	$('#filtrar').html('Escuela');
	$('#search-esc').removeClass('hide');
	$('#search-ofc').addClass('hide');
	$('#search-fec').addClass('hide');
	$('#search-are').addClass('hide');
});
$('#select-ofc').on('click', function(){
	$('#filtrar').html('Oficial');
	$('#search-ofc').removeClass('hide');
	$('#search-esc').addClass('hide');
	$('#search-fec').addClass('hide');
	$('#search-are').addClass('hide');
});
$('#select-fec').on('click', function(){
	$('#filtrar').html('Fecha');
	$('#search-fec').removeClass('hide');
	$('#search-esc').addClass('hide');
	$('#search-ofc').addClass('hide');
	$('#search-are').addClass('hide');
});
$('#select-are').on('click', function(){
	$('#filtrar').html('Area');
	$('#search-are').removeClass('hide');
	$('#search-fec').addClass('hide');
	$('#search-esc').addClass('hide');
	$('#search-ofc').addClass('hide');
});
function cambiarFiltro(btn){
	$('#label-ofc').html(btn.text);
	$('#label-ofc').attr('data', btn.getAttribute('data'));
}
function cambiarFiltroA(btn){
	$('#label-are').html(btn.text);
	$('#label-are').attr('data', btn.getAttribute('data'));
}
$('#search').on('click', function(){
	if ($('#filtrar').html() == 'Escuela') {
		if ($('#search-esc').val()!="") {
			$('#datos').empty();
			$.get('visitas/listingEsc/'+$('#search-esc').val(), function(res){
				$(res).each(function(key, value){
					if ($('#metadata').attr('data')=='user') {
						$('#datos').append('<tr><td>'+value.fecha+'</td><td>'+value.oficial+'</td><td>'+value.escuela+'</td>'+
							'<td><button dep="'+value.dep+'"" aulas="'+value.aulas+'" value='+value.id+' OnClick="mostrarDet(this);" class="btn btn-primary" data-toggle="modal" data-target="#modalDet"><i class="fa fa-list-ol fa-fw"></i> Detalles</button></td></tr>');
					}else{
						$('#datos').append('<tr><td>'+value.fecha+'</td><td>'+value.oficial+'</td><td>'+value.escuela+'</td>'+
							'<td><button dep="'+value.dep+'"" aulas="'+value.aulas+'" value='+value.id+' OnClick="mostrarDet(this);" class="btn btn-primary" data-toggle="modal" data-target="#modalDet"><i class="fa fa-list-ol fa-fw"></i> Detalles</button> '+
							'<button value='+value.id+' OnClick="mostrar(this);" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Editar</button> '+
							'<button value='+value.id+' OnClick="mostrarDanger(this);" class="btn btn-danger" data-toggle="modal" data-target="#modalRemove">Eliminar</button></td></tr>');
					}
				})
			});
		}else{
			listar();
		}
	}else if ($('#filtrar').html() == 'Oficial'){
		$('#datos').empty();
		$.get('visitas/listingOfi/'+$('#label-ofc').attr('data'), function(res){
			$(res).each(function(key, value){
				if ($('#metadata').attr('data')=='user') {
					$('#datos').append('<tr><td>'+value.fecha+'</td><td>'+value.oficial+'</td><td>'+value.escuela+'</td>'+
						'<td><button dep="'+value.dep+'"" aulas="'+value.aulas+'" value='+value.id+' OnClick="mostrarDet(this);" class="btn btn-primary" data-toggle="modal" data-target="#modalDet"><i class="fa fa-list-ol fa-fw"></i> Detalles</button></td></tr>');
				}else{
					$('#datos').append('<tr><td>'+value.fecha+'</td><td>'+value.oficial+'</td><td>'+value.escuela+'</td>'+
						'<td><button dep="'+value.dep+'"" aulas="'+value.aulas+'" value='+value.id+' OnClick="mostrarDet(this);" class="btn btn-primary" data-toggle="modal" data-target="#modalDet"><i class="fa fa-list-ol fa-fw"></i> Detalles</button> '+
						'<button value='+value.id+' OnClick="mostrar(this);" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Editar</button> '+
						'<button value='+value.id+' OnClick="mostrarDanger(this);" class="btn btn-danger" data-toggle="modal" data-target="#modalRemove">Eliminar</button></td></tr>');
				}
			})
		});
	}else if ($('#filtrar').html() == 'Fecha'){
		$('#datos').empty();
		$.get('visitas/listingDate/'+$('#search-fec').val(), function(res){
			$(res).each(function(key, value){
				if ($('#metadata').attr('data')=='user') {
					$('#datos').append('<tr><td>'+value.fecha+'</td><td>'+value.oficial+'</td><td>'+value.escuela+'</td>'+
						'<td><button dep="'+value.dep+'"" aulas="'+value.aulas+'" value='+value.id+' OnClick="mostrarDet(this);" class="btn btn-primary" data-toggle="modal" data-target="#modalDet"><i class="fa fa-list-ol fa-fw"></i> Detalles</button></td></tr>');
				}else{
					$('#datos').append('<tr><td>'+value.fecha+'</td><td>'+value.oficial+'</td><td>'+value.escuela+'</td>'+
						'<td><button dep="'+value.dep+'"" aulas="'+value.aulas+'" value='+value.id+' OnClick="mostrarDet(this);" class="btn btn-primary" data-toggle="modal" data-target="#modalDet"><i class="fa fa-list-ol fa-fw"></i> Detalles</button> '+
						'<button value='+value.id+' OnClick="mostrar(this);" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Editar</button> '+
						'<button value='+value.id+' OnClick="mostrarDanger(this);" class="btn btn-danger" data-toggle="modal" data-target="#modalRemove">Eliminar</button></td></tr>');
				}
			})
		});
	}else {
		$('#datos').empty();
		$.get('visitas/listingArea/'+$('#label-are').attr('data'), function(res){
			$(res).each(function(key, value){
				if ($('#metadata').attr('data')=='user') {
					$('#datos').append('<tr><td>'+value.fecha+'</td><td>'+value.oficial+'</td><td>'+value.escuela+'</td>'+
						'<td><button dep="'+value.dep+'"" aulas="'+value.aulas+'" value='+value.id+' OnClick="mostrarDet(this);" class="btn btn-primary" data-toggle="modal" data-target="#modalDet"><i class="fa fa-list-ol fa-fw"></i> Detalles</button></td></tr>');
				}else{
					$('#datos').append('<tr><td>'+value.fecha+'</td><td>'+value.oficial+'</td><td>'+value.escuela+'</td>'+
						'<td><button dep="'+value.dep+'"" aulas="'+value.aulas+'" value='+value.id+' OnClick="mostrarDet(this);" class="btn btn-primary" data-toggle="modal" data-target="#modalDet"><i class="fa fa-list-ol fa-fw"></i> Detalles</button> '+
						'<button value='+value.id+' OnClick="mostrar(this);" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Editar</button> '+
						'<button value='+value.id+' OnClick="mostrarDanger(this);" class="btn btn-danger" data-toggle="modal" data-target="#modalRemove">Eliminar</button></td></tr>');
				}
			})
		});
	}
});