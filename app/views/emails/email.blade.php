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
				<p><strong>Hola {{ $nombre }}.</strong></p>
				<p>Le confirmamos que su hora en revisiones técnicas San Dámaso ha sido confirmada.</p>
				<p>Es necesario imprimir este correo y presentarse 10 minutos antes para una mejor atención.</p>
				<p>La reserva quedará anulada si no se presenta luego de 10 minutos de su hora agendada.</p>

				<p><u>Informacion de la reserva</u></p>
				<p><b>Planta:</b> {{ $planta }}</p>
				<p><b>Fecha:</b> {{ $fecha }} </p>
				<p><b>Hora:</b> {{ $hora }}</p>
				<p><b>Vehiculo:</b> {{ $tipo_vehiculo }}</p>
				<p><b>Patente:</b> {{ $patente }}</p>

				<p><u>¿Cómo llegar?</u></p>
				<a href="{{ $url_map }}">Click acá para ver el mapa</a>
				<br>
				<img src="{{ asset('img/plantas/'.$image_map) }}" />
				
				<?php 
				/*switch($id_planta){
					case 1:
						//Valparaiso B
						echo '';
						break;
					case 2:
						//Antofagasta
						echo '<a href="https://www.google.com/maps/d/u/0/viewer?mid=zScdsfNHORgo.kLK64e8verlc">Click para ver el mapa</a>
						<br>
						<img src="'.asset("img/plantas/antofagasta.png").'" />';
						break;
					case 3:
						//Calma
						echo '<a href="https://www.google.com/maps/d/u/0/viewer?mid=zScdsfNHORgo.knYhL-uea7tQ">Click para ver el mapa</a>
						<br>
						<img src="'.asset("img/plantas/calama.png").'" />';
						break;
					case 4:
						//chañaral A-B
					 	echo '<a href="https://www.google.com/maps/d/u/0/viewer?mid=zScdsfNHORgo.kmAh9vJJuR0k">Click para ver el mapa</a>
					 	<br>
						<img src="'.asset("img/plantas/chanaral.png").'" />';
					    break;
					case 5:
						//copiapo A-B
						echo '<a href="https://www.google.com/maps/d/u/0/viewer?mid=zScdsfNHORgo.k9O2yYdJnio8">Click para ver el mapa</a>
						<br>
						<img src="'.asset("img/plantas/copiapo.png").'" />';
						break;
					case 6:
						//Quilicura
						echo '<a href="https://www.google.com/maps/d/u/0/viewer?mid=zScdsfNHORgo.kyIoYXdhPHtY">Click para ver el mapa</a>
						<br>
						<img src="'.asset("img/plantas/quilicura.png").'" />';
						break;
					case 7:
						//Viña del mar
						echo '<a href="https://www.google.com/maps/d/u/0/viewer?mid=zScdsfNHORgo.kuoL0WlNJgoM">Click para ver el mapa</a>
						<br>
						<img src="'.asset("img/plantas/vina.png").'" />';
						break;
					case 8:
						//Colina
						echo '<a href="https://www.google.com/maps/d/u/0/viewer?mid=zScdsfNHORgo.koRQoFack-g8">Click para ver el mapa</a>
						<br>
						<img src="'.asset("img/plantas/colina.png").'" />';
						break;
					default:
						echo '<a href="https://www.google.com/maps/d/u/0/viewer?mid=zScdsfNHORgo.koRQoFack-g8">Click para ver el mapa</a>
						<br>
						<img src="'.asset("img/plantas/colina.png").'" />';
					} */?>

				<p>Gracias por su preferencia!</p>

				<a href="http//www.sandamaso.cl"><p>Revisiones Técnicas San Dámaso</p></a>
				<p>www.sandamaso.cl</p>

				<a href="http//www.sandamaso.cl"><img src="http://www.sandamaso.cl/wp-content/themes/sandamaso/images/logo-footer.png" height="80" width="200" /></a>
			</div>
		</div>
	</body>
</html>
