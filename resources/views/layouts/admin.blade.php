<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FZT | Visitas</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    {!!Html::style('css/select2.css')!!}
    {!!Html::style('css/bootstrap.min.css')!!}
    {!!Html::style('css/font-awesome.min.css')!!}
    {!!Html::style('https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css')!!}
    {!!Html::style('css/AdminLTE.min.css')!!}
    {!!Html::style('css/skins/_all-skins.min.css')!!}
    {!!Html::style('css/blue.css')!!}
    {!!Html::style('css/style.css')!!}
    <!-- Date Picker -->
    {!!Html::style('css/datepicker3.css')!!}
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <header class="main-header">

      <a href="/admin" class="logo">
        <span class="logo-mini"><b>FZT</b></span>
        <span class="logo-lg"><b>F. </b>Zamora Terán</span>
      </a>

      <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only"></span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-user"></i>
                <span class="hidden-xs">{!!Auth::user()->name!!}</span>
              </a>
              <ul class="dropdown-menu">
                <li class="user-header">
                  <img src="/img/logo-user.jpg" class="img-circle" alt="User Image">
                  <p>
                    {!!Auth::user()->name!!}
                    <small id="user_type"></small>
                  </p>
                </li>
                <li class="user-footer">
                  <div class="pull-left"><button id="userPassButton" class="btn btn-default btn-flat" data-toggle="tooltip" title="Cambiar Contraseña"><i class="fa fa-lock"></i></button></div>
                  <div class="pull-right"><a href="{!!URL::to('logout')!!}" class="btn btn-default btn-flat">Cerrar Sesión</a></div>
                </li>
              </ul>
            </li>
            @if (Auth::user()->id_type == 1)
            <li class="dropdown tasks-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-gears"></i>
              </a>
              <ul class="dropdown-menu">
                <li class="header">Opciones</li>
                <li><a href="{!!URL::to('/usuario')!!}"><h4>Usuarios<strong class="pull-right"><i class="fa fa-users"></i></strong></h4></a></li>
              </ul>
            </li>
            @endif
            <!--<li><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a></li>-->
          </ul>
        </div>
      </nav>
    </header>

    <aside class="main-sidebar">
      <section class="sidebar">
        <div class="user-panel">
          <div class="pull-left image">
            <img src="/img/logo-user.jpg" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p id="user_oficial">{!!Auth::user()->name!!}</p>
            <a id="user_area"> </a>
          </div>
        </div>
        <ul class="sidebar-menu">
          <li class="header">Navegación principal</li>
          @if (Auth::user()->id_type != 1)
          <li class="treeview active">
          @else
          <li class="treeview">
          @endif
            <a href="#"><i class="fa fa-briefcase"></i><span>Visitas</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
            <ul class="treeview-menu">
              <li><a href="{!!URL::to('/visita/create')!!}"><i class="fa fa-plus"></i> Agregar visitas</a></li>
              <li><a href="{!!URL::to('/visita')!!}"><i class="fa fa-list"></i> Listar visitas</a></li>
              <li><a href="{!!URL::to('/charts')!!}"><i class="fa fa-pie-chart"></i> Resumen de visitas</a></li>
              <li><a href="#"><i class="fa fa-line-chart"></i> Informes de visitas</a></li>
            </ul>
          </li>
          @if (Auth::user()->id_type != 1)
          <li class="treeview active" id="tallerEdu">
          @else
          <li class="treeview" id="tallerEdu">
          @endif
            <a href="#"><i class="fa fa-suitcase"></i><span>Talleres</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
            <ul class="treeview-menu">
              <li><a href="{!!URL::to('/taller/create')!!}"><i class="fa fa-plus"></i> Agregar talleres</a></li>
              <li><a href="{!!URL::to('/taller')!!}"><i class="fa fa-list"></i> Listar talleres</a></li>
              <li><a href="#"><i class="fa fa-pie-chart"></i> Resumen de talleres</a></li>
              <li><a href="#"><i class="fa fa-line-chart"></i> Informes de talleres</a></li>
            </ul>
          </li>
          @if (Auth::user()->id_type == 1)
          <li class="header">Navegación secundaria</li>
          <li><a href="/catalogos"><i class="fa fa-edit"></i> <span>Catálogos</span></a></li>

          <li><a href="{!!URL::to('/personas')!!}"><i class="fa fa-male" ></i> <span>Oficiales / Voluntarios</span></a></li>

          <li><a href="{!!URL::to('/escuelasF')!!}"><i class="fa fa-graduation-cap"></i> <span>Escuelas</span></a></li>
          <li class="treeview">
            <a href="#"><i class="fa fa-archive"></i><span>Planificación</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
            <ul class="treeview-menu">
              <li><a href="{!!URL::to('/metasF')!!}"><i class="fa fa-circle-o"></i> Periodos<br>
                <i class="fa fa-circle-o" style="color:#2c3b41;"></i> Metas por oficial</a></li>
              <li><a href="{!!URL::to('/motivosF')!!}"><i class="fa fa-circle-o"></i> Motivos<br>
                <i class="fa fa-circle-o" style="color:#2c3b41;"></i> Detalles de motivos</a></li>
              
            </ul>
          </li>
          @endif
        </ul>
      </section>
    </aside>

    <div class="content-wrapper">
      @include('alerts.errors')
      @include('layouts.userPass')
      @yield('content')
      <div id="dashboard" style="display:none;">
        <section class="content-header">
          <h1>Control de Visitas<small> Inicio</small></h1>
        </section>

        <section class="content">
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-aqua">
                <div class="inner"><h3>00</h3><p>Nuevas metas</p></div>
                <div class="icon"><i class="ion ion-arrow-graph-up-right"></i></div>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-green">
                <div class="inner"><h3>00<sup style="font-size: 20px">%</sup></h3><p>Visitas actuales</p></div>
                <div class="icon"><i class="ion ion-calendar"></i></div>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-orange">
                <div class="inner"><h3>00</h3><p>Talleres actuales</p></div>
                <div class="icon"><i class="ion ion-briefcase"></i></div>
              </div>
            </div>
          </div>
      </div>
      </div>

    <footer class="main-footer">
      <div class="pull-right hidden-xs"><b>Control de Visitas</b></div>
      <strong>Copyright &copy; 2016 - <a href="http://fundacionzt.org">Fundación Zamora Terán</a></strong> 
    </footer>

    <aside class="control-sidebar control-sidebar-dark">
      <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-birthday-cake"></i></a></li>
      </ul>
      
      <div class="tab-content">
        <div class="tab-pane" id="control-sidebar-home-tab">
          <h3 class="control-sidebar-heading">Próximos Cumpleaños</h3>
          <ul class="control-sidebar-menu">

            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">Nombre completo</h4>
                  <p>(calcular años) años el (dia) de (mes escrito)</p>
                </div>
              </a>
            </li>

          </ul>
        </div>
      </div>
    </aside>
    <div class="control-sidebar-bg"></div>
  </div>

    {!!Html::script('js/jquery.min.js')!!}
    {!!Html::script('https://code.jquery.com/ui/1.11.4/jquery-ui.min.js')!!}
    <script>$.widget.bridge('uibutton', $.ui.button);</script>
    {!!Html::script('js/bootstrap.min.js')!!}
    {!!Html::script('js/bootstrap-datepicker.js')!!}
    {!!Html::script('js/jquery.slimscroll.min.js')!!}
    {!!Html::script('js/fastclick.js')!!}
    {!!Html::script('js/app.min.js')!!}
    {!!Html::script('js/userPass.js')!!}
    <!--{!!Html::script('js/demo.js')!!}-->
    <script>
      $(function(){
        if ('{{Request::path()}}' == 'admin'){
          $('#dashboard').fadeIn();
        }
        setDetails({!!Auth::user()->id!!});

        $('#userPassButton').on('click', function(){
          $('#modalUserPass').modal('toggle');
          mostrar({!!Auth::user()->id!!})
        });
        
      });
    </script>

    @section('scripts')
    @show
</body>
</html>

