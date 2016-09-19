$(function(){
	listar();
	clear();
});

$('#actualizarT').on('click', function(){
	listar();
	clear();
});

function clear(){
	$('#consolidado').empty();
	$('#actividades').empty();
	$('#audiencias').empty();
	$('#contenidos').empty();
}

function listar(){
	$.get('/talleres/reporte/'+$('#desde').val()+'/'+$('#hasta').val(), function(res){
		$('#consolidado').append('<tr><td>'+$('#desde').val()+'</td><td>'+$('#hasta').val()+'</td><td>'+res.cant+'</td><td>'+parseInt((parseInt(res.cant)*100)/res.anual)+'%</td></tr>');
		$('#consolidado').append('<tr class="tfoot"><td colspan="2">Total anual<td>'+res.anual+'</td><td>100%</td></tr>');
		//
		$(res.actividades).each(function(key, value){
			$('#actividades').append('<tr><td class="informeM">'+value.actividad+'</td><td>'+value.cant+'</td><td>'+value.pers+'</td><td>'+value.duracion+'</td></tr>');
		});
		$('#actividades').append('<tr class="tfoot"><td class="informeM">Total</td><td>'+res.actividadesT['cant']+'</td><td>'+res.actividadesT['pers']+'</td><td>'+res.actividadesT['duracion']+'</td></tr>');
		//
		$(res.audiencias).each(function(key, value){
			$('#audiencias').append('<tr><td class="informeM">'+value.audiencia+'</td><td>'+value.cant+'</td></tr>');
		});
		$(res.contenidos).each(function(key, value){
			$('#contenidos').append('<tr><td class="informeM">'+value.contenido+'</td><td>'+value.cant+'</td></tr>');
		});
	});
}