@extends('layout')

@section('head')
@stop

@section('content')
    <div class="row">
        <div class="col-sm-12">
        <a href="{{ URL::to('/') }}" class="btn btn-default">Volver a Home</a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="jumbotron">
              <h1>Hora Reservada!</h1>
              <h2>Se ha enviado un correo a <strong>{{ $email }}</strong> con la información de su reserva.
              <p>Nombre: {{ $nombre }}</p>
              <p>Fecha: {{ $fecha }} {{ $hora }}</p>
            </div>
        </div>
    </div>
@stop
