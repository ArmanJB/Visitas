<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Seguimiento</title>

    {!!Html::style('css/bootstrap.min.css')!!}
    {!!Html::style('css/metisMenu.min.css')!!}
    {!!Html::style('css/sb-admin-2.css')!!}
    {!!Html::style('css/font-awesome.min.css')!!}
    {!!Html::style('css/style.css')!!}

    <!--<link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/metisMenu.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">-->

</head>

<body>

    <div id="wrapper">

        
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand cl1" href="/admin"><img src="/img/logo.png" width="85px" height="40px"></a>
                <a class="navbar-brand cl2" href="/admin">Administración</a>
            </div>
           

            <ul class="nav navbar-top-links navbar-right">
                 <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        {!!Auth::user()->name!!}
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <!--<li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>-->
                        <li><a href="/menu"><i class="fa fa-th fa-fw"></i> Regresar al menú</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{!!URL::to('logout')!!}"><i class="fa fa-sign-out fa-fw"></i> Cerrar Sesión</a>
                        </li>
                    </ul>
                </li>
                @if (Auth::user()->id <= 5)
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-users fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li>
                                <a href="{!!URL::to('/usuario/create')!!}"><i class='fa fa-plus fa-fw'></i> Agregar Usuarios</a>
                            </li>
                            <li>
                                <a href="{!!URL::to('/usuario')!!}"><i class='fa fa-list-ol fa-fw'></i> Listar Usuarios</a>
                            </li>
                        </ul>
                    </li>
                @endif
                
            </ul>

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <!--<li>
                            <a href="#"><i class="fa fa-users fa-fw"></i> Usuario<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{!!URL::to('/usuario/create')!!}"><i class='fa fa-plus fa-fw'></i> Agregar</a>
                                </li>
                                <li>
                                    <a href="{!!URL::to('/usuario')!!}"><i class='fa fa-list-ol fa-fw'></i> Usuarios</a>
                                </li>
                            </ul>
                        </li>-->
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Áreas<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{!!URL::to('/area/create')!!}"><i class='fa fa-plus fa-fw'></i> Agregar</a>
                                </li>
                                <li>
                                    <a href="{!!URL::to('/area')!!}"><i class='fa fa-list-ol fa-fw'></i> Áreas</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-male fa-fw"></i><i class="fa fa-female fa-fw"></i> Oficiales<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{!!URL::to('/oficial/create')!!}"><i class='fa fa-plus fa-fw'></i> Agregar</a>
                                </li>
                                <li>
                                    <a href="{!!URL::to('/oficial')!!}"><i class='fa fa-list-ol fa-fw'></i> Oficiales</a>
                                </li>
                            </ul>
                        </li>
                        <li class="divider"></li>
                        <li class="divider"></li>
                        <li>
                            <a href="#"><i class="fa fa-map fa-fw"></i> Departamentos<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{!!URL::to('/departamento/create')!!}"><i class='fa fa-plus fa-fw'></i> Agregar</a>
                                </li>
                                <li>
                                    <a href="{!!URL::to('/departamento')!!}"><i class='fa fa-list-ol fa-fw'></i> Departamentos</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-graduation-cap fa-fw"></i> Escuelas<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{!!URL::to('/escuela/create')!!}"><i class='fa fa-plus fa-fw'></i> Agregar</a>
                                </li>
                                <li>
                                    <a href="{!!URL::to('/escuela')!!}"><i class='fa fa-list-ol fa-fw'></i> Escuelas</a>
                                </li>
                            </ul>
                        </li>
                        <li class="divider"></li>
                        <li class="divider"></li>
                        <li class="divider"></li>
                        <li class="divider"></li>
                        <li class="divider"></li>
                        <li>
                            <a href="#"><i class="fa fa-bookmark fa-fw"></i> Motivos<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{!!URL::to('/motivo/create')!!}"><i class='fa fa-plus fa-fw'></i> Agregar</a>
                                </li>
                                <li>
                                    <a href="{!!URL::to('/motivo')!!}"><i class='fa fa-list-ol fa-fw'></i> Motivos</a>
                                </li>
                            </ul>
                        </li>
                        <!--<li>
                            <a href="#"><i class="fa fa-bookmark-o fa-fw"></i> Pendientes<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{!!URL::to('/pendiente/create')!!}"><i class='fa fa-plus fa-fw'></i> Agregar</a>
                                </li>
                                <li>
                                    <a href="{!!URL::to('/pendiente')!!}"><i class='fa fa-list-ol fa-fw'></i> Pendientes</a>
                                </li>
                            </ul>
                        </li>-->


                    </ul>
                </div>
            </div>

     </nav>

        <div id="page-wrapper">
            @include('alerts.errors')
            @yield('content')
        </div>

    </div>
    
    {!!Html::script('js/jquery.min.js')!!}
    {!!Html::script('js/bootstrap.min.js')!!}
    {!!Html::script('js/metisMenu.min.js')!!}
    {!!Html::script('js/sb-admin-2.js')!!}

    @section('scripts')
    @show
    
    <!--<script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/metisMenu.min.js"></script>
    <script src="js/sb-admin-2.js"></script>-->

</body>

</html>
