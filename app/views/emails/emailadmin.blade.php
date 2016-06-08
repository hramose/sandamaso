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
				<div class="title">Reserva confirmada</div>
				<table>
				<tbody>
					<tr>
					<th>
						Nombre
					</th>
					<td>
						{{ $nombre }}
					</td>
					</tr>
					<tr>
					<th>
						Email
					</th>
					<td>
						{{ $email }}
					</td>
					</tr>
					<tr>
					<th>
						Telefono
					</th>
					<td>
						{{ $telefono }}
					</td>
					</tr>
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
						Patente
					</th>
					<td>
						{{ $patente }}
					</td>
					</tr>
					@if($convenio == '1')
						<tr>
							<th>
								Convenio
							</th>
							<td>
								{{ $nombre_empresa }}
							</td>
						</tr>
					@endif
					<tr>
						<th>
							Tipo Vehiculo
						</th>
						<td>
							{{ $tipo_vehiculo }}
						</td>
					</tr>
					<tr>
						<th>
							Tipo Revision
						</th>
						<td>
							{{ $tipo_revision }}
						</td>
					</tr>
					<tr>
						<th>
							Comentario
						</th>
						<td>
							{{ $comentario }}
						</td>
					</tr>
				</tbody>
				</table>
			</div>
		</div>
	</body>
</html>
