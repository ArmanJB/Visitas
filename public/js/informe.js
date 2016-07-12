var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre'];

function returnMes(mes){
	var rMes = null;
	for (var i = 0; i < meses.length; i++) {
		if (mes == meses[i]) {
			rMes = i+1;
		}
	}

	return rMes;
}

$(function(){
	$('#mes').val($('#filtrarAnio').html());
	setTables();
	var ar = [];
	ar = $('#mes').val().split(',');
	getData(ar);
	getDataArea(ar);

	getDataMotivos(ar);
	getDataOficial(ar);

	$('#metaMensual').on('click', function(){
		if ($('#metaMensual').html()=='- Meta mensual de visitas por área') {
			$('#metaMensualSection').fadeOut();
			$('#metaMensual').html('+ Meta mensual de visitas por área')
		}else{
			$('#metaMensualSection').fadeIn();
			$('#metaMensual').html('- Meta mensual de visitas por área')
		}
	});

	$('#motivos').on('click', function(){
		if ($('#motivos').html()=='- Motivos de visita') {
			$('#motivosSection').fadeOut();
			$('#motivos').html('+ Motivos de visita')
		}else{
			$('#motivosSection').fadeIn();
			$('#motivos').html('- Motivos de visita')
		}
	});

	$('#oficial').on('click', function(){
		if ($('#oficial').html()=='- Cumplimiento de metas por oficial') {
			$('#oficialSection').fadeOut();
			$('#oficial').html('+ Cumplimiento de metas por oficial')
		}else{
			$('#oficialSection').fadeIn();
			$('#oficial').html('- Cumplimiento de metas por oficial')
		}
	});
});

function setMes(btn){
	$('#mes').val($('#filtrarAnio').html()+','+btn.text);
	//
	getData($('#mes').val().split(','));
	getDataArea($('#mes').val().split(','));
	getDataMotivos($('#mes').val().split(','));
	getDataOficial($('#mes').val().split(','));
}
function setAnio(btn){
	$('#filtrarAnio').html(btn.text);
	$('#mes').val($('#filtrarAnio').html());
	//
	getData($('#mes').val().split(','));
	getDataArea($('#mes').val().split(','));
	getDataMotivos($('#mes').val().split(','));
	getDataOficial($('#mes').val().split(','));
}

$('#print').on('click', function(){
	//getData($('#mes').val().split(',') );

	document.getElementById("group-informe").style.opacity = 0;
	document.getElementById("group-informe").style.height = 0;
	var panel = document.getElementsByClassName("navbar");
	panel[0].style.opacity = 0; panel[0].style.height = 0;
	panel[1].style.opacity = 0; panel[1].style.height = 0;

	window.print();
	setTimeout(100);

	document.getElementById("group-informe").style.opacity = 100;
	document.getElementById("group-informe").style.height = "100%";
	panel[0].style.opacity = 100; panel[0].style.height = 100;
	panel[1].style.opacity = 100; panel[1].style.height = 100;
});

function setTables(){
	$('#toPrint').append('<table class="table informe"><h3>Meta Mensual General</h3><thead><th>Mes</th><th>Meta Planeada</th><th>Meta Ejecutada</th><th>% Alcanzado</th></thead><tbody id="datos"></tbody></table>');
	$('#toPrint').append('<h3><a class="linkInfo" id="metaMensual">- Meta mensual de visitas por área</a></h3><hr><div id="metaMensualSection"></div>');
	$('#toPrint').append('<h3><a class="linkInfo" id="motivos">- Motivos de visita</a></h3><hr><div id="motivosSection"></div>');
	$('#toPrint').append('<h3><a class="linkInfo" id="oficial">- Cumplimiento de metas por oficial</a></h3><hr><div id="oficialSection"></div>');
	$.get('/areas', function(res){
		$(res).each(function(key, value){
			$('#metaMensualSection').append('<table class="table informe"><h4>'+value.nombre+'</h4><thead><th>Mes</th><th>Meta Planeada</th><th>Meta Ejecutada</th><th>% Alcanzado</th></thead><tbody id="datos'+value.id+'"></tbody></table>');
			$('#motivosSection').append('<table class="table informe"><h4>'+value.nombre+'</h4><thead><th>Motivos</th><th>Cantidad</th></thead><tbody id="datosM'+value.id+'"></tbody></table>');
			$('#oficialSection').append('<table class="table informe"><h4>'+value.nombre+'</h4><thead><th>Oficial a cargo</th><th id="meta'+value.id+'">Meta mensual</th><th id="acum'+value.id+'">Acumulado</th><th>% de Cumplimiento</th></thead><tbody id="datosO'+value.id+'"></tbody></table>');
		});
	});
	
}

