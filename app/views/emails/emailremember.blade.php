<html>
	<head>
		<title>San Damaso</title>
		
		<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

		<style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				color: #B0BEC5;
				display: table;
				font-weight: 50;
				font-family: 'Lato';
				display: block;
			}

			.container {
				text-align: center;
				display: table-cell;
				vertical-align: middle;
			}

			.content {
				text-align: center;
				display: inline-block;
			}

			.title {
				font-size: 96px;
				margin-bottom: 40px;
			}

			.quote {
				font-size: 24px;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<p><strong>Estimado {{ $nombre }}.</strong></p>
				<p>Le recordamos que el día {{ $fecha }} usted tiene una hora reservada en la planta {{ $nombre_planta }}.</p>
				<p>Para hacer efectiva atención debe llegar con este correo impreso y se sugiere que se presente 10 minutos antes de su hora agendada.</p>
				<p>La reserva quedará anulada si no se presenta luego de 10 minutos de su hora agendada.</p>

				<p><u>Información de la reserva</u></p>
				<p><b>Planta:</b> {{ $nombre_planta }}</p>
				<p><b>Fecha:</b> {{ $fecha }} </p>
				<p><b>Hora:</b> {{ $hora }}</p>
				<p><b>Vehiculo:</b> {{ $tipo_vehiculo }}</p>
				<p><b>Patente:</b> {{ $patente }}</p>

				<p><u>¿Cómo llegar?</u></p>
				<a href="{{ $url_map }}">Click acá para ver el mapa</a>
				<br>
				<img src="{{ asset('img/plantas/'.$image_map) }}" />

				<p>Gracias por su preferencia!</p>

				<a href="http//www.sandamaso.cl"><p>Revisiones Técnicas San Dámaso</p></a>
				<p>www.sandamaso.cl</p>
				<a href="http//www.sandamaso.cl"><img src="http://www.sandamaso.cl/wp-content/themes/sandamaso/images/logo-footer.png" height="80" width="200" /></a>
			</div>
		</div>
	</body>
</html>
