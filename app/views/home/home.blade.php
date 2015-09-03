@extends('layout')

@section('head')
@stop

@section('content')
{{ Form::open(array('url' => 'reservas/buscar', 'id'=>'form_busca')) }}



 <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title" id="myModalLabel">Agendar revisión</h4>
                </div>
                <div class="modal-body">
                    <p style="margin-bottom: 25px;"><strong>Asegure una atención más expedita haciendo reserva de día y hora de atención.</strong></p>

                    <p>Reservas se realizaran desde el día 5 al día 25 de cada mes, de lunes a viernes.
                        Servicio para vehículos con dígito de placa patente correspondiente al mes en curso o mes anticipado.
                        Nos contactaremos con usted para confirmar el requerimiento, dentro de 12 horas de recibido su mensaje hasta la hora de cierre.</p>

                        <p>También solicite reserva para <a href="#" style="
                            color: #138CD9;
                            text-decoration: none;
                            transition: all 0.2s linear 0s;
                            ">Servicio de Pre Revisión</a> y verifique el estado de su vehículo cuando usted quiera.</p>

                            <p>Además participe en un sorteo especial entre todos los clientes que agenden revisión. </p>

                            <p><a href="#" style="
                                color: #138CD9;
                                text-decoration: none;
                                transition: all 0.2s linear 0s;
                                ">Ver Bases del concurso</a></p>

                            </p>Llene los campos y nos contactaremos para agendar su revisión técnica.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>
            



<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <input type="text" placeholder="Ingrese la patente (LLNNNN, LLLLNN o LLLNNN)" name="patente" id="patente" class="form-control" value="{{ $patente == '' ? '': $patente }}" required /> 
        </div>
    </div>
    <div class="col-sm-4">
        <input type="button" id="btn_patente" value="verificar">
    </div>
    <div class="col-sm-4">
        <div class="alert alert-danger hide" id="formato" role="alert"></div>
    </div>
