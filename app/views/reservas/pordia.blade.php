@extends('layoutadmin')

@section('head')
@stop

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
		{{ Form::open(array('url' => 'informes/pordia', 'id'=>'form_informe')) }}
			<div class="panel panel-default">
			  <div class="panel-heading">Exportar por Fecha</div>
			  <div class="panel-body">
			    <input type="text" class="datepicker" name="fecha" value="{{ $fecha }}" />
			     <div class="form-group">
                        <label for="Planta" id="planta_l">Planta</label>
                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" id="planta" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span id="planta_nombre">{{ $planta == '' ? 'Todas las plantas' : $planta }}</span>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="planta">
                                @foreach($plantas as $item)
                                <li><a href="#" class="val_planta" data-val="{{ $item->id }}">{{ $item->nombre }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                <input type="hidden" name="id_planta" id="id_planta" value="{{ $id_planta == '' ? '' : $id_planta }}" />
			    <input type="submit" class="btn btn-info" value="Exportar" />
			  </div>
			</div>
		{{ Form::close() }}
		</div>
	</div>

</div>
<script type="text/javascript">
	$(function() {
	$('.datepicker').datepicker({
                format: 'dd-mm-yyyy', 
                autoclose: true
        });

	$('.val_planta').click(function(){
                    var texto = $(this).text();
                    $('#id_planta').val($(this).attr('data-val'));
                    $('#planta_nombre').text(texto);
                });

    });


</script>
@stop