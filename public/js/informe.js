$('#print').on('click', function(){
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

function setMes(btn){
	$('#mes').val(btn.text);
}
