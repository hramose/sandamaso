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
    });

</script>
@stop