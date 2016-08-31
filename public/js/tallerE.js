var oficiales = null;
var contenidos = null;
var audiencias = null;
var escuelas = null;
var infoTaller = null; //var importante

$(function(){
	$(".select2").select2();
	$(".timepicker").timepicker({showMeridian: false, showInputs: false, defaultTime: '01:00'});
	
	$('#header1').fadeOut();
	$('#header2').fadeOut();
	$('#header3').fadeOut();
	$('#footer1').fadeOut();
	$('#footer2').fadeOut();
	$('#footer3').fadeOut();
	$('#section1').slideDown();
	$('#section2').slideDown();
	$('#section3').slideDown();
	$('#section4').slideDown();
	$('#registrar').html('Finalizar edición')

	setDepartamento();
	setInternacional();
	setZona();
	setLugar();
	setActividad();
	getEscuelas();
	getOficial();
	getContenido();
	getAudiencia();

	setInfoTaller();
});

function setLugar(){
	$.get('/lugars', function(res){
		$('#lugares').empty();
		$('#lugares').append('<option value="placeholder">Selecciona un lugar</option>');
		$(res).each(function(key, value){
			$('#lugares').append('<option value="'+value.id+'">'+value.nombre+'</option>');
		});
	});
}
function setActividad(){
	$.get('/actividads', function(res){
		$('#actividades').empty();
		$('#actividades').append('<option value="placeholder">Selecciona una actividad</option>');
		$(res).each(function(key, value){
			$('#actividades').append('<option value="'+value.id+'">'+value.nombre+'</option>');
		});
	});
}
function getOficial(){
	$.get('/oficial/byArea/3', function(res){
		oficiales = res;
		setOficial();
	});
}
function setOficial(){
	$('#group-oficial-1').empty();
	$('#group-oficial-2').empty();
	//$.get('/oficials', function(res){
		$(oficiales).each(function(key, value){
			if ((key%2)==0) {
				$('#group-oficial-1').append('<div><input type="checkbox" class="filled-in" id="ofc'+value.id+'" value="'+value.id+
					'"/><label for="ofc'+value.id+'" style="color:black;">'+value.nombres+' '+value.apellidos+'</label></div>');
			}else{
				$('#group-oficial-2').append('<div><input type="checkbox" class="filled-in" id="ofc'+value.id+'" value="'+value.id+
					'"/><label for="ofc'+value.id+'" style="color:black;">'+value.nombres+' '+value.apellidos+'</label></div>');
			}
		});
	//});
}
function getContenido(){
	$.get('/contenidos', function(res){
		contenidos = res;
		setContenido();
	});
}
function setContenido(){
	$('#group-contenido').empty();
	//$.get('/contenidos', function(res){
		$(contenidos).each(function(key, value){
			$('#group-contenido').append('<div><input type="checkbox" class="filled-in" id="cnt'+value.id+'" value="'+value.id+
					'"/><label for="cnt'+value.id+'" style="color:black;">'+value.nombre+'</label></div>');
		});
	//});
}
function getAudiencia(){
	$.get('/audiencias',function(res){
		audiencias = res;
		setAudiencia();
	});
}
function setAudiencia(){
	$('#group-audiencia').empty();
	//$.get('/audiencias', function(res){
		$(audiencias).each(function(key, value){
			$('#group-audiencia').append('<div><input type="checkbox" class="filled-in" id="adc'+value.id+'" value="'+value.id+
					'"/><label for="adc'+value.id+'" style="color:black;">'+value.nombre+'</label></div>');
		});
	//});
}
function setDepartamento(){
	$.get('/departamentos', function(res){
		$('#departamento').empty();
		$('#departamento').append('<option value="placeholder">Selecciona un departamento</option>');
		$(res).each(function(key, value){
			$('#departamento').append('<option value="'+value.id+'">'+value.nombre+'</option>');
		});
	});
}
function getEscuelas(){
	$.get('/escuelas', function(res){
		escuelas = res;
	});
	setEscuelas('placeholder');
}
$('#departamento').on('change', function(){
	if ($('#departamento').val()=='placeholder') {
		$('#escuela').empty();
		$('#escuela').append('<option value="placeholder">Selecciona una departamento antes..</option>');
	}
	setEscuelas($('#departamento').val());
});
function setEscuelas(id){
	if (id!='placeholder') {
		$('#escuela').empty();
		$('#escuela').append('<option value="placeholder">Selecciona una escuela</option>');
		$(escuelas).each(function(key, value){
			if (value.idDep == id) {
				$('#escuela').append('<option value="'+value.id+'">'+value.nombre+'</option>');
			}
		});
	}
}
function setInternacional(){
	$.get('/internacionals', function(res){
		$('#internacional').empty();
		$('#internacional').append('<option value="placeholder">Selecciona un país</option>');
		$(res).each(function(key, value){
			$('#internacional').append('<option value="'+value.id+'">'+value.nombre+'</option>');
		});
	});
}
function setZona(){
	$.get('/zonareceptoras', function(res){
		$('#zona').empty();
		$('#zona').append('<option value="placeholder">Selecciona una zona de atención</option>');
		$(res).each(function(key, value){
			$('#zona').append('<option value="'+value.id+'">'+value.nombre+'</option>');
		});
	});
}



