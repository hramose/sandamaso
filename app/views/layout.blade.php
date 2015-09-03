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
  <meta property="og:title" content=""/>
  <meta property="og:image" content=""/>
  <meta property="og:description" content=""/>
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
  <link rel="icon" href="/favicon.ico" type="image/x-icon">
  <style type="text/css" media="screen">
  @import url( http://www.sandamaso.cl/wp-content/themes/sandamaso/style.css );
  @import url( http://www.sandamaso.cl/wp-content/themes/sandamaso/css/home.css );
  </style>
  <link rel="stylesheet" type="text/css" href="http://www.sandamaso.cl/wp-content/themes/sandamaso/css/responsive.css?1438816669" />
  <link rel="stylesheet" type="text/css" href="http://www.sandamaso.cl/wp-content/themes/sandamaso/css/sidebar.css?1438816669" />
  <link rel="stylesheet" type="text/css" media="screen" href="http://www.sandamaso.cl/wp-content/themes/sandamaso/css/menu.css?1438816669" />
  <link rel="stylesheet" type="text/css" media="screen" href="http://www.sandamaso.cl/wp-content/themes/sandamaso/css/form.css?1438816669" />
  <link rel="stylesheet" type="text/css" media="screen" href="http://www.sandamaso.cl/wp-content/themes/sandamaso/css/flexslider.css?1438816669" />
  <link rel="stylesheet" type="text/css" media="screen" href="http://www.sandamaso.cl/wp-content/themes/sandamaso/css/meanmenu.css?1438816669" />
  <link rel="stylesheet" type="text/css" media="screen" href="http://www.sandamaso.cl/wp-content/themes/sandamaso/css/flaticon.css?1438816669" />
  <link rel="stylesheet" type="text/css" media="screen" href="http://www.sandamaso.cl/wp-content/themes/sandamaso/css/jquery.fancybox-1.3.4.css?1438816669" />
  <script type='text/javascript' src='http://www.sandamaso.cl/wp-includes/js/jquery/jquery.js?ver=1.11.1'></script>
  <script type='text/javascript' src='http://www.sandamaso.cl/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>
  <link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://www.sandamaso.cl/xmlrpc.php?rsd" />
  <link rel="wlwmanifest" type="application/wlwmanifest+xml" href="http://www.sandamaso.cl/wp-includes/wlwmanifest.xml" /> 
  <meta name="generator" content="WordPress 4.0" />
  <style type="text/css">.arve-thumb-wrapper { max-width: 300px; }.arve-normal-wrapper.alignleft, .arve-normal-wrapper.alignright, .arve-normal-wrapper.aligncenter { max-width: 400px; }</style>

  <link href='http://fonts.googleapis.com/css?family=Oswald:300,400' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>

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
  <input type="hidden" id="base_url" value="{{ URL::to('/'); }}" />

  <!-- /Header -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
  <script src="{{ asset('js/bootstrap-datepicker.es.js') }}"></script>




  <header>
    <div class="container head">
      <a href="http://www.sandamaso.cl" title="San Damaso Revisiones Técnicas"><h1>San Damaso Revisiones Técnicas</h1></a>

      <nav id="principal">
        <div class="menu-principal-container"><ul id="menu-principal" class="sf-menu dropdown"><li id="menu-item-5" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-5"><a href="http://www.sandamaso.cl/">Inicio</a></li>
          <li id="menu-item-52" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-52"><a href="http://www.sandamaso.cl/plantas/">Plantas</a></li>
          <li id="menu-item-101" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-101"><a href="http://www.sandamaso.cl/revision/">Revisión</a>
            <ul class="sub-menu">
              <li id="menu-item-105" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-105"><a href="http://www.sandamaso.cl/revision/proceso-de-revision/">Proceso de Revisión</a></li>
              <li id="menu-item-104" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-104"><a href="http://www.sandamaso.cl/revision/equipos-y-proceso-rt/">Equipos y proceso RT</a></li>
              <li id="menu-item-286" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-286"><a href="http://www.sandamaso.cl/revision/pre-revision-tecnica/">Pre Revisión Técnica</a></li>
              <li id="menu-item-213" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-213"><a href="http://www.sandamaso.cl/revision/senal-online/">Señal online</a></li>
              <li id="menu-item-277" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-277"><a href="http://www.sandamaso.cl/revision/como-llegar/">¿Cómo llegar?</a></li>
              <li id="menu-item-102" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-102"><a href="http://www.sandamaso.cl/revision/documentos-necesarios/">Documentos necesarios</a></li>
            </ul>
          </li>
          <li id="menu-item-120" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-120"><a href="http://www.sandamaso.cl/servicios/">Servicios</a>
            <ul class="sub-menu">
              <li id="menu-item-125" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-125"><a href="http://www.sandamaso.cl/servicios/horarios-de-atencion/">Horarios de atención</a></li>
              <li id="menu-item-123" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-123"><a href="http://www.sandamaso.cl/servicios/calendario-de-atencion/">Calendario de atención</a></li>
              <li id="menu-item-122" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-122"><a href="http://www.sandamaso.cl/servicios/tarifas-de-servicios/">Tarifas de servicios</a></li>
              <li id="menu-item-333" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-333"><a href="http://www.sandamaso.cl/servicios/educacion-al-usuario/">Educación al usuario</a></li>
              <li id="menu-item-121" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-121"><a href="http://www.sandamaso.cl/servicios/preguntas-frecuentes/">Preguntas frecuentes</a></li>
            </ul>
          </li>
          <li id="menu-item-134" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-134"><a href="http://www.sandamaso.cl/empresa/">Empresa</a>
            <ul class="sub-menu">
              <li id="menu-item-136" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-136"><a href="http://www.sandamaso.cl/empresa/politica-de-la-empresa/">Política de la empresa</a></li>
              <li id="menu-item-135" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-135"><a href="http://www.sandamaso.cl/empresa/organigrama/">Organigrama</a></li>
            </ul>
          </li>
          <li id="menu-item-140" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-140"><a href="http://www.sandamaso.cl/contacto/">Contacto</a>
            <ul class="sub-menu">
              <li id="menu-item-13" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-13"><a href="http://www.sandamaso.cl/contacto/escribanos/">Escríbanos</a></li>
              <li id="menu-item-174" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-174"><a href="http://www.sandamaso.cl/contacto/agendar-revision/">Agendar revisión</a></li>
              <li id="menu-item-173" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-173"><a href="http://www.sandamaso.cl/contacto/sugerencias-o-reclamos/">Sugerencias o reclamos</a></li>
            </ul>
          </li>
        </ul></div>    </nav>
      </div>
    </header>
    <div class="container">
      <h1>
        Agenda tu revision
      </h1>
    </div>



    <!-- Modal -->


    <div class="container">
      @yield('content')
    </div>

    <figure class="ico-home">
      <div class="container ico-align" style="padding:0px;">
        <section class="ico-blocks">
          <div class="textwidget">
            <p style="text-align: center;">
              <a title="Precios" href="http://www.sandamaso.cl/servicios/tarifas-de-servicios/">
                <img class="alignnone size-full wp-image-26" src="http://www.sandamaso.cl/wp-content/uploads/2014/09/ico-precios.png" alt="ico-como_llegar" width="66" height="50" />
              </a>
            </p>
            <h4 style="text-align: center;">
              <a title="Precios" href="http://www.sandamaso.cl/servicios/tarifas-de-servicios/">
                Tarifas de Servicios
              </a>
            </h4>
            <p style="text-align: center;">
              <a title="Precios" href="http://www.sandamaso.cl/servicios/tarifas-de-servicios/">
                Conozca los valores de los servicios de revisión técnica
              </a>
            </p>
          </div>
        </section>
        <section class="ico-blocks">
          <div class="textwidget">
            <p style="text-align: center;">
              <a title="Sugerencias" href="http://www.sandamaso.cl/contacto/sugerencias-o-reclamos/">
                <img class="alignnone size-full wp-image-27 aligncenter" src="http://www.sandamaso.cl/wp-content/uploads/2014/09/ico-reclamos.png" alt="ico-documentos" width="66" height="50" />
              </a>
            </p>
            <h4 style="text-align: center;">
              <a title="Sugerencias" href="http://www.sandamaso.cl/contacto/sugerencias-o-reclamos/">
                Sugerencias o reclamos
              </a>
            </h4>
            <p style="text-align: center;">
              <a title="Sugerencias" href="http://www.sandamaso.cl/contacto/sugerencias-o-reclamos/">
                Escríbanos sus opiniones e impresiones de nuestros servicios
              </a>
            </p>
          </div>
        </section>
        <section class="ico-blocks">
          <div class="textwidget">
            <p style="text-align: center;">
              <a title="Preguntas" href="http://www.sandamaso.cl/servicios/preguntas-frecuentes/">
                <img class="alignnone size-full wp-image-28" src="http://www.sandamaso.cl/wp-content/uploads/2014/09/ico-preguntas_frecuentes.png" alt="ico-preguntas_frecuentes" width="66" height="50" />
              </a>
            </p>
            <h4 style="text-align: center;">
              <a title="Preguntas" href="http://www.sandamaso.cl/servicios/preguntas-frecuentes/">
                Preguntas Frecuentes
              </a>
            </h4>
            <p style="text-align: center;">
              <a title="Preguntas" href="http://www.sandamaso.cl/servicios/preguntas-frecuentes/">
                Aquí encontrará respuestas a dudas recurrentes
              </a>
            </p>
          </div>
        </section>


        <section class="ico-blocks">
          <div class="textwidget">
            <p style="text-align: center;">
              <a title="Contacto" href="http://www.sandamaso.cl/contacto/escribanos/">
                <img class="alignnone size-full wp-image-29" src="http://www.sandamaso.cl/wp-content/uploads/2014/09/ico-contacto.png" alt="ico-contacto" width="66" height="50" />
              </a>
            </p>
            <h4 style="text-align: center;">
              <a title="Contacto" href="http://www.sandamaso.cl/contacto/escribanos/">
                Contáctenos
              </a>
            </h4>
            <p style="text-align: center;">
              <a title="Contacto" href="http://www.sandamaso.cl/contacto/escribanos/">
                y resolveremos sus dudas
              </a>
            </p>
          </div>
        </section>

      </div>
    </figure>



    <footer>
      <div class="container foot zero-pad" >
        <div class="logo-footer">
          <a href="http://www.sandamaso.cl" /><img src="http://www.sandamaso.cl/wp-content/themes/sandamaso/images/logo-footer.png" alt="logo-footer" width="197" height="50" /></a>
        </div><!-- end logo footer -->
        <div class="credits">
          Oficina Central: Blanco 1623 - Of. 1501 - Valparaíso / Fonos: 32 - 274 62 25 / 32 - 274 62 26
        </div><!-- end credits -->
      </div><!-- end container foot -->
    </footer><!-- end footer -->



    {{ Rapyd::scripts() }}



  </script>


<!--<script src="http://www.sandamaso.cl/wp-content/themes/sandamaso/js/jquery-1.7.1.min.js"></script>

  <!-- FlexSlider JS -->
<!--<script src="http://www.sandamaso.cl/wp-content/themes/sandamaso/js/jquery.flexslider.js"></script>
  <!-- Mean Menu JS -->
<!--<script src="http://www.sandamaso.cl/wp-content/themes/sandamaso/js/jquery.meanmenu.js"></script> 
  <!-- FancyBox JS -->
<!--<script src="http://www.sandamaso.cl/wp-content/themes/sandamaso/js/jquery.mousewheel-3.0.4.pack.js"></script>
<script src="http://www.sandamaso.cl/wp-content/themes/sandamaso/js/jquery.fancybox-1.3.4.pack.js"></script>

<!-- link to the JavaScript files (hoverIntent is optional) -->
<!--<script src="http://www.sandamaso.cl/wp-content/themes/sandamaso/js/hoverIntent.js"></script>
<script src="http://www.sandamaso.cl/wp-content/themes/sandamaso/js/superfish.js"></script>

<!-- AWS FUNCIONES -->
<!--<script type="text/javascript" src="http://www.sandamaso.cl/wp-content/themes/sandamaso/js/jquery.awsfunciones.js" ></script>-->
</body>
</html>
