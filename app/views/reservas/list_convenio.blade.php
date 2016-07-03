@extends('layoutadmin')

@section('head')
@stop

@section('content')
<div class="container-fluid">
    <div class="section-header">
      <div class="elements one">
        <div class="pull-right">
        <a href="{{ URL::to('admin/informes/general')}}{{ $link }}" class="btn btn-success">Exportar</a>
        </div>
        <div class="element">
          {{ $filter }}
        </div>
      </div>
    </div>


    <table class="table table-striped">
    <thead>
    <tr>
                 <th>
                                                <a href="{{ URL::to('/') }}/admin/reservas/list?ord=nombre">
                        <span class="glyphicon glyphicon-arrow-up"></span>
                    </a>
                                                    <a href="{{ URL::to('/') }}/admin/reservas/list?ord=-nombre">
                        <span class="glyphicon glyphicon-arrow-down"></span>
                    </a>
                                             Nombre
            </th>
                 <th>
                                                <a href="{{ URL::to('/') }}/admin/reservas/list?ord=email">
                        <span class="glyphicon glyphicon-arrow-up"></span>
                    </a>
                                                    <a href="{{ URL::to('/') }}/admin/reservas/list?ord=-email">
                        <span class="glyphicon glyphicon-arrow-down"></span>
                    </a>
                                             Email
            </th>
                 <th>
                                                <a href="{{ URL::to('/') }}/admin/reservas/list?ord=patente">
                        <span class="glyphicon glyphicon-arrow-up"></span>
                    </a>
                                                    <a href="{{ URL::to('/') }}/admin/reservas/list?ord=-patente">
                        <span class="glyphicon glyphicon-arrow-down"></span>
                    </a>
                                             Patente
            </th>
                 <th>
                                                <a href="{{ URL::to('/') }}/admin/reservas/list?ord=planta">
                        <span class="glyphicon glyphicon-arrow-up"></span>
                    </a>
                                                    <a href="{{ URL::to('/') }}/admin/reservas/list?ord=-planta">
                        <span class="glyphicon glyphicon-arrow-down"></span>
                    </a>
                                             Planta
            </th>
                 <th>
                                                <a href="{{ URL::to('/') }}/admin/reservas/list?ord=tipo_vehiculo">
                        <span class="glyphicon glyphicon-arrow-up"></span>
                    </a>
                                                    <a href="{{ URL::to('/') }}/admin/reservas/list?ord=-tipo_vehiculo">
                        <span class="glyphicon glyphicon-arrow-down"></span>
                    </a>
                                             Tipo Vehículo
            </th>
            <th>
                                             Empresa
            </th>
                 <th>
                                             Fecha
            </th>
            <th>
                                             IP
            </th>
                 <th>
                                                <a href="{{ URL::to('/') }}/admin/reservas/list?ord=hora">
                        <span class="glyphicon glyphicon-arrow-up"></span>
                    </a>
                                                    <a href="{{ URL::to('/') }}/admin/reservas/list?ord=-hora">
                        <span class="glyphicon glyphicon-arrow-down"></span>
                    </a>
                                             Hora
            </th>
            <th>
                                             Creada
            </th>
                 <th>
                            Borrar
            </th>
         </tr>
    </thead>
    <tbody>
    @foreach ($grid->data as $item)
            <tr>
                        <td>{{ $item->nombre }} </td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->patente }}</td>
                        <td>{{ $item->planta }}</td>
                        <td>{{ $item->tipo_vehiculo }}</td>
                        <td>{{ $item['fechas_reservas_convenio']['empresa']['nombre'] }}</td>
                        <td>{{ date("d/m/Y",strtotime($item->fecha)) }}</td>
                        <td>{{ $item->ip }}</td>
                        <td>{{ $item->hora }}</td>
                        <td>{{ date("d/m/Y h:i:s",strtotime($item->created_at)) }}</td>
                        <td><a class="text-danger" title="Delete" onclick="confirmaDelete({{ $item->id }})" href="#"><span class="glyphicon glyphicon-trash"> </span></a>
                        </td>
            </tr>
    @endforeach
        </tbody>
</table>

{{ $grid->links() }}
</div>
<script>

    var confirmaDelete = function(id){

    var r = confirm("¿Esta seguro que desea borrar este registro?");
        if (r == true) {
            window.location="{{ URL::to('/') }}/admin/reservas/delete/"+id;
        }
    }

</script
@stop