$(function(){
	
	//-----------------------------------

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
	setData($('#fechaIni').val(), $('#fechaFin').val());
});

var titulo = 'Visitas por Departamento';
var subtitulo = '';
var tituloY = 'Cantidad de visitas';

var dataPadre = [];
var data = [];
var subdata = [];

function setData($ini, $fin){
	subtitulo = 'de '+$ini+' a '+$fin;

	$.get('/visitas/'+route+'/'+$ini+'/'+$fin, function(res){
		dataPadre = [];
		data = [];
		subdata = [];
		$(res).each(function(key, value){
			dataPadre.push({name: value[0], y: value[1], drilldown: value[0]});
				$.get('/visitas/'+route+'Det/'+$ini+'/'+$fin+'/'+value[2], function(resp){
					subdata = [];
					$(resp).each(function(key, index){
						subdata.push([index[0], index[1]]);
						if (key == (resp.length-1)) {data.push({name: value[0], id: value[0], data: subdata});}
					})
				});
		})
		chart();
	});
}

function chart(){
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



/*
series: [{
    name: 'Things',
    colorByPoint: true,
    data: [{
        name: 'Animals',
        y: 5,
        drilldown: 'animals'
    },{
        name: 'Food',
        y: 4,
        drilldown: 'food'
    }]
}],
drilldown: {
    series: [
	    {
	        id: 'food',
	        name: 'Food',
	        data: [
	        	{
	            	name: 'Apple',
	            	y: 1.5,
	            	drilldown: 'apple'
	        	},['Banana', 1],['Peer', 0.5],['Pineapple', 1]
	        ]
	    }, 
	    {
	        id: 'apple',
	        data: [['1/6' ,1],['1/3' , 2],['1/2' , 3]]
	    },
	    {
	        id: 'animals',
	        name: 'Animals',
	        data: [
	        	{
		            name: 'Cats',
		            y: 5,
		            drilldown: 'cats'
	        	}, ['Dogs', 2],['Cows', 1],['Sheep', 1],['Pigs', 1]
	        ]
	    }, 
	    {
	        id: 'cats',
	        data: [1, 2, 3]
	    }
    ]
}
*/