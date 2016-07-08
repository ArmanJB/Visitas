<nav id="panel" class="navbar navbar-default " role="navigation" style="margin-bottom: 0">
	<ul class="nav navbar-top-links">
	    <li class="li-visita">
	        <a href="{!!URL::to('/visita/create')!!}"><i class='fa fa-plus fa-fw'></i> Agregar Visitas</a>
	    </li>
	    <li class="li-visita">
	        <a href="{!!URL::to('/visita')!!}"><i class='fa fa-list fa-fw'></i> Listar Visitas</a>
	    </li>
	    <li class="li-visita">
	        <a href="{!!URL::to('/visita/charts')!!}"><i class='fa fa-line-chart fa-fw'></i> Resumen de Visitas</a>
	    </li>
	    @if (Auth::user()->id <= 5)
	    <li class="li-visita">
	        <a href="{!!URL::to('/visita/informe')!!}"><i class='fa fa-line-chart fa-fw'></i> Informes de Visitas</a>
	    </li>
	    @endif
	</ul>

</nav>