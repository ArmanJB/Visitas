$(function(){
	$(".select2").select2();
	$(".timepicker").timepicker({showMeridian: false, showInputs: false, defaultTime: '01:00'});
	$('#section2').fadeOut();
	$('#section3').fadeOut();
	$('#section4').fadeOut();
	setDepartamento();
	setInternacional();
	setZona();
	setLugar();
	setActividad();
	setOficial();
	setContenido();
	setAudiencia();
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
function setOficial(){
	$('#group-oficial-1').empty();
	$('#group-oficial-2').empty();
	$.get('/oficials', function(res){
		$(res).each(function(key, value){
			if ((key%2)==0) {
				$('#group-oficial-1').append('<div><input type="checkbox" class="filled-in" id="ofc'+value.id+'" value="'+value.id+
					'"/><label for="ofc'+value.id+'" style="color:black;">'+value.nombres+' '+value.apellidos+'</label></div>');
			}else{
				$('#group-oficial-2').append('<div><input type="checkbox" class="filled-in" id="ofc'+value.id+'" value="'+value.id+
					'"/><label for="ofc'+value.id+'" style="color:black;">'+value.nombres+' '+value.apellidos+'</label></div>');
			}
		});
	});
}
function setContenido(){
	$('#group-contenido').empty();
	$.get('/contenidos', function(res){
		$(res).each(function(key, value){
			$('#group-contenido').append('<div><input type="checkbox" class="filled-in" id="cnt'+value.id+'" value="'+value.id+
					'"/><label for="cnt'+value.id+'" style="color:black;">'+value.nombre+'</label></div>');
		});
	});
}
function setAudiencia(){
	$('#group-audiencia').empty();
	$.get('/audiencias', function(res){
		$(res).each(function(key, value){
			$('#group-audiencia').append('<div><input type="checkbox" class="filled-in" id="adc'+value.id+'" value="'+value.id+
					'"/><label for="adc'+value.id+'" style="color:black;">'+value.nombre+'</label></div>');
		});
	});
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
$('#departamento').on('change', function(){
	if ($('#departamento').val()=='placeholder') {
		$('#escuela').empty();
		$('#escuela').append('<option value="placeholder">Selecciona una departamento antes..</option>');
	}
	setEscuelas($('#departamento').val());
});
function setEscuelas($id){
	$.get('/escuela/byDep/'+$id, function(res){
		$('#escuela').empty();
		$('#escuela').append('<option value="placeholder">Selecciona una escuela</option>');
		$(res).each(function(key, value){
			$('#escuela').append('<option value="'+value.id+'">'+value.nombre+'</option>');
		});
	});
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
		$('#zona').append('<option value="placeholder">Selecciona un zona de atención</option>');
		$(res).each(function(key, value){
			$('#zona').append('<option value="'+value.id+'">'+value.nombre+'</option>');
		});
	});
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

$('#registrar').on('click', function(){
	$('#viewAll').prop('checked', true);
	$('#viewAll').trigger('change');

	$('#box-parent').find('.has-error').each(function(){
		$(this).removeClass('has-error');
	});

	if (validar() > 0) {
		$('#msjcreate').removeClass('alert-success');
		$('#msjcreate').addClass('alert-danger');
		$('#msjcreate'+'-text').html('Faltan campos obligatorios por completar!');
		$('#msjcreate').fadeIn();
		window.setTimeout(function(){$('#msjcreate').fadeOut();}, 2000);
		return;
	}
	window.alert('todo bien')

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