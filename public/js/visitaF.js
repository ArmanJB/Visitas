var escuelas = null;

$(function(){
	$(".select2").select2();
	$(".timepicker").timepicker({showMeridian: false, showInputs: false, defaultTime: '01:00'});
	setAreas();
	setDepartamentos();
	getEscuelas();
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