$('#remove-detalles').on('click', function(){
	$('#detalles').empty();
});
$('#cant_mujeres, #cant_hombres').on('input', function(){
	if ( !(isNaN($('#cant_mujeres').val())) && !(isNaN($('#cant_hombres').val())) ) {
		var tot = parseInt($('#cant_mujeres').val()) + parseInt($('#cant_hombres').val());
		if (isNaN(tot)) {
			$('#total').val('');
		}else{
			$('#total').val(tot);
		}
	}
});
$('#addEscuela').on('click', function(){
	if ($('#escuela').val()!='placeholder') {
		$('#detalles').append('<li class="list-group-item" data="id_escuela" value="'+
			$('#escuela').val()+'">Escuela <i class="fa fa-long-arrow-right"></i> '+
			$("#escuela option:selected").text()+'</li>');
	}
});
$('#addInternacional').on('click', function(){
	if ($('#internacional').val()!='placeholder') {
		$('#detalles').append('<li class="list-group-item" data="id_internacional" value="'+
			$('#internacional').val()+'">Internacional <i class="fa fa-long-arrow-right"></i> '+
			$("#internacional option:selected").text()+'</li>');
	}
});
$('#addZona').on('click', function(){
	if ($('#zona').val()!='placeholder') {
		$('#detalles').append('<li class="list-group-item" data="id_zona" value="'+
			$('#zona').val()+'">'+$("#zona option:selected").text()+'</li>');
	}
});

function setInfoTaller(){
	$.get('/taller/infoTaller/'+$('#idv').val(), function(res){
		infoTaller = res;
		setTimeout(function(){
			$('#fecha').val(infoTaller.taller[0].fecha);
			$('#duracion').val(infoTaller.taller[0].duracion);
			$('#lugares').val(infoTaller.taller[0].id_lugar).trigger('change');
			$('#actividades').val(infoTaller.taller[0].id_actividad).trigger('change');
			$('#cant_mujeres').val(infoTaller.taller[0].cant_mujeres);
			$('#cant_hombres').val(infoTaller.taller[0].cant_hombres);
			$('#total').val(parseInt(infoTaller.taller[0].cant_mujeres)+parseInt(infoTaller.taller[0].cant_hombres));
			$('#viaticos').val(infoTaller.taller[0].viaticos);
			$('#observaciones').val(infoTaller.taller[0].observaciones);
			//
			$(infoTaller.oficiales).each(function(key, value){
				$('#ofc'+value.id_oficial).prop('checked', true);
			});
			$(infoTaller.contenidos).each(function(key, value){
				$('#cnt'+value.id_contenido).prop('checked', true);
			});
			$(infoTaller.audiencias).each(function(key, value){
				$('#adc'+value.id_audiencia).prop('checked', true);
			});
			$(infoTaller.detalles).each(function(key, value){
				if (value.id_escuela != null) {
					$('#detalles').append('<li class="list-group-item" data="id_escuela" value="'+
							value.id_escuela+'">Escuela <i class="fa fa-long-arrow-right"></i> '+
							value.escuela+'</li>');
				}else if (value.id_internacional != null) {
					$('#detalles').append('<li class="list-group-item" data="id_internacional" value="'+
							value.id_internacional+'">Internacional <i class="fa fa-long-arrow-right"></i> '+
							value.internacional+'</li>');
				}else if (value.id_zona != null) {
					$('#detalles').append('<li class="list-group-item" data="id_zona" value="'+
							value.id_zona+'">'+value.zona+'</li>');
				}
			});
		}, 1000);
	});
}

