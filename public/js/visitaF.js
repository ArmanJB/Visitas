var escuelas = null;
var oficiales = null;
var voluntarios = null;
var motivos = null;

$(function(){
	$(".select2").select2();
	$(".timepicker").timepicker({showMeridian: false, showInputs: false, defaultTime: '00:00'});
	setAreas();
	setDepartamentos();
	getEscuelas();
	getOficial();
	getVoluntario();
	getMotivo();
});

function setAreas(){
	$('#area').empty();
	$.get('/areas', function(res){
		$('#area').append('<option value="placeholder">Selecciona un área</option>');
		$(res).each(function(key, value){
			$('#area').append('<option value="'+value.id+'">'+value.nombre+'</option>');
		});
		//Admin
		setTimeout(function(){
			if ($('#user_type').attr('value') != 1) {
				$('#area').val($('#user_area').attr('value')).trigger('change');
				$('#area').attr('disabled', true);
				$('#oficial').val($('#user_oficial').attr('value')).trigger('change');
				$('#oficial').attr('disabled', true);
			}
		}, 3000);
	});
}
function setDepartamentos(){
	$('#departamento').empty();
	$.get('/departamentos', function(res){
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
		$('#escuela').append('<option value="placeholder">Selecciona un departamento antes..</option>');
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
function getOficial(){
	$.get('/oficials', function(res){
		oficiales = res;
	});
	setOficial('placeholder');
}
$('#area').on('change', function(){
	if ($('#area').val()=='placeholder') {
		$('#oficial').empty();
		$('#oficial').append('<option value="placeholder">Selecciona un área antes..</option>');
	}else if($('#viewAll').is(':not(:checked)')){
		$('#view_group').fadeIn();
		$('#footer1').fadeIn();
	}
	setOficial($('#area').val());
	setMotivo($('#area').val());
});
function setOficial(id){
	if (id != 'placeholder') {
		$('#oficial').empty();
		$('#oficial').append('<option value="placeholder">Selecciona un oficial</option>');
		$(oficiales).each(function(key, value){
			if (value.id_area == id) {
				$('#oficial').append('<option value="'+value.id+'">'+value.nombres+' '+value.apellidos+'</option>');
			}
		});
	}
}
function getVoluntario(){
	$.get('/voluntarios', function(res){
		voluntarios = res;
		setVoluntario();
	});
}
function setVoluntario(){
	$('#group-voluntario-1').empty();
	$('#group-voluntario-2').empty();
	$(voluntarios).each(function(key, value){
		if ((key%2)==0) {
			$('#group-voluntario-1').append('<div class="input-group">'+
													'<input type="checkbox" class="filled-in" id="vln'+value.id+'" value="'+value.id+'"/>'+
													'<label for="vln'+value.id+'" value="'+value.id+'" OnClick="setHoraVln(this);">'+value.nombres+' '+value.apellidos+'</label>'+
													'<div class="bootstrap-timepicker"><input type="text" class="form-control timepicker" id="time'+value.id+'" disabled style="width:70px;">'+
											'</div></div>');
		}else{
			$('#group-voluntario-2').append('<div class="input-group">'+
													'<input type="checkbox" class="filled-in" id="vln'+value.id+'" value="'+value.id+'"/>'+
													'<label for="vln'+value.id+'" value="'+value.id+'" OnClick="setHoraVln(this);">'+value.nombres+' '+value.apellidos+'</label>'+
													'<div class="bootstrap-timepicker"><input type="text" class="form-control timepicker" id="time'+value.id+'" disabled style="width:70px;">'+
											'</div></div>');
		}
	});
	$(".timepicker").timepicker({showMeridian: false, showInputs: false, defaultTime: '00:00'});
}
function setHoraVln(btn){
	if ($('#vln'+btn.getAttribute('value')).is(':checked')) {
		$('#time'+btn.getAttribute('value')).attr('disabled', true);
		$('#time'+btn.getAttribute('value')).val('00:00');
	}else{
		$('#time'+btn.getAttribute('value')).removeAttr('disabled');
	}
}
//
function getMotivo(){
	$.get('/motivos', function(res){
		motivos = res;
		setMotivo('placeholder');
	});
}
function setMotivo(id){
	$('#group-motivos-1').empty();
	$('#group-motivos-2').empty();
	if (id != 'placeholder') {
		$(motivos).each(function(key, value){
			if ((value.id_area)==id) {
				$('#group-motivos-1').append('<div class="input-group">'+
													'<input type="checkbox" class="filled-in" id="mtv'+value.id+'" value="'+value.id+'"/>'+
													'<label for="mtv'+value.id+'" value="'+value.id+'" OnClick="setHoraMtv(this);">'+value.nombre+'</label>'+
													'<div class="bootstrap-timepicker"><input type="text" class="form-control timepicker" id="timeM'+value.id+'" disabled style="width:70px;">'+
												'</div></div');
			}else if ((value.id_area)==1){
				$('#group-motivos-2').append('<div class="input-group">'+
													'<input type="checkbox" class="filled-in" id="mtv'+value.id+'" value="'+value.id+'"/>'+
													'<label for="mtv'+value.id+'" value="'+value.id+'" OnClick="setHoraMtv(this);">'+value.nombre+'</label>'+
													'<div class="bootstrap-timepicker"><input type="text" class="form-control timepicker" id="timeM'+value.id+'" disabled style="width:70px;">'+
												'</div></div');
			}
		});
		$(".timepicker").timepicker({showMeridian: false, showInputs: false, defaultTime: '00:00'});
	}
}
function setHoraMtv(btn){
	if ($('#mtv'+btn.getAttribute('value')).is(':checked')) {
		$('#timeM'+btn.getAttribute('value')).attr('disabled', true);
		$('#timeM'+btn.getAttribute('value')).val('00:00');
	}else{
		$('#timeM'+btn.getAttribute('value')).removeAttr('disabled');
	}
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
	
	var vlts = []; 
	var vltsTime = [];
	$('#group-voluntario-1 div input:checkbox:checked').each(function(index){
		vlts.push(this.value);
		vltsTime.push($('#time'+this.value).val());
	});
	$('#group-voluntario-2 div input:checkbox:checked').each(function(index){
		vlts.push(this.value);
		vltsTime.push($('#time'+this.value).val());
	});

	var mtvs = []; 
	var mtvsTime = [];
	$('#group-motivos-1 div input:checkbox:checked').each(function(index){
		mtvs.push(this.value);
		mtvsTime.push($('#timeM'+this.value).val());
	});
	$('#group-motivos-2 div input:checkbox:checked').each(function(index){
		mtvs.push(this.value);
		mtvsTime.push($('#timeM'+this.value).val());
	});
	console.log({fecha: $('#fecha').val(), id_escuela: $('#escuela').val(), id_oficial: $('#oficial').val(),
				aulas: $('#aulas').val(), viaticos: $('#viaticos').val(), 
				pendientes: $('#pendientes').val(), observaciones: $('#observaciones').val(),
				voluntarios: vlts, voluntariosTime: vltsTime, motivos: mtvs, motivosTime: mtvsTime})
	$.ajax({
		url: '/visita',
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		type: 'POST',
		dataType: 'json',
		data: {fecha: $('#fecha').val(), id_escuela: $('#escuela').val(), id_oficial: $('#oficial').val(),
				aulas: $('#aulas').val(), viaticos: $('#viaticos').val(), 
				pendientes: $('#pendientes').val(), observaciones: $('#observaciones').val(),
				voluntarios: vlts, voluntariosTime: vltsTime, motivos: mtvs, motivosTime: mtvsTime},

		success: function(resp){
			$('#fecha').val('');
			$('#area').val('placeholder').trigger('change');
			$('#departamento').val('placeholder').trigger('change');
			$('#oficial').val('placeholder').trigger('change');
			$('#aulas').val('');
			$('#viaticos').val('');
			$('#pendientes').val('');
			$('#observaciones').val('');
			setVoluntario();
			//
			setTimeout(function(){
				if ($('#user_type').attr('value') != 1) {
					$('#area').val($('#user_area').attr('value')).trigger('change');
					$('#area').attr('disabled', true);
					$('#oficial').val($('#user_oficial').attr('value')).trigger('change');
					$('#oficial').attr('disabled', true);
				}
			}, 1000);
			//
			$('#msjcreate').removeClass('alert-danger');
			$('#msjcreate').addClass('alert-success');
			$('#msjcreate'+'-text').html('Registro agregado exitosamente!');
			$('#msjcreate').fadeIn();
			window.setTimeout(function(){$('#msjcreate').fadeOut();}, 2000);
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

	if ($('#fecha').attr('dataDate') < $('#fecha').val() || $('#fecha').val() == '') {
		$('#fecha').parents('.form-group').addClass('has-error');
		cantE++;
	}
	if ($('#area').val() == 'placeholder') {
		$('#area').parents('.form-group').addClass('has-error');
		cantE++;
	}
	if ($('#escuela').val() == 'placeholder') {
		$('#escuela').parents('.form-group').addClass('has-error');
		cantE++;
	}
	if ($('#oficial').val() == 'placeholder') {
		$('#oficial').parents('.form-group').addClass('has-error');
		cantE++;
	}
	if (isNaN($('#aulas').val()) || $('#aulas').val()=='') {
		$('#aulas').parents('.form-group').addClass('has-error');
		cantE++;
	}
	if (isNaN($('#viaticos').val()) || $('#viaticos').val()=='') {
		$('#viaticos').parents('.form-group').addClass('has-error');
		cantE++;
	}
	var volCont = 0;
	$('#group-voluntario-1').find('.timepicker').each(function(){
		if ($(this).val()=='' || $(this).val()=='00:00') {
			volCont++;
		}
	});
	$('#group-voluntario-2').find('.timepicker').each(function(){
		if ($(this).val()=='' || $(this).val()=='00:00') {
			volCont++;
		}
	});
	var check = $('#group-voluntario-1 div input:checkbox:not(:checked)').length + $('#group-voluntario-2 div input:checkbox:not(:checked)').length;
	if (check != 0 && volCont != check) {
		$('#group-voluntario-1').parents('.form-group').addClass('has-error');
		cantE++;
	}
	//
	volCont = 0;
	$('#group-motivos-1').find('.timepicker').each(function(){
		if ($(this).val()=='' || $(this).val()=='00:00') {
			volCont++;
		}
	});
	$('#group-motivos-2').find('.timepicker').each(function(){
		if ($(this).val()=='' || $(this).val()=='00:00') {
			volCont++;
		}
	});
	check = $('#group-motivos-1 div input:checkbox:not(:checked)').length + $('#group-motivos-2 div input:checkbox:not(:checked)').length;
	if ($('#group-motivos-1 div input:checkbox:checked').length == 0 && $('#group-motivos-2 div input:checkbox:checked').length == 0) {
		$('#group-motivos-1').parents('.form-group').addClass('has-error');
		cantE++;
	}
	if (check != 0 && volCont != check) {
		$('#group-motivos-1').parents('.form-group').addClass('has-error');
		cantE++;
	}
	

	return cantE;
}





















/********************Slides**********************/
$('#viewAll').on('change', function(){
	if ($('#viewAll').is(':checked')) {
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
	}else{
		$('#header1').fadeOut();
		$('#header2').fadeOut();
		$('#header3').fadeOut();
		$('#footer1').fadeIn();
		$('#footer2').fadeIn();
		$('#footer3').fadeIn();
		//$('#section1').fadeOut();
		$('#section2').slideUp();
		$('#section3').slideUp();
		$('#section4').slideUp();
	}
});

$('#sig1').on('click', function(){
	$('#section1').slideUp();
	$('#header1').slideDown();
	$('#section2').slideDown();
	$('#footer2').slideDown();
});
$('#sig2').on('click', function(){
	$('#section2').slideUp();
	$('#header2').slideDown();
	$('#section3').slideDown();
	$('#footer3').slideDown();
});
$('#sig3').on('click', function(){
	$('#section3').slideUp();
	$('#header3').slideDown();
	$('#section4').slideDown();
});

$('#ant1').on('click', function(){
	$('#section2').slideUp();
	$('#section1').slideDown();
	$('#footer1').slideDown();
});
$('#ant2').on('click', function(){
	$('#section3').slideUp();
	$('#header1').slideDown();
	$('#section2').slideDown();
	$('#footer2').slideDown();
});
$('#ant3').on('click', function(){
	$('#section4').slideUp();
	$('#header2').slideDown();
	$('#section3').slideDown();
	$('#footer3').slideDown();
});
/**************************************************/