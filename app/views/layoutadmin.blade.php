<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"/> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><html lang="en" class="no-js"><![endif]-->
<html>
<head>
    <title>Reserva de horas.</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content="Reserva de horas sandamaso">
    <meta name="author" content="github.com/davila7">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datepicker.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.css') }}" />
    <script src="{{ asset('js/modernizr.js') }}"></script>

        <!--[if lt IE 9]>
            <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
            <![endif]-->
            {{ Rapyd::styles() }}
        </head>
        <body>
            
          <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
          <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
          <script src="{{ asset('js/bootstrap-datepicker.es.js') }}"></script>
             <!-- Static navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('admin') }}">Panel de Control</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">

            <ul class="nav navbar-nav navbar-right">
              <li>@if (Auth::check())
                  <a href="{{ URL::to('/logout'); }}"><i class="glyphicon glyphicon-lock"></i> Cerrar Sesión</a>
                 @else
                 <li><a href="#" data-toggle="modal" data-target="#modalIS"><i class="glyphicon glyphicon-hand-right"></i> Iniciar Sesión</a></li>
                 @endif</li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
                
    <div class="container">
        @yield('content')
    </div>

  {{ Rapyd::scripts() }}

</body>
</html>
