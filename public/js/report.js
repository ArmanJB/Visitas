var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre'];
$(function(){
	$('#periodos').empty();
	$.get('/periodos', function(res){
		$(res).each(function(key, value){
			$('#periodos').append('<li><a href="#" onclick="setPeriodo(this);" value="'+value.id+'">'+value.anio+', '+meses[(value.mes-1)]+'</a></li>');
		});
	});

	$('#areas').empty();
	$.get('/areas', function(res){
		$(res).each(function(key, value){
			$('#areas').append('<div class="col-md-2"><input type="checkbox" class="filled-in" id="area'+value.id+'" value="" checked/><label for="area'+value.id+'" style="color:black;" id="labelView" onclick="setArea(this);">'+value.nombre+'</label></div>');
		});
	});

	$('#actualizarT').click();
	$('#actualizar').click();
});
function setPeriodo(btn){
	$('#periodos-text').val(btn.text);
	$('#periodos-text').attr('data', $(btn).attr('value'));
};
function setArea(btn){
	if ($('#'+$(btn).attr('for')).is(':checked')) {
		$('.'+$(btn).attr('for')).fadeOut();
	}else{
		$('.'+$(btn).attr('for')).fadeIn();
	}
}

$('#actualizarT').on('click', function(){
	listar();
	clear();
});

function clear(){
	$('#consolidado').empty();
	$('#actividades').empty();
	$('#audiencias').empty();
	$('#contenidos').empty();
	$('#zonas').empty();
	$('#comparativoVisitas').empty();
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
			$('#audiencias').append('<tr><td>'+(key+1)+'</td><td class="informeM">'+value.audiencia+'</td><td>'+value.cant+'</td><td>'+value.duracion+'</td></tr>');
		});
		$(res.contenidos).each(function(key, value){
			$('#contenidos').append('<tr><td>'+(key+1)+'</td><td class="informeM">'+value.contenido+'</td><td>'+value.cant+'</td><td>'+value.duracion+'</td></tr>');
		});
		$(res.zonas).each(function(key, value){
			$('#zonas').append('<tr><td>'+(key+1)+'</td><td class="informeM">'+value.zona+'</td><td>'+value.cant+'</td><td>'+value.duracion+'</td></tr>');
		});
        var data = [{
            name: 'Tokyo',
            data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

        }, {
            name: 'New York',
            data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

        }];
        var data = [];
        $(res.comparativo['data']).each(function(key, value){data.push(JSON.parse(value));});
		comparativo(res.comparativo['oficiales'], data);
	});
}

function comparativo(oficiales, data){
	if (oficiales.length != 0) {
		$('#comparativoVisitas').highcharts({
	        chart: {type: 'column'},
	        title: {text: 'Consolidado de actividades'},
	        subtitle: {text: 'desde '+$('#desde').val()+' hasta '+$('#hasta').val()},
	        xAxis: {categories: oficiales,crosshair: true},
	        yAxis: {min: 0, title: {text: 'Cantidad de visitas o talleres'} },
	        tooltip: {
	            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
	            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
	                '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
	            footerFormat: '</table>',
	            shared: true,
	            useHTML: true
	        },
	        plotOptions: {column: {pointPadding: 0.2, borderWidth: 0} },
	        series: data
	    });
	}
}

$('#actualizar').on('click', function(){
	listarV();
	clearV();
	$(':checkbox').each(function(key, value){$(value).prop('checked', true)});
});

function clearV(){
	$('#consolidado').empty();
	$('#report-container').empty();
}

function listarV(){
	$.get('/visitas/reporte/'+$('#periodos-text').attr('data'), function(res){
		console.log(res)
		$('#consolidado').append('<tr><td>'+$('#periodos-text').val()+'</td><td>'+res.consolidado['mes']['planeado']+'</td><td>'+res.consolidado['mes']['ejecutado']+'</td><td>'+parseInt((100*parseInt(res.consolidado['mes']['ejecutado']))/parseInt(res.consolidado['mes']['planeado']))+'%</td></tr>');
		$('#consolidado').append('<tr class="tfoot"><td>Total anual</td><td>'+res.consolidado['anual']['planeado']+'</td><td>'+res.consolidado['anual']['ejecutado']+'</td><td>'+parseInt((100*parseInt(res.consolidado['anual']['ejecutado']))/parseInt(res.consolidado['anual']['planeado']))+'%</td></tr>');
		//
		$(res.areas).each(function(key, value){
			$('#report-container').append('<div class="col-md-12 '+value.id+'"><div class="col-md-2"></div><div class="col-md-8"><h4>'+value.area+'</h4>'+
				'<table class="table table-hover informe"><thead><th>Periodo</th><th>Meta planeada</th><th>Meta ejecutada</th><th>% alcanzado</th></thead><tbody>'+
				'<tr><td>'+$('#periodos-text').val()+'</td><td>'+value.planeado+'</td><td>'+value.ejecutado+'</td><td>'+((value.planeado == 0)?'--':parseInt((100*value.ejecutado)/value.planeado))+'%</td></tr>'+
				'<tr class="tfoot"><td>Total anual</td><td>'+value.planeadoAnual+'</td><td>'+value.ejecutadoAnual+'</td><td>'+((value.planeado == 0)?'--':parseInt((100*value.ejecutadoAnual)/value.planeadoAnual))+'%</td></tr>'+
				'</tbody></table><div id="divider"></div></div></div>');
		});
		
	});
}

