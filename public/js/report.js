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
	$('#zonas').empty();
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
		$(res.zonas).each(function(key, value){
			$('#zonas').append('<tr><td>'+(key+1)+'</td><td class="informeM">'+value.zona+'</td><td>'+value.cant+'</td></tr>');
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