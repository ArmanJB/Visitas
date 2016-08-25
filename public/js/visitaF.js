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
			$('#group-voluntario-1').append('<div class="bootstrap-timepicker"><div class="input-group">'+
													'<input type="checkbox" class="filled-in" id="vln'+value.id+'" value="'+value.id+'"/>'+
													'<label for="vln'+value.id+'" value="'+value.id+'" OnClick="setHoraVln(this);">'+value.nombres+' '+value.apellidos+'</label>'+
													'<input type="text" class="form-control timepicker" id="time'+value.id+'" disabled>'+
											'</div></div');
		}else{
			$('#group-voluntario-2').append('<div class="bootstrap-timepicker"><div class="input-group">'+
													'<input type="checkbox" class="filled-in" id="vln'+value.id+'" value="'+value.id+'"/>'+
													'<label for="vln'+value.id+'" value="'+value.id+'" OnClick="setHoraVln(this);">'+value.nombres+' '+value.apellidos+'</label>'+
													'<input type="text" class="form-control timepicker" id="time'+value.id+'" disabled>'+
											'</div></div');
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
				$('#group-motivos-1').append('<div class="bootstrap-timepicker"><div class="input-group">'+
														'<input type="checkbox" class="filled-in" id="mtv'+value.id+'" value="'+value.id+'"/>'+
														'<label for="mtv'+value.id+'" value="'+value.id+'" OnClick="setHoraMtv(this);">'+value.nombre+'</label>'+
														'<input type="text" class="form-control timepicker" id="timeM'+value.id+'" disabled>'+
												'</div></div');
			}else if ((value.id_area)==1){
				$('#group-motivos-2').append('<div class="bootstrap-timepicker"><div class="input-group">'+
														'<input type="checkbox" class="filled-in" id="mtv'+value.id+'" value="'+value.id+'"/>'+
														'<label for="mtv'+value.id+'" value="'+value.id+'" OnClick="setHoraMtv(this);">'+value.nombre+'</label>'+
														'<input type="text" class="form-control timepicker" id="timeM'+value.id+'" disabled>'+
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