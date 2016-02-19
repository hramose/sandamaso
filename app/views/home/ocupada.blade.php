@extends('layout')

@section('head')
@stop

@section('content')
<div class="row">
<div class="col-sm-12">
<div class="jumbotron" style="
    background-color: white;
    border: solid #3B97BE;
">
<h1 style="color: #3B5380;">Error</h1>
<h3>Esta patente ya tiene una reserva para este día. Por favor vuelva a intentarlo.</h3>
<a href="{{ URL::to('/') }}" class="btn btn-default" style="
    margin: 20px 0px;
">Volver a Reservar</a>
</div>
</div>
</div>
@stop