function getData(ar){
	var meta = 0;
	if (ar.length > 1) {
		$('#datos').empty();

		$.get('/areas', function(res){
			$(res).each(function(key, value){
				meta +=value.meta;
			});

			$.get('/visitas/cant', function(res){
				var cant = 0;
				var i = returnMes(ar[1]);
				$(res).each(function(key2, value2){
						if (i<10) {
							if (value2.fecha >= ar[0]+'-0'+i+'-01' && value2.fecha <= ar[0]+'-0'+i+'-31') {
								cant++;
							}
						}else{
							if (value2.fecha >= ar[0]+'-'+i+'-01' && value2.fecha <= ar[0]+'-'+i+'-31') {
								cant++;
							}
						}
				});
				$('#datos').append('<tr><td>'+ar[1]+'</td><td>'+meta+'</td><td>'+cant+'</td><td>'+Math.round( (cant*100)/meta )+'% </td></tr>');
				$('#datos').append('<tr class="tfoot"><td>Total</td><td>'+(meta*meses.length)+'</td><td>'+cant+'</td><td>'+Math.round( (cant*100)/(meta*meses.length) )+'% </td></tr>');
			});
		});
	}else{
		$('#datos').empty();
		$.get('/areas', function(res){
			$(res).each(function(key, value){
				meta +=value.meta;
			});

			$.get('/visitas/cant', function(res){
				var ej = 0;
				for (var i = 1; i < 12; i++) {
					var cant = 0;
					$(res).each(function(key2, value2){
						if (i<10) {
							if (value2.fecha >= ar[0]+'-0'+i+'-01' && value2.fecha <= ar[0]+'-0'+i+'-31') {
								cant++;
							}
						}else{
							if (value2.fecha >= ar[0]+'-'+i+'-01' && value2.fecha <= ar[0]+'-'+i+'-31') {
								cant++;
							}
						}
					});	
					ej += cant;
					$('#datos').append('<tr><td>'+meses[i-1]+'</td><td>'+meta+'</td><td>'+cant+'</td><td>'+Math.round( (cant*100)/meta )+'% </td></tr>');
				}
				$('#datos').append('<tr class="tfoot"><td>Total</td><td>'+(meta*meses.length)+'</td><td>'+ej+'</td><td>'+Math.round( (ej*100)/(meta*meses.length) )+'% </td></tr>');
			});
		});
	}
}

function getDataArea(ar){
	if (ar.length > 1) {
		$.get('/areas', function(res){
			$(res).each(function(key, value){
					$('#datos'+value.id).empty();
					$.get('/visitas/cantArea/'+value.id, function(res){
						var cant = 0;
						var i = returnMes(ar[1]);
						$(res).each(function(key2, value2){
								if (i<10) {
									if (value2.fecha >= ar[0]+'-0'+i+'-01' && value2.fecha <= ar[0]+'-0'+i+'-31') {
										cant++;
									}
								}else{
									if (value2.fecha >= ar[0]+'-'+i+'-01' && value2.fecha <= ar[0]+'-'+i+'-31') {
										cant++;
									}
								}
						});
						$('#datos'+value.id).append('<tr><td>'+ar[1]+'</td><td>'+value.meta+'</td><td>'+cant+'</td><td>'+Math.round( (cant*100)/value.meta )+'% </td></tr>');
						$('#datos'+value.id).append('<tr class="tfoot"><td>Total</td><td>'+(value.meta*meses.length)+'</td><td>'+cant+'</td><td>'+Math.round( (cant*100)/(value.meta*meses.length) )+'% </td></tr>');
					});
			});

		});
	}else{
		$.get('/areas', function(res){
			$(res).each(function(key, value){
					$('#datos'+value.id).empty();
					$.get('/visitas/cantArea/'+value.id, function(res){
						var ej = 0;
						for (var i = 1; i < 12; i++) {
							var cant = 0;
							$(res).each(function(key2, value2){
								if (i<10) {
									if (value2.fecha >= ar[0]+'-0'+i+'-01' && value2.fecha <= ar[0]+'-0'+i+'-31') {
										cant++;
									}
								}else{
									if (value2.fecha >= ar[0]+'-'+i+'-01' && value2.fecha <= ar[0]+'-'+i+'-31') {
										cant++;
									}
								}
							});	
							ej += cant;
							$('#datos'+value.id).append('<tr><td>'+meses[i-1]+'</td><td>'+value.meta+'</td><td>'+cant+'</td><td>'+Math.round( (cant*100)/value.meta )+'% </td></tr>');
						}
						$('#datos'+value.id).append('<tr class="tfoot"><td>Total</td><td>'+(value.meta*meses.length)+'</td><td>'+ej+'</td><td>'+Math.round( (ej*100)/(value.meta*meses.length) )+'% </td></tr>');
					});
			});

		});
	}
}

