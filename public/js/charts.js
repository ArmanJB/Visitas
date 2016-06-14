$(function(){
	$('#container').highcharts({
		chart:{type: 'pie'},//column
		title:{text: 'titulo'},
		subtitle:{text: 'subtitulo'},
		xAxis:{type: 'category'},//eje x
		yAxis:{
			title:{text: 'titulo en y'}
		},
		legend:{enabled: false},
		plotOptions:{
			series:{
				//borderWidth: 0,//se comenta para pie
				dataLabels:{enabled: true, format: '{point.name}: {point.y:.1f}%'}//format: '{point.name}: {point.y:.1f}%'//{point.y:.1f}%
			}
		},
		tooltip:{
			headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}:</span> <b>{point.y:.2f}%</b><br/>'
		},
		//
		series:[{
			name: 'Visitas',
			colorByPoint: true,
			data: dataPadre
		}],
		//
		drilldown:{
			series:[datahijo1, datahijo2]
		}
	});
});

var dataPadre = [{name: 'Chrome', y: 24.03, drilldown: 'Chrome'}, {name: 'Firefox', y: 10.38, drilldown: 'Firefox'}];

var datahijo1 = {name: 'Chrome', id: 'Chrome', data: [['v40.0', 5], ['v41.0', 4.32], ['v42.0', 3.68], ['v39.0', 2.96]]};
var datahijo2 = {name: 'Firefox', id: 'Firefox', data: [['v35', 2.76], ['v36', 2.32], ['v37', 2.31], ['v34', 1.27], ['v38', 1.02]]};

