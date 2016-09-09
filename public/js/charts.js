var principal = null;
var secundario = null;

$(function(){
	getData();
	//-----------------------------------
	//principal = [{name: 'Animals', y: 5, drilldown: 'animals'}, {name: 'Food', y: 4, drilldown: 'food'} ];
	/*secundario =[
				    {
				        id: 'food',
				        name: 'Food',
				        data: [
				        	{name: 'Apple', y: 1.5, drilldown: 'apple'},
				        	{name: 'Banana', y: 1, drilldown: 'Banana'},
				        	{name: 'Peer', y: 0.5, drilldown: 'Peer'},
				        	{name: 'Pineapple', y: 1, drilldown: 'Pineapple'}
				        ]
				    }, 
				    {
				        id: 'apple',
				        data: [
					        ['1/6' ,1],
					        ['1/3' , 2],
					        ['1/2' , 3]
				        ]
				    },
				    {
				        id: 'animals',
				        name: 'Animals',
				        data: [
				        	{name: 'Cats', y: 5, drilldown: 'cats'}, 
				        	['Dogs', 2],
				        	['Cows', 1],
				        	['Sheep', 1],
				        	['Pigs', 1]
				        ]
				    }, 
				    {
				        id: 'cats',
				        name: 'cats',
				        data: [
				        	{name: 'hoy', y: 2, drilldown: 'dias'},
				        	['mañana', 3],
				        	['ayer', 4]
				        ]
				    },
				    {
				    	id: 'dias',
				    	name: 'dias',
				    	data: [
				    		['lunes', 5],
				    		['martes', 2],
				    		['miercoles', 7],
				    		['jueves', 1]
				    	]
				    }
				];*/
});

var route = 'byDep';

$('#fechaIni').on('change', function(){
	if ($('#fechaIni').val() == '' || $('#fechaFin').val() == '') {$('#actualizar').attr('disabled', true)}
	else{$('#actualizar').removeAttr('disabled')}
	if ($('#fechaIni').val() > $('#fechaFin').val()) {$('#actualizar').attr('disabled', true)}
});
$('#fechaFin').on('change', function(){
	if ($('#fechaIni').val() == '' || $('#fechaFin').val() == '') {$('#actualizar').attr('disabled', true)}
	else{$('#actualizar').removeAttr('disabled')}
	if ($('#fechaIni').val() > $('#fechaFin').val()) {$('#actualizar').attr('disabled', true)}
});

function active(link){
	$('.list-group-item').removeClass('active');
	link.classList.add('active');
	route = 'by'+link.id;
	titulo = ''+link.text;
}
/**************************************************************************/

$('#actualizar').on('click', function(){
	//if ($('#fechaIni').val() == $('#fechaFin').val()) {}
	//setData($('#fechaIni').val(), $('#fechaFin').val());
	chart();
});

var titulo = 'Visitas por Área';
var subtitulo = '';
var tituloY = 'Cantidad de visitas';

var dataPadre = [];
var data = [];
var subdata = [];

function setData(ini, fin){
	subtitulo = 'de '+ini+' a '+fin;
	var routeU = '';
	var area;

	$.get('/oficial/byName/'+$('#metadata').attr('nameU'), function(res){
		$(res).each(function(key, value){
			area = value.id_area;
		})
		if ($('#metadata').attr('data') == 'user') {
			routeU = '/visitas/'+route+'U/'+ini+'/'+fin+'/'+area;
		}else{
			routeU = '/visitas/'+route+'/'+ini+'/'+fin;
		}

		$.get(routeU, function(res){
			dataPadre = [];
			data = [];
			subdata = [];
			$(res).each(function(key, value){
				dataPadre.push({name: value[0], y: value[1], drilldown: value[0]});
					if ($('#metadata').attr('data') == 'user') {
						$.get('/visitas/'+route+'DetU/'+ini+'/'+fin+'/'+value[2]+'/'+area, function(resp){
							subdata = [];
							$(resp).each(function(key, index){
								subdata.push([index[0], index[1]]);
								if (key == (resp.length-1)) {data.push({name: value[0], id: value[0], data: subdata});}
							})
						});
					}else{
						$.get('/visitas/'+route+'Det/'+ini+'/'+fin+'/'+value[2], function(resp){
							subdata = [];
							$(resp).each(function(key, index){
								subdata.push([index[0], index[1]]);
								if (key == (resp.length-1)) {data.push({name: value[0], id: value[0], data: subdata});}
							})
						});
					}
			});
			chart();
		});

	});

}

function chart2(){
	$('#container').highcharts({
		chart:{type: 'pie'},//column
		title:{text: titulo},
		subtitle:{text: subtitulo},
		xAxis:{type: 'category'},//eje x
		yAxis:{
			title:{text: tituloY}
		},
		legend:{enabled: false},
		plotOptions:{
			series:{
				//borderWidth: 0,//se comenta para pie
				dataLabels:{enabled: true, format: '{point.name}: {point.y:.0f}'}//format: '{point.name}: {point.y:.1f}%'//{point.y:.1f}%
			}
		},
		tooltip:{
			headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}:</span> <b>{point.y:.0f}</b><br/>'
		},
		//
		series:[{
			name: 'Visitas',
			colorByPoint: true,
			data: dataPadre
		}],
		//
		drilldown:{
			series: data
		}
	});
}

function getData(){
	$.get('/charts/areas', function(res){
		console.log(res)
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
		console.log(principal)
		console.log(secundario)
	});
}

function chart(){
	$('#container').highcharts({
		chart:{type: 'pie'},
		title:{text: titulo},
		subtitle:{text: subtitulo},
		xAxis:{type: 'category'},
		yAxis:{title:{text: tituloY}},
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


