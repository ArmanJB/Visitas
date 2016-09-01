var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre'];
$(function(){
	$(".select2").select2();
	setMes();
	setAnio();
	setOficial();
	setPeriodo();
	listar();
});

function setMes(){
	$('#mes').empty();
	$('#mes').append('<option value="placeholder">Seleccione</option>');
	meses.forEach(function(mes, index){$('#mes').append('<option value="'+(index+1)+'">'+mes+'</option>'); });
}
function setAnio(){
	$('#anio').empty();
	$('#anio').append('<option value="placeholder">Seleccione</option>');
	for (var i = 0; i < 30; i++) {
		$('#anio').append('<option value="'+(2016+i)+'">'+(2016+i)+'</option>');
	}
}

function setOficial(){
	$('#oficial').empty();
	$('#oficial').append('<option value="placeholder">Seleccione un oficial</option>');
	$.get('/oficials', function(res){
		$(res).each(function(key, value){
			$('#oficial').append('<option value="'+value.id+'">'+value.nombres+' '+value.apellidos+'</option>');
		})
	});
}

function setPeriodo(){
	$('#periodo').empty();
	$('#periodo').append('<option value="placeholder">Seleccione un periodo</option>');
	$.get('/periodos', function(res){
		$(res).each(function(key, value){
			$('#periodo').append('<option value="'+value.id+'">'+meses[(value.mes-1)]+', '+value.anio+'</option>');
		})
	});
}

$('#registrarP').on('click', function(){
	if($('#anio').val() == 'placeholder'){
		$('#msjnewP').removeClass('alert-success');
		$('#msjnewP').addClass('alert-danger');
		$('#msjnewP'+'-text').html('Seleccione un año!');
		$('#msjnewP').fadeIn();
		window.setTimeout(function(){$('#msjnewP').fadeOut();}, 2000);
		return;
	}
	if($('#mes').val() == 'placeholder'){
		$('#msjnewP').removeClass('alert-success');
		$('#msjnewP').addClass('alert-danger');
		$('#msjnewP'+'-text').html('Seleccione un mes!');
		$('#msjnewP').fadeIn();
		window.setTimeout(function(){$('#msjnewP').fadeOut();}, 2000);
		return;
	}
	$.get('/periodos', function(res){
		var cont = 0;
		$(res).each(function(key, value){
			if ($('#anio').val() == value.anio && $('#mes').val() == value.mes){cont++;}
		});
		if (cont>0){
			$('#msjnewP').removeClass('alert-success');
			$('#msjnewP').addClass('alert-danger');
			$('#msjnewP'+'-text').html('El periodo ya existe!');
			$('#msjnewP').fadeIn();
			window.setTimeout(function(){$('#msjnewP').fadeOut();}, 2000);
			return;
		}else{
			$.ajax({
				url: '/periodo',
				headers: {'X-CSRF-TOKEN': $('#token').val()},
				type: 'POST',
				dataType: 'json',
				data: {mes: $('#mes').val(), anio: $('#anio').val()},

				success: function(){
					//listar();
					$('#anio').val('placeholder').trigger('change');
					$('#mes').val('placeholder').trigger('change');
					$('#msjnewP').removeClass('alert-danger');
					$('#msjnewP').addClass('alert-success');
					$('#msjnewP'+'-text').html('Registro agregado exitosamente!');
					$('#msjnewP').fadeIn();
					window.setTimeout(function(){$('#msjnewP').fadeOut();}, 2000);
					setPeriodo();
				}
			});
		}
	});		
})

