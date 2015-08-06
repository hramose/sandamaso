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
<meta name="description" content="Reserva de horas San Damasco">
<meta name="author" content="github.com/davila7">
<meta property="og:title" content=""/>
<meta property="og:image" content=""/>
<meta property="og:description" content=""/>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="icon" href="/favicon.ico" type="image/x-icon">
 <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/datepicker.css') }}" />
        <script src="{{ asset('js/modernizr.js') }}"></script>

        <!--[if lt IE 9]>
            <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        {{ Rapyd::styles() }}
</head>
  <body>
    <input type="hidden" id="base_url" value="{{ URL::to('/'); }}" />
    <div id="top-nav" class="navbar navbar-default navbar-static-top">
    <div class="container-fluid" >
        <div class="navbar-header">
          <a class="navbar-brand" href="{{ URL::to('/') }}">Reserva de horas</a>
        </div>
    </div>
  </div>
<!-- /Header -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset('js/bootstrap-datepicker.es.js') }}"></script>
        <div class="container">
            @yield('content')
        </div>
          
          {{ Rapyd::scripts() }}
  </body>
</html>
