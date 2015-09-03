@extends('layout')

@section('head')
@stop

@section('content')
       {{ Form::open(array('url' => 'reservas/reservar', 'id'=>'form_reserva')) }}
    <input type="hidden" name="fecha" value="{{ $fecha }}" />
    <input type="hidden" name="hora" id="hora" value="" />
    <input type="hidden" name="planta" value="{{ $planta }}" />
    <div class="row">
        <div class="col-md-12">
            <h3>Horas disponibles para {{ $planta }} el {{ date('d-m-Y',strtotime($fecha)) }}</h3>
            <p>Patente: {{ $patente }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                @if(count($horas_reservar) == 0)
                    <label for="">Reservas llenas, vuelva a buscar otra fecha.</label>
                @else
                    <label for="">Selecciona la hora de la reserva</label>
                    <div class="btn-group" role="group" aria-label="...">
                          @foreach($horas_reservar as $item)
                            <button type="button" class="btn btn-default hora_select">{{ $item }}</button>
                          @endforeach
                    </div>
                @endif
            </div>
            <div class="alert hide alert-danger" id="hora_alert" role="alert">Debe seleccionar una hora</div>
        </div>
        <div class="col-md-6">
             <div class="alert hide alert-danger" id="campos_alert" role="alert">Complete los campos requeridos</div>
            <div class="col-sm-6">
            <div class="form-group">
                <label for="nombre">Nombre (requerido)</label>
                <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre" required>
            </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="email">Email (requerido)</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="telefono">Telefono (requerido)</label>
                <input type="text" name="telefono" class="form-control" id="telefono" placeholder="Telefono" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="tipo_vehiculo">Tipo de Vehículo (requerido)</label>
                <select class="form-control" name="tipo_vehiculo" id="tipo_vehiculo" >
                  <option value="">Seleccione una opición</option>
                  <option value="Automovil">Automovil</option>
                  <option value="Camioneta">Camioneta</option>
                  <option value="Motocicleta">Motocicleta</option>
                </select>
            </div>
        </div>
    </div>
        <input type="hidden" value="{{ $patente }}" name="patente" id="patente" placeholder="Patente" >
    <div class="row">
        <div class="col-md-12">
<div class="text-center">
            <button type="button" id="reservar" class="btn btn-primary">Reservar</button>

        <a href="{{ URL::to('/') }}" class="btn btn-default">Volver a Buscar</a>
</div>
        </div>
    </div>
    {{ Form::close() }}

<script type="text/javascript">
$(function() {

    $('#reservar').click(function(){
        if($('#hora').val() == ""){
            $('#hora_alert').removeClass('hide');
        }else{
            $('#hora_alert').addClass('hide');
            
            if($('#nombre').val() == "" || $('#email').val() == "" || $('#telefono').val() == "" || $('#tipo_vehiculo').val() == ""){
                $('#campos_alert').removeClass('hide');
            }else{
                $('#campos_alert').addClass('hide');
                $('#form_reserva').submit();    
            }
        }
    });

    $('.hora_select').click(function(){
        $('.hora_select').removeClass('btn-primary').addClass('btn-default');
        $(this).removeClass('btn-default').addClass('btn-primary');
        var texto = $(this).text();
        $('#hora').val(texto);
    });
});
</script>


@stop
