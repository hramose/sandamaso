@extends('layout')

@section('head')
@stop

@section('content')
    {{ Form::open(array('url' => 'reservas/buscar', 'id'=>'form_busca')) }}
    <div class="row">
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
                    <li><a href="#" class="val_planta" data-val="Valparaíso">Valparaíso</a></li>
                    <li><a href="#" class="val_planta" data-val="Viña del Mar">Viña del Mar</a></li>
                    <li><a href="#" class="val_planta" data-val="Quilicura">Quilicura</a></li>
                    <li><a href="#" class="val_planta" data-val="Calama">Calama</a></li>
                    <li><a href="#" class="val_planta" data-val="Antofagasta">Antofagasta</a></li>
                    <li><a href="#" class="val_planta" data-val="Copiapó A-B">Copiapó A-B</a></li>
                    <li><a href="#" class="val_planta" data-val="Chañaral A-B">Chañaral A-B</a></li>
                  </ul>
            </div>
            <label class="hide" id="planta_alert" style="color:red">Debe seleccionar una planta</label>
            </div>
            <input type="hidden" name="planta" id="id_planta" value="{{ $planta == '' ? '' : $planta }}" />
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <button type="button" id="btn_submit" class="btn btn-primary">Buscar</button>
        </div>
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
                                    <a href="{{ URL::to('/') }}/horasdisponibles/{{ $item }}/{{ $planta }}" class="btn btn-default">{{ date('d-m-Y', strtotime($item)) }}</a>
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

<script type="text/javascript">
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

    $('.datepicker').datepicker({format: 'dd-mm-yyyy'})
});
</script>
@stop
