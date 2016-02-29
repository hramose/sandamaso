@extends('layout')

@section('head')
@stop

@section('content')
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
    border: solid #3B97BE;
">
<h1 style="color: #3B5380;">Hora Reservada!</h1>
<h2>Se ha enviado un correo a <strong>{{ $email }}</strong> con la información de su reserva.</h2>
<p>Debe presentar el correo al momento de presentarse en la planta de revisión</p>
<p>Nombre: {{ $nombre }}</p>
<p>Fecha: {{ date('d-m-Y',strtotime($fecha)) }} {{ $hora }}</p>
<p>Planta: {{ $planta }}</p>
<br>
<br>
<p>Recuerde llegar con 10 minutos de anticipación para una mejor atención, de lo contrario si llegase pasado 10 minutos de su hora, esta será invalidada.</p>
<h3>Gracias por su preferencia.</h3>
</div>
</div>
</div>
@stop