$('#registrar').on('click', function(){
	$('#box-parent').find('.has-error').each(function(){
		$(this).removeClass('has-error');
	});

	if (validar() > 0) {
		$('#msjcreate').removeClass('alert-success');
		$('#msjcreate').addClass('alert-danger');
		$('#msjcreate'+'-text').html('Faltan campos obligatorios por completar!');
		$('#viewAll').prop('checked', true);
		$('#viewAll').trigger('change');
		$('#msjcreate').fadeIn();
		window.setTimeout(function(){$('#msjcreate').fadeOut();}, 2000);
		return;
	}

	// oficiales actualizados
	var aux = [];
	$('#group-oficial-1 div input:checkbox:checked').each(function(index){
		aux.push(this.value);
	});
	$('#group-oficial-2 div input:checkbox:checked').each(function(index){
		aux.push(this.value);
	});

	var ofcsReg = [];
	var ofcs = [];
	var ofcsStatus = [];

	$(infoTaller.oficiales).each(function(key, value){
		var val = false;
		aux.forEach(function(item, index){
			 if (value.id_oficial == item) {
			 	ofcsReg.push(value.id);
			 	ofcs.push(item);
			 	ofcsStatus.push('m');
			 	//
			 	aux[index] = 0;
			 	val = true;
			 }
		});
		if (val == false) {
			ofcsReg.push(value.id);
		 	ofcs.push(0);
		 	ofcsStatus.push('d');
		}
	});
	aux.forEach(function(item, index){
		if (item != 0) {
			ofcsReg.push(0);
		 	ofcs.push(item);
		 	ofcsStatus.push('n');
		}
	});
	// contenidos actualizados
	aux = [];
	$('#group-contenido div input:checkbox:checked').each(function(index){
		aux.push(this.value);
	});

	var cntsReg = [];
	var cnts = [];
	var cntsStatus = [];

	$(infoTaller.contenidos).each(function(key, value){
		var val = false;
		aux.forEach(function(item, index){
			 if (value.id_contenido == item) {
			 	cntsReg.push(value.id);
			 	cnts.push(item);
			 	cntsStatus.push('m');
			 	//
			 	aux[index] = 0;
			 	val = true;
			 }
		});
		if (val == false) {
			cntsReg.push(value.id);
		 	cnts.push(0);
		 	cntsStatus.push('d');
		}
	});
	aux.forEach(function(item, index){
		if (item != 0) {
			cntsReg.push(0);
		 	cnts.push(item);
		 	cntsStatus.push('n');
		}
	});
	// audiencias actualizadas
	aux = [];
	$('#group-audiencia div input:checkbox:checked').each(function(index){
		aux.push(this.value);
	});

	var adcsReg = [];
	var adcs = [];
	var adcsStatus = [];

	$(infoTaller.audiencias).each(function(key, value){
		var val = false;
		aux.forEach(function(item, index){
			 if (value.id_audiencia == item) {
			 	adcsReg.push(value.id);
			 	adcs.push(item);
			 	adcsStatus.push('m');
			 	//
			 	aux[index] = 0;
			 	val = true;
			 }
		});
		if (val == false) {
			adcsReg.push(value.id);
		 	adcs.push(0);
		 	adcsStatus.push('d');
		}
	});
	aux.forEach(function(item, index){
		if (item != 0) {
			adcsReg.push(0);
		 	adcs.push(item);
		 	adcsStatus.push('n');
		}
	});
	// detalles actualizados
	var detJson = [];
	$(infoTaller.detalles).each(function(key, value){
		if (value.id_escuela != null) {
			detJson.push({id: value.id, data: 'id_escuela', id_det: value.id_escuela});
		}else if (value.id_internacional != null) {
			detJson.push({id: value.id, data: 'id_internacional', id_det: value.id_internacional});
		}else if (value.id_zona != null) {
			detJson.push({id: value.id, data: 'id_zona', id_det: value.id_zona});
		}
	});

	aux = [];
	auxData = [];
	$('#detalles li').each(function(index){
		aux.push(this.value);
		auxData.push($(this).attr('data'));
	});

	var detsReg = [];
	var dets = [];
	var detsData = [];
	var detsStatus = [];

	$(detJson).each(function(key, value){
		var val = false;
		aux.forEach(function(item, index){
			if (value.id_det == item) {
				detsReg.push(value.id);
				dets.push(item);
				detsData.push(value.data);
				detsStatus.push('m');
				//
				aux[index] = 0;
				auxData[index] = 0;
				val = true;
			}
		});
		if (val == false) {
			detsReg.push(value.id);
			dets.push(0);
			detsData.push(0);
			detsStatus.push('d');
		}
	});
	aux.forEach(function(item, index){
		if (item != 0) {
			detsReg.push(0);
			dets.push(item);
			detsData.push(auxData[index]);
			detsStatus.push('n');
		}
	});

	$.ajax({
		url: '/taller/'+$('#idv').val(),
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		type: 'PUT',
		dataType: 'json',
		data: {fecha: $('#fecha').val(), duracion: $('#duracion').val(), 
				cant_mujeres: $('#cant_mujeres').val(), cant_hombres: $('#cant_hombres').val(), 
				observaciones: $('#observaciones').val(), id_lugar: $('#lugares').val(), 
				id_actividad: $('#actividades').val(), viaticos: $('#viaticos').val(),
				oficialesReg: ofcsReg, oficiales: ofcs, oficialesStatus: ofcsStatus, 
				contenidosReg: cntsReg, contenidos: cnts, contenidosStatus: cntsStatus, 
				audienciasReg: adcsReg, audiencias: adcs, audienciasStatus: adcsStatus,
				detallesReg: detsReg, detalles: dets, detallesData: detsData, detallesStatus: detsStatus
				},

		success: function(resp){
			$('#msjcreate').removeClass('alert-danger');
			$('#msjcreate').addClass('alert-success');
			$('#msjcreate'+'-text').html('Registro actualizado exitosamente!');
			$('#msjcreate').fadeIn();
			window.setTimeout(function(){$('#msjcreate').fadeOut();location.href='/taller'}, 2000);
		},
		error:function(msj){
			$('#msjcreate').removeClass('alert-success');
			$('#msjcreate').addClass('alert-danger');
			$('#msjcreate'+'-text').html(msj.responseJSON.observaciones);
			$('#msjcreate').fadeIn();
			window.setTimeout(function(){$('#msjcreate').fadeOut();}, 2000);
		}
	});
});


