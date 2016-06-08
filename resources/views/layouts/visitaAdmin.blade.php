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
                <a class="navbar-brand cl1" href="/visitaAdmin"><img src="/img/logo.png" width="85px" height="40px"></a>
                <a class="navbar-brand cl2" href="/visitaAdmin">Visitas</a>
            </div>
           

            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <a id="flip" data="off"><i class="fa fa-chevron-up"></i></a>
                </li>
                 <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        {!!Auth::user()->name!!}
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="/menu"><i class="fa fa-th fa-fw"></i> Regresar al menú</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{!!URL::to('logout')!!}"><i class="fa fa-sign-out fa-fw"></i> Cerrar Sesión</a>
                        </li>
                    </ul>
                </li>
            </ul>

        </nav>

        <div id="page">
            @include('visita.nav')
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

    <script type="text/javascript">
        $('#flip').on('click', function(){
            if ($('#flip').attr('data') == 'on') {
                $('#flip').attr('data', 'off');
                $('#flip i').attr('class', 'fa fa-chevron-up');
            }else{
                $('#flip').attr('data', 'on');
                $('#flip i').attr('class', 'fa fa-chevron-down');
            }
            $('#panel').toggle(1000);
        });
    </script>

</body>

</html>
