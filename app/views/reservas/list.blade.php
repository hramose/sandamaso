@extends('layoutadmin')

@section('head')
@stop

@section('content')
<div class="container-fluid">
    {{ $filter }}
    {{ $grid }}
</div>
@stop