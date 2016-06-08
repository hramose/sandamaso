@extends('layoutadmin')

@section('head')
@stop

@section('content')
<div class="container-fluid">
    {{ $filter }}
    
    <table class="table table-striped">
    <thead>
    <tr>
                 <th>
                                                <a href="{{ URL::to('/') }}/admin/plantas/list?ord=nombre">
                        <span class="glyphicon glyphicon-arrow-up"></span>
                    </a>
                                                    <a href="{{ URL::to('/') }}/admin/plantas/list?ord=-nombre">
                        <span class="glyphicon glyphicon-arrow-down"></span>
                    </a>
                                             Nombre
            </th>
                 <th>
                                             Sabados
            </th>
                 <th>
                                             Primeros/Ultimos días
            </th>
                 <th>
                                             Numero de Días
            </th>
            <th>
                Correo Administrador
            </th>
            <th>
                            Horas Semana
            </th>
            <th>
                            Horas Fin de Semana
            </th>
             <th>
                            Estado
            </th>
            <th>
                            Convenio
            </th>
            <th>
                            Empresas
            </th>
            <th>
                            Editar
            </th>
         </tr>
    </thead>
    <tbody>
    	@foreach ($grid->data as $item)
            <tr>
                        <td>{{ $item->nombre }}</td>
                        <td>{{ $item->sabados == 0 ? 'Atiende' : 'No Atiende' }}</td>
                        <td>{{ $item->dias_restriccion == 0 ? 'Con días' : 'Sin días' }}</td>
                        <td>{{ $item->num_dias }}</td>
                        <td>{{ $item->email_admin == null ? 'sin correo': $item->email_admin }}</td>
                        <td><a class="" title="" href="{{ URL::to('/') }}/admin/plantas/horas/{{$item->id}}/list"><span class="glyphicon glyphicon-th-list"> </span></a>
                        </td>
                        <td><a class="" title="" href="{{ URL::to('/') }}/admin/plantas/horas_weekend/{{$item->id}}/list"><span class="glyphicon glyphicon-th-list"> </span></a>
                        </td>
                        <td>{{ $item->activa == 1 ? 'Activa': 'Inactiva' }}</td>
                        <td>{{ $item->convenio == 1 ? 'Tiene': 'No tiene' }}</td>
                        <td><a class="" title="" href="{{ URL::to('/') }}/admin/plantas/empresas/{{$item->id}}/list"><span class="glyphicon glyphicon-th-list"> </span></a>
                        </td>
                        <td><a class="" title="Modify" href="{{ URL::to('/') }}/admin/plantas/crud?modify={{$item->id}}"><span class="glyphicon glyphicon-edit"> </span></a>
						</td>
            </tr>
        @endforeach
        </tbody>
</table>
{{ $grid->links() }}
</div>
@stop