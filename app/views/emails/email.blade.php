<html>
	<head>
		<title>OWN Entel</title>
		
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
			<img src="http://www.sandamaso.cl/wp-content/themes/sandamaso/images/logo-footer.png" height="30" width="80" />
			<div class="content">
				<div class="title">{{ $nombre }} tu hora ha sido reservada</div>
				<table>
				<tbody>
					<tr>
					<th>
						Planta
					</th>
					<td>
						{{ $planta }}
					</td>
					</tr>
					<tr>
					<th>
						Fecha
					</th>
					<td>
						{{ $fecha }} {{ $hora }}
					</td>
					</tr>
					<tr>
					<th>
						Vehículo
					</th>
					<td>
						{{ $tipo_vehiculo }}, patente {{ $patente }}
					</td>
					</tr>
				</tbody>
				</table>
				<p>Recuerde llegar con 10 minutos de anticipación para una mejor atención, de lo contrario si llegase pasado 10 minutos de su hora, esta será invalidada.</p>
				<h1>Gracias por su preferencia</h1>
				<p>Debe presentar este correo al momento de presentarse en la planta de revisión</p>
			</div>
		</div>
	</body>
</html>
