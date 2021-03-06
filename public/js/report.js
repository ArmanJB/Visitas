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
	$('#viaticos').empty();
	$('#atendidas').empty();
	$('#atendidasF').empty();
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
		var totalv = 0;
		$(res.viaticos).each(function(key, value){
			$('#viaticos').append('<tr><td>'+(key+1)+'</td><td class="informeM">'+value.oficial+'</td><td>C$ '+value.viatico+'</td></tr>');
			totalv += value.viatico;
		});
		$('#viaticos').append('<tr class="tfoot"><td></td><td class="informeM">Total</td><td>C$ '+totalv+'</td></tr>');
        var totala = 0;
        $(res.atendidas).each(function(key, value){
			$('#atendidas').append('<tr><td>'+(key+1)+'</td><td class="informeM">'+value.departamento+'</td><td class="informeM">'+value.escuela+'</td><td>'+value.talleres+'</td></tr>');
			totala += value.talleres;
		});
		$('#atendidas').append('<tr class="tfoot"><td></td><td class="informeM" colspan="2">Total</td><td>'+totala+'</td></tr>');
        $(res.atendidasF).each(function(key, value){
			$('#atendidasF').append('<tr><td>'+(key+1)+'</td><td class="informeM">'+value.departamento+'</td><td class="informeM">'+value.escuela+'</td></tr>');
		});
        //
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
	$('#report-motivos').empty();
	$('#report-oficiales').empty();
	$('#report-viaticos').empty();
	$('#report-voluntarios').empty();
	$('#report-escuelas').empty();
	$('#report-escuelasP').empty();
	$('#report-articuladas').empty();
	$('#comparativoVisitas').empty();
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
		$(res.motivos).each(function(key, value){
			$('#report-motivos').append('<div class="col-md-12 '+value.id+'"><div class="col-md-2"></div><div class="col-md-8"><h4>'+value.area+'</h4><table class="table table-hover informe"><thead><th>#</th><th>Motivos</th><th>Cantidad</th><th>Tiempo Invertido</th></thead><tbody id="tabla-motivos-'+value.id+'"></tbody></table><div id="divider"></div></div></div>');
			$(value.motivos).each(function(key2, value2){
				$('#tabla-motivos-'+value.id).append('<tr><td>'+(key2+1)+'</td><td class="informeM">'+value2.motivo+'</td><td>'+value2.cantidad+'</td><td>'+value2.tiempo+'</td></tr>');
			});
		});
		$(res.oficiales).each(function(key, value){
			var metasT = 0;
			var visitasT = 0;
			$('#report-oficiales').append('<div class="col-md-12 '+value.id+'"><div class="col-md-2"></div><div class="col-md-8"><h4>'+value.area+'</h4><table class="table table-hover informe"><thead><th>#</th><th>Oficial</th><th>Meta en el periodo</th><th>'+$('#periodos-text').val()+'</th><th>% alcanzado</th></thead><tbody id="tabla-oficiales-'+value.id+'"></tbody></table><div id="divider"></div></div></div>');
			$(value.oficiales).each(function(key2, value2){
				metasT += value2.meta;
				visitasT += value2.visitas;
				$('#tabla-oficiales-'+value.id).append('<tr><td>'+(key2+1)+'</td><td class="informeM">'+value2.oficial+'</td><td>'+value2.meta+'</td><td>'+value2.visitas+'</td><td>'+parseInt((100*value2.visitas)/value2.meta)+'%</td></tr>');
			});
			$('#tabla-oficiales-'+value.id).append('<tr class="tfoot"><td></td><td>Total área</td><td>'+metasT+'</td><td>'+visitasT+'</td><td>'+((metasT == 0)?'--':parseInt((100*visitasT)/metasT))+'%</td></tr>');
		});
		$(res.viaticos).each(function(key, value){
			var viaticosT = 0;
			var viaticosAT = 0;
			$('#report-viaticos').append('<div class="col-md-12 '+value.id+'"><div class="col-md-2"></div><div class="col-md-8"><h4>'+value.area+'</h4><table class="table table-hover informe"><thead><th>#</th><th>Oficial</th><th>Gastos de viáticos en '+$('#periodos-text').val()+'</th><th>Gastos de viáticos anuales</th></thead><tbody id="tabla-viaticos-'+value.id+'"></tbody></table><div id="divider"></div></div></div>');
			$(value.oficiales).each(function(key2, value2){
				viaticosT += value2.viaticos;
				viaticosAT += value2.anual;
				$('#tabla-viaticos-'+value.id).append('<tr><td>'+(key2+1)+'</td><td class="informeM">'+value2.oficial+'</td><td>C$ '+value2.viaticos+'</td><td>C$ '+value2.anual+'</td></tr>');
			});
			$('#tabla-viaticos-'+value.id).append('<tr class="tfoot"><td></td><td>Total área</td><td>C$ '+viaticosT+'</td><td>C$ '+viaticosAT+'</td</tr>');
		});
		//
		$('#report-voluntarios').append('<div class="col-md-12 area1"><div class="col-md-2"></div><div class="col-md-8"><table class="table table-hover informe"><thead><th>#</th><th>Voluntario</th><th>Tiempo invertido durante '+$('#periodos-text').val()+'</th><th>Tiempo invertido anual</th></thead><tbody id="tabla-voluntarios"></tbody></table><div id="divider"></div></div></div>');
		$(res.voluntarios).each(function(key, value){
			$('#tabla-voluntarios').append('<tr><td>'+(key+1)+'</td><td class="informeM">'+value.voluntario+'</td><td>'+value.tiempo+'</td><td>'+value.anual+'</td></tr>');
		});
		$('#tabla-voluntarios').append('<tr class="tfoot"><td></td><td class="informeM">Total</td><td>'+res.totalVol+'</td><td>'+res.totalVolAnual+'</td></tr>');
		//
		$('#report-articuladas').append('<div class="col-md-12 area1"><div class="col-md-2"></div><div class="col-md-8"><table class="table table-hover informe"><thead><th>#</th><th>Departamento</th><th>Escuela</th><th>Cantidad de visitas articuladas</th></thead><tbody id="tabla-articuladas"></tbody></table><div id="divider"></div></div></div>');
		var totalArticuladas = 0;
		$(res.articuladas).each(function(key, value){
			$('#tabla-articuladas').append('<tr><td>'+(key+1)+'</td><td class="informeM">'+value.departamento+'</td><td>'+value.escuela+'</td><td>'+value.cant+'</td></tr>');
			totalArticuladas += value.cant;
		});
		$('#tabla-articuladas').append('<tr class="tfoot"><td></td><td class="informeM">Total</td><td></td><td>'+totalArticuladas+'</td></tr>');
		//
		$(res.escuelas).each(function(key, value){
			$('#report-escuelas').append('<div class="col-md-12 '+value.id+'"><div class="col-md-2"></div><div class="col-md-8"><h4>'+value.area+'</h4><table class="table table-hover informe"><thead><th>#</th><th>Departamento</th><th>Escuela</th><th>Tiempo Invertido</th></thead><tbody id="tabla-escuelas-'+value.id+'"></tbody></table><div id="divider"></div></div></div>');
			$(value.escuelas).each(function(key2, value2){
				$('#tabla-escuelas-'+value.id).append('<tr><td>'+(key2+1)+'</td><td class="informeM">'+value2.departamento+'</td><td class="informeM">'+value2.escuela+'</td><td>'+value2.tiempo+'</td></tr>');
			});	
			$('#tabla-escuelas-'+value.id).append('<tr class="tfoot"><td></td><td>Total área</td><td>'+value.escuelas.length+'</td><td>'+value.total+'</td></tr>');
		});
		$(res.escuelasP).each(function(key, value){
			$('#report-escuelasP').append('<div class="col-md-12 '+value.id+'"><div class="col-md-2"></div><div class="col-md-8"><h4>'+value.area+'</h4><table class="table table-hover informe"><thead><th>#</th><th>Departamento</th><th>Escuela</th></thead><tbody id="tabla-escuelasP-'+value.id+'"></tbody></table><div id="divider"></div></div></div>');
			var dep = '';
			var depC = 0;
			$(value.escuelas).each(function(key2, value2){
				if (dep != value2.departamento) {
					if (key2 != 0){
						$('.dep'+value.id+depC).each(function(key3, function3){$(this).addClass('collapse');});
					}
					dep = value2.departamento;
					depC++;
					$('#tabla-escuelasP-'+value.id).append('<tr data-toggle="collapse" data-target=".dep'+value.id+depC+'"><td></td><td class="informeM">'+value2.departamento+'</td><td><i class="fa fa-chevron-down"></i></td></tr>');
				}
				$('#tabla-escuelasP-'+value.id).append('<tr class="dep'+value.id+depC+'"><td>'+(key2+1)+'</td><td class="informeM">'+value2.departamento+'</td><td class="informeM">'+value2.escuela+'</td></tr>');
			});
			$('.dep'+value.id+depC).each(function(key3, function3){$(this).addClass('collapse');});	
			$('#tabla-escuelasP-'+value.id).append('<tr class="tfoot"><td></td><td>Total área</td><td>'+value.escuelas.length+'</td></tr>');
		});
		//
        var data = [];
        $(res.data).each(function(key, value){data.push(JSON.parse(value));});
		comparativoV(data);
	});
}

function comparativoV(data){
	$('#comparativoVisitas').highcharts({
        chart: {type: 'column'},
        title: {text: 'Visitas anuales'},
        subtitle: {text: 'Año '+(new Date).getFullYear()},
        xAxis: {categories: meses,crosshair: true},
        yAxis: {min: 0, title: {text: 'Cantidad de visitas'} },
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