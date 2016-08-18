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
                  <!--<div class="pull-left"><a href="#" class="btn btn-default btn-flat">Conf</a></div>-->
                  <div class="pull-right"><a href="{!!URL::to('logout')!!}" class="btn btn-default btn-flat">Cerrar Sesión</a></div>
                </li>
              </ul>
            </li>
            <li class="dropdown tasks-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-gears"></i>
              </a>
              <ul class="dropdown-menu">
                <li class="header">Opciones</li>
                <li><a href="{!!URL::to('/usuario')!!}"><h4>Usuarios<strong class="pull-right"><i class="fa fa-users"></i></strong></h4></a></li>
              </ul>
            </li>
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
            <p>{!!Auth::user()->name!!}</p>
            <a id="user_area"> </a>
          </div>
        </div>
        <ul class="sidebar-menu">
          <li class="header">Navegación principal</li>
          <li class="treeview">
            <a href="#"><i class="fa fa-briefcase"></i><span>Visitas</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
            <ul class="treeview-menu">
              <li><a href="{!!URL::to('/visita/create')!!}"><i class="fa fa-plus"></i> Agregar visitas</a></li>
              <li><a href="{!!URL::to('/visita')!!}"><i class="fa fa-list"></i> Listar visitas</a></li>
              <li><a href="{!!URL::to('/visita/charts')!!}"><i class="fa fa-pie-chart"></i> Resumen de visitas</a></li>
              <li><a href="{!!URL::to('/visita/informe')!!}"><i class="fa fa-line-chart"></i> Informes de visitas</a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#"><i class="fa fa-suitcase"></i><span>Talleres</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
            <ul class="treeview-menu">
              <li><a href="{!!URL::to('/taller/create')!!}"><i class="fa fa-plus"></i> Agregar talleres</a></li>
              <li><a href="{!!URL::to('/talleres')!!}"><i class="fa fa-list"></i> Listar talleres</a></li>
              <li><a href="#"><i class="fa fa-pie-chart"></i> Resumen de talleres</a></li>
              <li><a href="#"><i class="fa fa-line-chart"></i> Informes de talleres</a></li>
            </ul>
          </li>
          @if (Auth::user()->id != 5)
          <li class="header">Navegación secundaria</li>
          <li><a href="/catalogos"><i class="fa fa-edit"></i> <span>Catalogos</span></a></li>

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
        @yield('content')
      <!--<section class="content-header">
        <h1>Panel de Control<small>Tablero</small></h1>
        <ol class="breadcrumb"><li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li><li class="active">Dashboard</li></ol>
      </section>

      <section class="content">
        <div class="row">
          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
              <div class="inner"><h3>150</h3><p>New Orders</p></div>
              <div class="icon"><i class="ion ion-bag"></i></div>
            </div>
          </div>
          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
              <div class="inner"><h3>53<sup style="font-size: 20px">%</sup></h3><p>Bounce Rate</p></div>
              <div class="icon"><i class="ion ion-stats-bars"></i></div>
            </div>
          </div>
          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
              <div class="inner"><h3>44</h3><p>User Registrations</p></div>
              <div class="icon"><i class="ion ion-person-add"></i></div>
            </div>
          </div>
          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
              <div class="inner"><h3>65</h3><p>Unique Visitors</p></div>
              <div class="icon"><i class="ion ion-pie-graph"></i></div>
            </div>
          </div>
        </div>
        <div class="row">
          <section class="col-lg-7 connectedSortable">
            <div class="box box-info">
              <div class="box-header">
                <i class="fa fa-envelope"></i><h3 class="box-title">Mensaje</h3>
                <div class="pull-right box-tools">
                  <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                <form action="#" method="post">
                  <div class="form-group">
                    <input type="email" class="form-control" name="emailto" placeholder="Email to:">
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" name="subject" placeholder="Subject">
                  </div>
                  <div>
                    <textarea class="textarea" placeholder="Message" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                  </div>
                </form>
              </div>
              <div class="box-footer clearfix">
                <button type="button" class="pull-right btn btn-default" id="sendEmail">Enviar
                  <i class="fa fa-arrow-circle-right"></i></button>
              </div>
            </div>
          </section>
          <section class="col-lg-5 connectedSortable">
            <div class="box box-solid bg-light-blue-gradient">
              <div class="box-header">
                <div class="pull-right box-tools">
                  <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
                    <i class="fa fa-minus"></i></button>
                </div>
                <i class="fa fa-map-marker"></i><h3 class="box-title">Visitors</h3>
              </div>
              <div class="box-body">
                <div id="world-map" style="height: 250px; width: 100%;"></div>
              </div>
              <div class="box-footer no-border">
                <div class="knob-label">Online</div>
              </div>
            </div>
          </section>
        </div>
      </section>-->
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
    <!--{!!Html::script('js/demo.js')!!}-->
    <script>
      $(function(){
        $.get('/usuarios/detalle/'+{!!Auth::user()->id!!}, function(res){
          $('#user_type').html(res[0].tipo);
          $('#user_area').html(res[0].area);
        });
      });
    </script>

    @section('scripts')
    @show
</body>
</html>

