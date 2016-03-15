@extends('layout')

@section('head')
@stop

@section('content')
<?php
    header('X-Frame-Options: GOFORIT'); 
?>
<div class="row">
	<div class="col-sm-12">
	<a href="{{ URL::to('/') }}" class="btn btn-default" style="
	    margin: 20px 0px;
	">Volver a Home</a>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="jumbotron" style="
		    background-color: white;
		    border: solid #3B97BE;">
			<h1 style="color: #3B5380;">Hora Reservada!</h1>
			<h2>Se ha enviado un correo a <strong>{{ $email }}</strong> con la información de su reserva.</h2>
				<p>Debe presentar el correo al momento de presentarse en la planta de revisión</p>
				<p>Nombre: {{ $nombre }}</p>
				<p>Fecha: {{ date('d-m-Y',strtotime($fecha)) }} {{ $hora }}</p>
				<p>Planta: {{ $planta }}</p>
				<br>
				<br>
				<p>Recuerde llegar con 10 minutos de anticipación para una mejor atención, de lo contrario si llegase pasado 10 minutos de su hora, esta será invalidada.</p>
				<p>¿Cómo llegar?</p>
				<iframe src="{{ $url_map }}" width="640" height="480"></iframe>
			<h3>Gracias por su preferencia.</h3>
			<div class="panel panel-success">
				<div class="form-group form-email">
				    <label>Comparte con tus amigos para que puedan reservar una hora por nuestro sitio.</label>
				    <input type="email" class="form-control" id="email_share" placeholder="Ingresa el email">
			  	</div>
			  <button type="button" id="share-button" class="btn btn-default">Enviar correo</button>
			  <div class="alert alert-success" style="display: none;" role="alert">
					Su mensaje ha sido enviado correctamente.
				</div>
				<div class="alert alert-danger" style="display: none;" role="alert">
					Ocurrió un error, verifique que el correo esté bien escrito y vuelva a intentarlo.
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#share-button').click(function(){
		var url = "{{ URL::to('/') }}/email-to-share";
		var email = $('#email_share').val();
		$.post(url, { email: email })
			.done(function() {
				$('.alert-danger').hide();
		    	$('.alert-success').show('fast');
		  	})
		  	.fail(function() {
		  		$('.alert-success').hide();
		    	$('.alert-danger').show('fast');
	  	});
	});
	

</script>
@stop
