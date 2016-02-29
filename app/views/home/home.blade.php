@extends('layout')

@section('head')
@stop

@section('content')

<div class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Mapa</h4>
      </div>
      <div class="modal-body">
        <p>One fine body&hellip;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


{{ Form::open(array('url' => 'reservas/buscar', 'id'=>'form_busca')) }}




<div class="modal fade" id="myModal" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title" id="myModalLabel">Agendar revisión</h4>
            </div>
            <div class="modal-body">
                <p style="margin-bottom: 25px;"><strong>Asegure una atención más expedita haciendo reserva de día y hora de atención.</strong></p>

                <p>Nos contactaremos con usted para confirmar el requerimiento, dentro de 12 horas de recibido su mensaje hasta la hora de cierre.</p>

                    <p>También solicite reserva para <a href="http://www.sandamaso.cl/revision/pre-revision-tecnica/" style="
                        color: #138CD9;
                        text-decoration: none;
                        transition: all 0.2s linear 0s;
                        ">Servicio de Revisión Previa</a> y verifique el estado de su vehículo cuando usted quiera.</p>
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
            <h2 style="color:red">Recuerde no reservar hora los días feriados.</h2>
            <p>Disponemos de 3 meses para reserva de hora</p>
            <div class="col-md-12" style="    margin: 30px 0;">
                <div class="col-md-4 col-sm-4">
                    <div class="form-group">
                        <label for="Rango de Fechas" id="fecha_dl">Fecha Desde</label>
                        <input type="text" name="fecha_desde" id="fecha_d" class="form-control datepicker" value="{{ $fecha_desde == '' ? '': $fecha_desde }}" required /> 
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="form-group">
                        <label for="Rango de Fechas" id="fecha_hl">Fecha Hasta</label>
                        <input type="text" name="fecha_hasta" id="fecha_h" class="form-control datepicker" value="{{ $fecha_hasta == '' ? '': $fecha_hasta }}" required />
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="form-group">
                        <label for="Planta" id="planta_l">Planta</label>
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
                    <div class="checkbox hide" id="div_convenio">
                        <label>
                            <input type="checkbox" name="convenio" @if($convenio == '1') checked @endif> Con Convenio
                        </label>
                    </div>
                </div>
                <button type="button" id="btn_submit" class="btn btn-primary">Buscar</button>
            </div>
            {{ Form::close() }}
            @if($fechas_reservar)
            <div class="row">
                <div class="col-sm-12">
                    <br/>
                    <div class="panel panel-default">
                        <div class="panel-heading">Fechas con horas disponibles</div>
                        <div class="panel-body">
                            <p>Haz click sobre una fecha para ver las horas disponibles.</p>
                        </div>
                        <table class="table">
                            <tbody>
                                @foreach(array_chunk($fechas_reservar, 5) as $items)
                                <tr>
                                    @foreach($items as $item)
                                    <td> 
                                        <a href="{{ URL::to('/') }}/horasdisponibles/{{ $item }}/{{ $id_planta }}/{{ $patente }}/{{ $convenio }}" class="btn btn-default">{{ date('d-m-Y', strtotime($item)) }}</a>
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


            @if(!$id_planta)
            setTimeout(function(){$('#myModal').modal('show'); },0000); 
            @endif


            $(function() {
                $('.val_planta').click(function(){
                    var texto = $(this).text();
                    $('#id_planta').val($(this).attr('data-val'));
                    if($(this).attr('data-val') == 1){
                        $('#div_convenio').addClass('hide');
                    }else{
                        $('#div_convenio').removeClass('hide');
                    }
                    $('#planta_nombre').text(texto);
                });

                $('#btn_submit').click(function(){

                    var inicio = document.getElementById('fecha_dl');
                    var hasta = document.getElementById('fecha_hl');
                    var planta = document.getElementById('planta_l');



                    inicio.innerHTML = "Fecha Desde";
                    inicio.style.color = "black";
                    hasta.innerHTML = "Fecha hasta";
                    hasta.style.color = "black";
                    planta.innerHTML = "Planta";
                    planta.style.color = "black";


                    if($('#fecha_d').val() == '' || $('#fecha_h').val() =='' || $('#id_planta').val() == ''){
                        if($('#fecha_d').val() == ''){
                            inicio.innerHTML = "Fecha Desde (*)";
                            inicio.style.color = "red";
                        }

                        if($('#fecha_h').val() == ''){
                            hasta.innerHTML = "Fecha Hasta (*)";
                            hasta.style.color = "red";
                        }

                        if($('#id_planta').val() == '')
                        {
                            planta.innerHTML = "Planta (*)";
                            planta.style.color = "red";

                        }
                    }else{
                     $('#form_busca').submit();   
                    }

                    // if($('#id_planta').val() == ''){
                    //     $('#planta_alert').removeClass('hide');
                    // }else{
                    //     $('#planta_alert').addClass('hide');
                        
                    // }

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
    var entra = false;
//meses
switch(m) {
    case 1:
    if(ultimo == 9 || ultimo == 0){
        entra = true;
    }
    break;
    case 2:
    if(ultimo == 0 || ultimo == 1){ // 9
        entra = true;
    }
    break;
    case 3:
    if(ultimo == 1){ // 0 y 9
        entra = true;
    }
    break;
    case 4:
    if(ultimo == 1 || ultimo == 2){ // 0 y 9
        entra = true;
    }
    break;
    case 5:
    if(ultimo == 2 || ultimo == 3){ // 1 , 0 y 9
        entra = true;
    }
    break;
    case 6:
    if(ultimo == 3 || ultimo == 4){ // 9,0,1 y 2
        entra = true;
    }
    break;
    case 7:
    if(ultimo == 4 || ultimo == 5){
        entra = true;
    }
    break;
    case 8:
    if(ultimo == 5 || ultimo == 6){
        entra = true;
    }
    break;
    case 9:
    if(ultimo == 6 || ultimo == 7){
        entra = true;
    }
    break;
    case 10:
    if(ultimo == 7 || ultimo == 8){
        entra = true;
    }
    break;
    case 11:
    if(ultimo == 8){
        entra = true;
    }
    break;
    case 12:
    if(ultimo == 9){
        entra = true;
    }
    break;
    default:
    break;
    }
    return entra;
}


$('#btn_patente').click(function(){
    if(validaForm()){
        //if(validaDate()){
            $('.form_1').removeClass('hide');
            $('#formato').addClass('hide');
        /*}else{
            $('.form_1').addClass('hide');
            $('#formato').removeClass('hide').html('No es posible reservar este mes. Favor consultar el mes correspondiente en <a href="http://www.sandamaso.cl/servicios/calendario-de-atencion/">Calendario de Atención</a> ');
        }*/
    }else{
        $('.form_1').addClass('hide');
        $('#formato').removeClass('hide');
    }
});
var today = new Date();
$('.datepicker').datepicker({
    format: 'dd-mm-yyyy', 
    startDate: new Date(today.getFullYear(), today.getMonth(), today.getDate()+1), 
    endDate: '+3m', 
    autoclose: true
});
});
</script>
@stop
