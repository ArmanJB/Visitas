$(function(){
	listar();
});

function listar(){
	$.get('/talleres', function(res){
		//console.log(res.group)
		$(res.group).each(function(key, value){
			var ofcs = "";
			$(res.taller).each(function(key2, value2){
				if (value.id==value2.id) {ofcs+=' ║ '+value2.nombres+' '+value2.apellidos;}
			});
			$('#datos').append('<tr><td>'+(key+1)+'</td><td>'+value.fecha+'</td><td>'+value.nombre+'</td><td>'+ofcs+'</td><td>'+
				'<button value='+value.id+' OnClick="detalle(this);" class="btn btn-default" data-toggle="modal" data-target="#modaldetail">Detalles</button> '+
				'<button value='+value.id+' OnClick="mostrar(this);" class="btn btn-primary" data-toggle="modal" data-target="#modalEdit">Editar</button> '+
				'<button value='+value.id+' OnClick="danger(this);" class="btn btn-danger" data-toggle="modal" data-target="#modalRemove">Eliminar</button></td></tr>');
		})
	});
}