</div>
<div class="row form_1 {{ $patente == '' ? 'hide' : '' }}">
    <div class="col-md-12" style="    margin: 30px 0;">
        <div class="col-md-4 col-sm-4">
            <div class="form-group">
                <label for="Rango de Fechas">Fecha Desde</label>
                <input type="text" name="fecha_desde" class="form-control datepicker" value="{{ $fecha_desde == '' ? '': $fecha_desde }}" required /> 
            </div>
        </div>
        <div class="col-md-4 col-sm-4">
            <div class="form-group">
                <label for="Rango de Fechas">Fecha Hasta</label>
                <input type="text" name="fecha_hasta" class="form-control datepicker" value="{{ $fecha_hasta == '' ? '': $fecha_hasta }}" required />
            </div>
        </div>
        <div class="col-md-4 col-sm-4">
            <div class="form-group">
                <label for="Planta">Planta</label>
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="planta" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 100%;">
                        <span id="planta_nombre">{{ $planta == '' ? 'Planta' : $planta }}</span>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="planta">
                        @foreach($plantas as $item)
                        <li><a href="#" class="val_planta" data-val="{{ $item->id }}">{{ $item->nombre }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <label class="hide" id="planta_alert" style="color:red">Debe seleccionar una planta</label>
            </div>
            <input type="hidden" name="id_planta" id="id_planta" value="{{ $id_planta == '' ? '' : $id_planta }}" />
        </div>
        <button type="button" id="btn_submit" class="btn btn-primary">Buscar</button>
    </div>
    {{ Form::close() }}
    @if($fechas_reservar)
    <div class="row">
        <div class="col-sm-12">
            <br/>
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Fechas con horas disponibles</div>
                <div class="panel-body">
                    <p>Haz click sobre una fecha para ver las horas disponibles.</p>
                </div>

                <!-- Table -->
                <table class="table">
                    <tbody>
                        @foreach(array_chunk($fechas_reservar, 5) as $items)
                        <tr>
                            @foreach($items as $item)
                            <td> 
                                <a href="{{ URL::to('/') }}/horasdisponibles/{{ $item }}/{{ $id_planta }}/{{ $patente }}" class="btn btn-default">{{ date('d-m-Y', strtotime($item)) }}</a>
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    @if($carga == 1)
    <br/>
    <div class="alert alert-info" role="alert">Reserva tu hora buscando por un rango de fechas.</div>
    @else
    <br/>
    <div class="alert alert-warning" role="alert">No se encontraron resultados para esta busqueda, vuelve a intentarlo con otro rango de fechas</div>
    @endif

    @endif


            <script type="text/javascript">


            setTimeout(function(){$('#myModal').modal('show'); },0000); 


            $(function() {
                $('.val_planta').click(function(){
                    var texto = $(this).text();
                    $('#id_planta').val($(this).attr('data-val'));
                    $('#planta_nombre').text(texto);
                });

                $('#btn_submit').click(function(){
                    if($('#id_planta').val() == ''){
                        $('#planta_alert').removeClass('hide');
                    }else{
                        $('#planta_alert').addClass('hide');
                        $('#form_busca').submit();
                    }

                });

                function validaForm(){
                    var error = "";
                    var ok = true;
                    if($("#patente").val().length != 6){
                        error += "La Patente debe tener formato LLNNNN o formato LLLLNN.\n";
                        ok = false;
                    }
                    else{
                        var esPatenteAntigua = true;
                        var esPatenteNueva = true;
                        var esPatenteRemolque = true;
                        var paten = $("#patente").val();
// Primer caracter
if(!isAlpha(paten.substring(0,1))){
    esPatenteAntigua = false;
    esPatenteNueva = false;
    esPatenteRemolque = false;
}
// Segundo caracter
if(!isAlpha(paten.substring(1,2))){
    esPatenteAntigua = false;
    esPatenteNueva = false;
    esPatenteRemolque = false;
}
// Tercer caracter
if(!isNumeric(paten.substring(2,3))){
    esPatenteAntigua = false;
}
if(!isAlpha(paten.substring(2,3))){
    esPatenteNueva = false;
    esPatenteRemolque = false;
}
// Cuarto caracter
if(!isNumeric(paten.substring(3,4))){
    esPatenteAntigua = false;
    esPatenteRemolque = false;
}
if(!isAlpha(paten.substring(3,4))){
    esPatenteNueva = false;
}
// Quinto caracter
if(!isNumeric(paten.substring(4,5))){
    esPatenteAntigua = false;
    esPatenteNueva = false;
    esPatenteRemolque = false;
}
// Sexto caracter
if(!isNumeric(paten.substring(5,6))){
    esPatenteAntigua = false;
    esPatenteNueva = false;
    esPatenteRemolque = false;
}
if(!esPatenteAntigua && !esPatenteNueva && !esPatenteRemolque){
    error += "La Patente debe tener formato LLNNNN, LLLLNN o LLLNNN.\n";
    ok = false;
}
}
if(ok)
    return true;
$('#formato').removeClass('hide').text(error);
return false;
}
var letters="abcdefghijklmnopqrstuvwxyz"
var LETTERS="ABCDEFGHIJKLMNOPQRSTUVWXYZ"
function isAlpha(c) {
    if(letters.indexOf(c)>=0 || LETTERS.indexOf(c)>=0) return true;
    return false;
}
var numbers="0123456789"
function isNumeric(c) {
    if(numbers.indexOf(c)>=0) return true;
    return false;
}

function validaDate(){
    var paten = $("#patente").val();
    var ultimo = paten.substring(5,6);
    var d = new Date();
    var m = d.getMonth() + 1;
    var y = d.getFullYear();
    var entra = true;

//meses
switch(m) {
    case 1:
    if(ultimo != 9 || ultimo != 0){
        entra = false;
    }
    break;
    case 2:
if(ultimo != 0 || ultimo != 1){ // 9
    entra = false;
}
break;
case 3:
if(ultimo != 1){ // 0 y 9
    entra = false;
}
break;
case 4:
if(ultimo != 1 || ultimo != 2){ // 0 y 9
    entra = false;
}
break;
case 5:
if(ultimo != 2 || ultimo != 3){ // 1 , 0 y 9
    entra = false;
}
break;
case 6:
if(ultimo != 3 || ultimo != 4){ // 9,0,1 y 2
    entra = false;
}
break;
case 7:
if(ultimo != 4 || ultimo != 5){
    entra = false;
}
break;
case 8:
if(ultimo != 5 || ultimo != 6){
    entra = false;
}
break;
case 9:
if(ultimo != 6 || ultimo != 7){
    entra = false;
}
break;
case 10:
if(ultimo != 7 || ultimo != 8){
    entra = false;
}
break;
case 11:
if(ultimo != 8){
    entra = false;
}
break;
case 12:
if(ultimo != 9){
    entra = false;
}
break;
default:
break;
}
return entra;
}


$('#btn_patente').click(function(){
    if(validaForm() || validaDate()){
        $('.form_1').removeClass('hide');
        $('#formato').addClass('hide');

    }
});
var today = new Date();
$('.datepicker').datepicker({
    format: 'dd-mm-yyyy', 
    startDate: new Date(today.getFullYear(), today.getMonth(), today.getDate()), 
    endDate: '+1m', 
    autoclose: true
});
});
</script>
@stop
