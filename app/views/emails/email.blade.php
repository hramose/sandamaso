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
				color: #181E21;
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
				<p><strong>Hola {{ $nombre }}.</strong></p>
				<p>Le confirmamos que su hora en revisiones técnicas San Dámaso ha sido confirmada.</p>
				<p>Es necesario imprimir y presentar este correo @if($convenio == '1') además de un documento que acredite vínculo con la empresa asociada @endif.
				<p>Debe presentarse 10 minutos antes para una mejor atención.</p>

				<p>La reserva quedará anulada si no se presenta luego de 10 minutos de su hora agendada.</p>

				<p><u>Informacion de la reserva</u></p>
				<p><b>Planta:</b> {{ $planta }}</p>
				<p><b>Fecha:</b> {{ $fecha }} </p>
				<p><b>Hora:</b> {{ $hora }}</p>
				<p><b>Vehiculo:</b> {{ $tipo_vehiculo }}</p>
				<p><b>Patente:</b> {{ $patente }}</p>
				@if($convenio == '1')
				<p><b>Convenio:</b>{{ $nombre_empresa }}</p>
				@endif
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
