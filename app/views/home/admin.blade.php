@extends('layoutadmin')

@section('head')
@stop

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Panel de Control</div>
				<div class="panel-body">
					<h3>Bienvenido {{ Auth::user()->username }}</h3>
					<div class="quote">{{ HTML::link('reservas/list','Reservas') }}</div>
					<div class="quote">{{ HTML::link('informes/pordiaget','Informe por Día') }}</div>
					<div class="quote">{{ HTML::link('plantas/list','Plantas') }}</div>
					<div class="quote">{{ HTML::link('informes/correos','Correos') }}</div>
				</div>
			</div>
		</div>
	</div>
</div>



@stop