function getDataMotivos(ar){
	$.get('/areas', function(res){
		$(res).each(function(key, value){
			$('#datosM'+value.id).empty();
			$.get('/visitas/cantDet/'+value.id, function(res2){
				$.get('/motivos', function(res3){
					$(res3).each(function(key3, value3){
						var cant = 0;
						res2.forEach(function(index){
							if (ar.length > 1) {
								var i = returnMes(ar[1]);
								if (i<10) {
									if (index.fecha >= ar[0]+'-0'+i+'-01' && index.fecha <= ar[0]+'-0'+i+'-31') {if (value3.id==index.id_motivo) {cant++;}}
								}else{
									if (index.fecha >= ar[0]+'-'+i+'-01' && index.fecha <= ar[0]+'-'+i+'-31') {if (value3.id==index.id_motivo) {cant++;}}
								}
							}else{
								if (index.fecha >= ar[0]+'-01-01' && index.fecha <= ar[0]+'-12-31') {
									if (value3.id==index.id_motivo) {cant++;}
								}
							}
						});
						if (cant > 0) {
							$('#datosM'+value.id).append('<tr><td class="informeM">'+value3.nombre+'</td><td>'+cant+'</td></tr>');
						}
					});
				});

			});
		});
	});
}

function getDataOficial(ar){
	$.get('/areas', function(res){
		$(res).each(function(key, value){
			$('#datosO'+value.id).empty();


			$.get('/visitas/cantOfi/'+value.id, function(res2){
				$.get('/oficial/byArea/'+value.id, function(res3){
					$(res3).each(function(key3, value3){
						var cant = 0;
						res2.forEach(function(index){
							if (ar.length > 1) {
								var i = returnMes(ar[1]);
								if (i<10) {
									if (index.fecha >= ar[0]+'-0'+i+'-01' && index.fecha <= ar[0]+'-0'+i+'-31') {if (value3.id==index.id_oficial) {cant++;}}
								}else{
									if (index.fecha >= ar[0]+'-'+i+'-01' && index.fecha <= ar[0]+'-'+i+'-31') {if (value3.id==index.id_oficial) {cant++;}}
								}
							}else{
								if (index.fecha >= ar[0]+'-01-01' && index.fecha <= ar[0]+'-12-31') {
									if (value3.id==index.id_oficial) {cant++;}
								}
							}
						});
						if (cant > 0) {
							if (ar.length > 1){
								$('#meta'+value.id).html('Meta mensual');
								$('#acum'+value.id).html(ar[1]);
								$('#datosO'+value.id).append('<tr><td class="informeM">'+value3.nombres+' '+value3.apellidos+'</td><td>'+value3.meta+'</td><td>'+cant+'</td><td>'+Math.round((cant*100)/value3.meta)+'%</td></tr>');
							}else{
								$('#meta'+value.id).html('Meta anual');
								$('#acum'+value.id).html('Acumulado');
								$('#datosO'+value.id).append('<tr><td class="informeM">'+value3.nombres+' '+value3.apellidos+'</td><td>'+(value3.meta*meses.length)+'</td><td>'+cant+'</td><td>'+Math.round((cant*100)/(value3.meta*meses.length))+'%</td></tr>');
							}
							
						}
					});
				});

			});



		});
	});
}