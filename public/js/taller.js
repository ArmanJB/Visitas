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
	window.alert($('#duracion').val())
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
