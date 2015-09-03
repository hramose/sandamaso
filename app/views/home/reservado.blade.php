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
<h2>Se ha enviado un correo a <strong>{{ $email }}</strong> con la información de su reserva.
<p>Nombre: {{ $nombre }}</p>
<p>Fecha: {{ $fecha }} {{ $hora }}</p>
<p>Planta: {{ $planta }}</p>
<h3>Gracias por su preferencia.</h3>
</div>
</div>
</div>
@stop