function validar(){
	var cantE = 0;
	if ($('#fecha').attr('dataDate') < $('#fecha').val()) {
		$('#fecha').parents('.form-group').addClass('has-error');
		cantE++;
	}
	if ($('#lugares').val() == 'placeholder') {
		$('#lugares').parents('.form-group').addClass('has-error');
		cantE++;
	}
	if ($('#actividades').val() == 'placeholder') {
		$('#actividades').parents('.form-group').addClass('has-error');
		cantE++;
	}
	if (isNaN($('#cant_mujeres').val()) || $('#cant_mujeres').val()=='') {
		$('#cant_mujeres').parents('.form-group').addClass('has-error');
		cantE++;
	}
	if (isNaN($('#cant_hombres').val()) || $('#cant_hombres').val()=='') {
		$('#cant_hombres').parents('.form-group').addClass('has-error');
		cantE++;
	}
	if (isNaN($('#viaticos').val()) || $('#viaticos').val()=='') {
		$('#viaticos').parents('.form-group').addClass('has-error');
		cantE++;
	}
	if ($('#group-oficial-1 div input:checkbox:checked').length==0 && $('#group-oficial-2 div input:checkbox:checked').length==0) {
		$('#group-oficial-1').parents('.form-group').addClass('has-error');
		cantE++;
	}
	if ($('#group-contenido div input:checkbox:checked').length==0 ) {
		$('#group-contenido').parents('.form-group').addClass('has-error');
		cantE++;
	}
	if ($('#group-audiencia div input:checkbox:checked').length==0 ) {
		$('#group-audiencia').parents('.form-group').addClass('has-error');
		cantE++;
	}
	if ($('#detalles').find('li').length == 0 ) {
		$('#detalles').parents('.form-group').addClass('has-error');
		cantE++;
	}
	

	return cantE;
}