$('#registrarM').on('click', function(){
	if($('#periodo').val() == 'placeholder'){
		$('#msjnewM').removeClass('alert-success');
		$('#msjnewM').addClass('alert-danger');
		$('#msjnewM'+'-text').html('Seleccione un periodo!');
		$('#msjnewM').fadeIn();
		window.setTimeout(function(){$('#msjnewM').fadeOut();}, 2000);
		return;
	}
	if($('#oficial').val() == 'placeholder'){
		$('#msjnewM').removeClass('alert-success');
		$('#msjnewM').addClass('alert-danger');
		$('#msjnewM'+'-text').html('Seleccione un oficial!');
		$('#msjnewM').fadeIn();
		window.setTimeout(function(){$('#msjnewM').fadeOut();}, 2000);
		return;
	}
	if($('#meta').val() == '0'){
		$('#msjnewM').removeClass('alert-success');
		$('#msjnewM').addClass('alert-danger');
		$('#msjnewM'+'-text').html('Meta no puede ser igual a cero!');
		$('#msjnewM').fadeIn();
		window.setTimeout(function(){$('#msjnewM').fadeOut();}, 2000);
		return;
	}
	$.get('/metas', function(res){
		var cont = 0;
		$(res).each(function(key, value){
			if ($('#periodo').val() == value.id_periodo && $('#oficial').val() == value.id_oficial){cont++;}
		});
		if (cont>0){
			$('#msjnewM').removeClass('alert-success');
			$('#msjnewM').addClass('alert-danger');
			$('#msjnewM'+'-text').html('El periodo con el oficial seleccionado se ha registrado anteriormente!');
			$('#msjnewM').fadeIn();
			window.setTimeout(function(){$('#msjnewM').fadeOut();}, 2000);
			return;
		}else{
			$.ajax({
				url: '/meta',
				headers: {'X-CSRF-TOKEN': $('#token').val()},
				type: 'POST',
				dataType: 'json',
				data: {meta: $('#meta').val(), id_oficial: $('#oficial').val(), id_periodo: $('#periodo').val()},

				success: function(){
					listar();
					$('#periodo').val('placeholder').trigger('change');
					$('#oficial').val('placeholder').trigger('change');
					$('#meta').val('');
					$('#msjnewM').removeClass('alert-danger');
					$('#msjnewM').addClass('alert-success');
					$('#msjnewM'+'-text').html('Registro agregado exitosamente!');
					$('#msjnewM').fadeIn();
					window.setTimeout(function(){$('#msjnewM').fadeOut();}, 2000);
				},
				error:function(msj){
					$('#msjnewM').removeClass('alert-success');
					$('#msjnewM').addClass('alert-danger');
					$('#msjnewM'+'-text').html(msj.responseJSON.meta);
					$('#msjnewM').fadeIn();
					window.setTimeout(function(){$('#msjnewM').fadeOut();}, 2000);
				}
			});
		}
	});
})

function listar(){
	$('#datosmeta').empty();
	$.get('/metas', function(res){
		$(res).each(function(key, value){
			$('#datosmeta').append('<tr><td>'+(key+1)+'</td><td>'+meses[(value.mes-1)]+', '+value.anio+'</td><td>'+value.oficial+'</td><td>'+value.meta+'</td><td>'+
				'<button value='+value.id+' OnClick="mostrar(this);" class="btn btn-primary" data-toggle="modal" data-target="#modalEdit">Editar</button> '+
				'<button value='+value.id+' OnClick="danger(this);" class="btn btn-danger" data-toggle="modal" data-target="#modalRemove">Eliminar</button></td></tr>');
		})
	});
}

function danger(btn){
	$('#confirmRemove').val(btn.value);
}

function eliminar(btn){
	$.ajax({
		url: '/meta/'+btn.value,
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		type: 'DELETE',
		dataType: 'json',
		success: function(){
			listar();
			$('#modalRemove').modal('toggle');
			$('#msjlist').removeClass('alert-danger');
			$('#msjlist').addClass('alert-success');
			$('#msjlist'+'-text').html('Registros actualizados exitosamente!');
			$('#msjlist').fadeIn();
			window.setTimeout(function(){$('#msjlist').fadeOut();}, 2000);
		}
	});
}
/*
$('#actualizar').on('click', function(){
	var value = $('#id').val();	
	var idPeriodo = $('#periodo').val();
	var idOficial = $('#oficial').val();
	var meta = $('#meta').val();

	$.ajax({
		url: '/metas/'+value+'',
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		type: 'PUT',
		dataType: 'json',
		data: {meta: meta, id_oficial: idOficial, id_periodo: idPeriodo},

		success: function(){
			listar();
			$('#myModal').modal('toggle');
			$('#msj-success').fadeIn();
			window.setTimeout(function(){$('#msj-success').fadeOut();}, 2000);
		}
	});
})

$('#actualizar').on('click', function(){
	var tab = $(this).attr('data');
	var dJson;
	if ($(this).attr('data') == 'motivo') {
		dJson = {nombre: $('#nombren').val(), id_area: $('#selectn').val()}
	}else{
		dJson = {nombre: $('#nombren').val(), id_motivo: $('#selectn').val()}
	}
	$.ajax({
		url: '/'+$(this).attr('data')+'/'+$('#idn').val(),
		headers: {'X-CSRF-TOKEN': $('#token').val()},
		type: 'PUT',
		dataType: 'json',
		data: dJson,
		success: function(){
			listar();
			$('#modalEdit').modal('toggle');
			$('#nombren').val('');
			$('#msjlist').removeClass('alert-danger');
			$('#msjlist').addClass('alert-success');
			$('#msjlist'+'-text').html('Registros actualizados exitosamente!');
			$('#msjlist').fadeIn();
			window.setTimeout(function(){$('#msjlist').fadeOut();}, 2000);
		}
	});
})*/
