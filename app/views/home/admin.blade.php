@extends('layoutadmin')

@section('head')
@stop

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="list-group">
			  <a href="#" class="list-group-item active">
			    <h3>Bienvenido {{ Auth::user()->username }}</h3>
			  </a>
			  {{ HTML::link('admin/reservas/list', 'Reservas', array('class' => 'list-group-item'))}}
			  {{ HTML::link('admin/reservas-convenio/list', 'Reservas Convenio', array('class' => 'list-group-item'))}}
			  {{ HTML::link('admin/informes/pordiaget', 'Informe por Día', array('class' => 'list-group-item'))}}
			  {{ HTML::link('admin/plantas/list', 'Plantas', array('class' => 'list-group-item'))}}
			  {{ HTML::link('admin/informes/correos', 'Correos', array('class' => 'list-group-item'))}}
			  {{ HTML::link('admin/empresas/list', 'Empresas', array('class' => 'list-group-item'))}}
			</div>
		</div>
	</div>
</div>



@stop