<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <title>Seguimiento - Menú</title>

	    {!!Html::style('css/materialize.min.css')!!}
	    {!!Html::style('css/style.css')!!}
	</head>
	<body>

	<ul id="dropdown" class="dropdown-content">
		<div id="divider"></div>
		<li><a href="{!!URL::to('logout')!!}">Cerrar Sesión</a></li>
	</ul>
	<nav>
		<div class="nav-wrapper">
	    	<a href="/menu" class="brand-logo">Seguimiento</a>
	    	<ul class="right hide-on-med-and-down">
	      		<!-- Dropdown Trigger -->
	      		<li><a class="dropdown-button" href="#!" data-activates="dropdown">{!!Auth::user()->name!!}<i class="material-icons right"></i></a></li>
	    	</ul>
	  	</div>
	</nav>


		
		<div>
			<div id="divider"></div>

			<div class="row">
				<div class="col s12 m3"><p></p></div>
		        <div class="col s12 m3">
		          <div class="card hoverable">
		            <div class="card-image">
		              <img src="/img/arrow.png">
		              <span class="card-title loglabel">Visitas</span>
		            </div>
		            
		            <div class="card-action">
		              <a href="/visita/create">Ir a Visitas</a>
		            </div>
		          </div>
		        </div>
		        <div class="col s12 m3">
		          <div class="card hoverable">
		            <div class="card-image">
		              <img src="/img/man.png">
		              <span class="card-title loglabel">Administración</span>
		            </div>
		            
		            <div class="card-action">
		              <a href="/admin">Ir al panel de administración</a>
		            </div>
		          </div>
		        </div>
		    </div>


			{!!Html::script('js/jquery.min.js')!!}
		    {!!Html::script('js/materialize.min.js')!!}

		    <script type="text/javascript">
		    	$(".dropdown-button").dropdown();
		    </script>
		</div>
	</body>
</html>