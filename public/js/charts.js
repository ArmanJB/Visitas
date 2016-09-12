var principal = null;
var secundario = null;
var titulo = ' ';

$(function(){
	$('#areasChart').prop('checked', true);
	setTimeout(function(){
		if ($('#user_type').attr('value') == 1) {
			$('#chart_type').fadeIn();
		}
	},1000);
});
$('#areasChart').change(function(){
	if ($(this).is(':checked')) {
		$('#depChart').prop('checked', false);
	}else{
		$('#depChart').prop('checked', true);
	}
});
$('#depChart').change(function(){
	if ($(this).is(':checked')) {
		$('#areasChart').prop('checked', false);
	}else{
		$('#areasChart').prop('checked', true);
	}
});

$('#desde').on('change', function(){
	if ($('#desde').val() == '' || $('#hasta').val() == '') {$('#actualizar').attr('disabled', true)}
	else{$('#actualizar').removeAttr('disabled')}
	if ($('#desde').val() > $('#hasta').val()) {$('#actualizar').attr('disabled', true)}
});
$('#hasta').on('change', function(){
	if ($('#desde').val() == '' || $('#hasta').val() == '') {$('#actualizar').attr('disabled', true)}
	else{$('#actualizar').removeAttr('disabled')}
	if ($('#desde').val() > $('#hasta').val()) {$('#actualizar').attr('disabled', true)}
});

/**************************************************************************/

$('#actualizar').on('click', function(){
	getData($('#desde').val(), $('#hasta').val());
});

function getData(desde, hasta){
	var route = '';
	if ($('#user_type').attr('value') == 1) {
		if ($('#areasChart').prop('checked') == true) {
			route = '/charts/areas/'+desde+'/'+hasta;
			titulo = 'Resumen por áreas';
		}else{
			route = '/charts/departamentos/'+desde+'/'+hasta;
			titulo = 'Resumen por departamentos';
		}
	}else{
		if ($('#user_type').attr('value') == 2) {
			route = '/charts/coordinador/'+desde+'/'+hasta+'/'+$('#user_area').attr('value');
			titulo = 'Resumen por área';
		}else if ($('#user_type').attr('value') == 3){
			route = '/charts/oficial/'+desde+'/'+hasta+'/'+$('#user_oficial').attr('value');
			titulo = 'Resumen por oficial';
		}
	}

	$.get(route, function(res){
		principal = [];
		secundario = [];
		$(res.principal).each(function(key, value){principal.push(JSON.parse(value))});
		$(res.secundarios).each(function(key, value){
			secundario.push(JSON.parse(value))
			var aux = [];
			$(secundario[key].data).each(function(key2, value2){
				aux.push(JSON.parse(value2));
			});
			secundario[key].data = aux;
		});
		chart();
	});
}

function chart(){
	$('#container').highcharts({
		chart:{type: 'pie'},
		title:{text: titulo},
		subtitle:{text: 'desde '+$('#desde').val()+' hasta '+$('#hasta').val()},
		xAxis:{type: 'category'},
		yAxis:{title:{text: 'Cantidad de visitas'}},
		legend:{enabled: false},
		plotOptions:{series:{dataLabels:{enabled: true, format: '{point.name}: {point.y:.0f}'}} },
		tooltip:{
			headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}:</span> <b>{point.y:.0f}</b><br/>'
		},
		series: [{name: 'Visitas', colorByPoint: true, data: principal }],
		drilldown: {series: secundario}
	});
}

$('#actualizarT').on('click', function(){
	getDataT($('#desde').val(), $('#hasta').val());
});

function getDataT(desde, hasta){
	titulo = 'Talleres';
	$.get('/charts/talleres/'+desde+'/'+hasta, function(res){
		principal = [];
		secundario = [];
		$(res.principal).each(function(key, value){principal.push(JSON.parse(value))});
		$(res.secundarios).each(function(key, value){
			secundario.push(JSON.parse(value))
			var aux = [];
			$(secundario[key].data).each(function(key2, value2){
				aux.push(JSON.parse(value2));
			});
			secundario[key].data = aux;
		});
		chart();
	});
}