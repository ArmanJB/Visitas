var escuelas = null;
var oficiales = null;
var voluntarios = null;
var motivos = null;
var infoVisita = null; //var importante

$(function(){
	$(".select2").select2();
	$(".timepicker").timepicker({showMeridian: false, showInputs: false, defaultTime: '00:00'});

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

	setAreas();
	setDepartamentos();
	getEscuelas();
	getOficial();
	getVoluntario();
	getMotivo();

	setInfoVisita();
});

function setAreas(){
	$('#area').empty();
	$.get('/areas', function(res){
		$('#area').append('<option value="placeholder">Selecciona un área</option>');
		$(res).each(function(key, value){
			$('#area').append('<option value="'+value.id+'">'+value.nombre+'</option>');
		});
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

function setInfoVisita(){
	$.get('/visita/infoVisita/'+$('#idv').val(), function(res){
		infoVisita = res;
		setTimeout(function(){
			$('#area').val(infoVisita.visita[0].id_area).trigger('change');
			$('#fecha').val(infoVisita.visita[0].fecha);
			$('#departamento').val(infoVisita.visita[0].id_departamento).trigger('change');
			$('#escuela').val(infoVisita.visita[0].id_escuela).trigger('change');
			$('#oficial').val(infoVisita.visita[0].id_oficial).trigger('change');
			$('#aulas').val(infoVisita.visita[0].aulas);
			$('#viaticos').val(infoVisita.visita[0].viaticos);
			$('#pendientes').val(infoVisita.visita[0].pendientes);
			$('#observaciones').val(infoVisita.visita[0].observaciones);
			//
			$(infoVisita.voluntarios).each(function(key, value){
				$('#vln'+value.id_voluntario).prop('checked', true);
				$('#time'+value.id_voluntario).removeAttr('disabled');
				$('#time'+value.id_voluntario).val(value.tiempo);
			});
			$(infoVisita.motivos).each(function(key, value){
				$('#mtv'+value.id_motivo).prop('checked', true);
				$('#timeM'+value.id_motivo).removeAttr('disabled');
				$('#timeM'+value.id_motivo).val(value.tiempo);
			});
		}, 1500);
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

	//
	
	var aux = []; 
	var auxTime = [];
	
	$('#group-voluntario-1 div input:checkbox:checked').each(function(index){
		aux.push(this.value);
		auxTime.push($('#time'+this.value).val());
	});
	$('#group-voluntario-2 div input:checkbox:checked').each(function(index){
		aux.push(this.value);
		auxTime.push($('#time'+this.value).val());
	});

	var vltsReg = [];
	var vlts = [];
	var vltsTime = [];
	var vltsStatus = [];

	$(infoVisita.voluntarios).each(function(key, value){
		var val = false;
		aux.forEach(function(item, index){
			 if (value.id_voluntario == item) {
			 	vltsReg.push(value.id);
			 	vlts.push(item);
			 	vltsTime.push(auxTime[index]);
			 	vltsStatus.push('m');
			 	//
			 	//aux.splice(index, 1);
			 	//auxTime.splice(index, 1);
			 	aux[index] = 0;
			 	val = true;
			 }
		});
		if (val == false) {
			vltsReg.push(value.id);
		 	vlts.push(0);
		 	vltsTime.push(0);
		 	vltsStatus.push('d');
		}
	});
	aux.forEach(function(item, index){
		if (item != 0) {
			vltsReg.push(0);
		 	vlts.push(item);
		 	vltsTime.push(auxTime[index]);
		 	vltsStatus.push('n');
		}
	});

	aux = []; 
	auxTime = [];
	
	$('#group-motivos-1 div input:checkbox:checked').each(function(index){
		aux.push(this.value);
		auxTime.push($('#timeM'+this.value).val());
	});
	$('#group-motivos-2 div input:checkbox:checked').each(function(index){
		aux.push(this.value);
		auxTime.push($('#timeM'+this.value).val());
	});

	var mtvsReg = [];
	var mtvs = [];
	var mtvsTime = [];
	var mtvsStatus = [];

	$(infoVisita.motivos).each(function(key, value){
		var val = false;
		aux.forEach(function(item, index){
			 if (value.id_motivo == item) {
			 	mtvsReg.push(value.id);
			 	mtvs.push(item);
			 	mtvsTime.push(auxTime[index]);
			 	mtvsStatus.push('m');
			 	//
			 	aux[index] = 0;
			 	val = true;
			 }
		});
		if (val == false) {
			mtvsReg.push(value.id);
		 	mtvs.push(0);
		 	mtvsTime.push(0);
		 	mtvsStatus.push('d');
		}
	});
	aux.forEach(function(item, index){
		if (item != 0) {
			mtvsReg.push(0);
		 	mtvs.push(item);
		 	mtvsTime.push(auxTime[index]);
		 	mtvsStatus.push('n');
		}
	});

	$.ajax({
		url: '/visita/'+$('#idv').val(),
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		type: 'PUT',
		dataType: 'json',
		data: {fecha: $('#fecha').val(), id_escuela: $('#escuela').val(), id_oficial: $('#oficial').val(),
				aulas: $('#aulas').val(), viaticos: $('#viaticos').val(), 
				pendientes: $('#pendientes').val(), observaciones: $('#observaciones').val(),
				voluntariosReg: vltsReg, voluntarios: vlts, voluntariosTime: vltsTime, voluntariosStatus: vltsStatus, 
				motivosReg: mtvsReg, motivos: mtvs, motivosTime: mtvsTime, motivosStatus: mtvsStatus},

		success: function(){
			$('#msjcreate').removeClass('alert-danger');
			$('#msjcreate').addClass('alert-success');
			$('#msjcreate'+'-text').html('Registro actualizado exitosamente!');
			$('#msjcreate').fadeIn();
			window.setTimeout(function(){$('#msjcreate').fadeOut();location.href='/visita'}, 2000);
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