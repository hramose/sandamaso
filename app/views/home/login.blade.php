@extends('layout')

@section('head')
@stop

@section('content')
    <div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
      @if($errors->has())
        <div class='alert alert-danger'>
            @foreach ($errors->all('<p>:message</p>') as $message)
                Usuario y/o Contraseña incorrectos.
            @endforeach
        </div>
    @endif
		{{ Form::open(array( 'url' => '/login', 'class' => 'form-signin')) }}
          <h2 class="form-signin-heading">Ingresar</h2>
          <div class="form-group">
            <label for="inputEmail" class="sr-only">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Ingresar email" required autofocus>
          </div>
          <div class="form-group">
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Ingresar Password" required>
          </div>
          <button type="submit" id="login" class="btn btn-lg btn-primary btn-block">Entrar</button>
      {{ Form::close() }}
	   </div>
  <div class="col-sm-4"></div>
</div>
@stop
