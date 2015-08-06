@extends('layout')

@section('head')
@stop

@section('content')
    {{ Form::open(array('url' => 'reservas/buscar', 'id'=>'form_busca')) }}
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group">
                <label for="Rango de Fechas">Fecha Desde</label>
                <input type="text" name="fecha_desde" class="form-control datepicker" value="{{ $fecha_desde == '' ? '': $fecha_desde }}" required /> 
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="Rango de Fechas">Fecha Hasta</label>
                <input type="text" name="fecha_hasta" class="form-control datepicker" value="{{ $fecha_hasta == '' ? '': $fecha_hasta }}" required />
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
            <label for="Planta">Planta</label>
            <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="planta" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
    <br/>
    <div class="alert alert-warning" role="alert">No se encontraron resultados para esta busqueda, vuelve a intentarlo con otro rango de fechas</div>
    @endif


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
