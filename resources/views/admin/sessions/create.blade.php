@extends('admin.app')

@section('breadcrumbs', Breadcrumbs::render('admin.sessions.create'))

@section('content')

  <div class="page-header">
    <h3>Login</h3>
  </div>

  {{ Form::open(['route' => 'admin.sessions.store']) }}

    <div class="form-group {{ Form::hasErrors('email') }}">
      {{ Form::label('email', null, ['class' => 'control-label']) }}
      {{ Form::email('email', null, ['class' => 'form-control', 'required']) }}
      {{ Form::errors('email') }}
    </div>

    <div class="form-group {{ Form::hasErrors('password') }}">
      {{ Form::label('password', null, ['class' => 'control-label']) }}
      {{ Form::password('password', ['class' => 'form-control', 'required']) }}
      {{ Form::errors('password') }}
    </div>

    {{ Form::submit('Login', ['class' => 'btn btn-default']) }}

  {{ Form::close() }}

@stop
