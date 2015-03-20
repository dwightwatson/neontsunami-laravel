@extends('layouts.admin')

@section('breadcrumbs', Breadcrumbs::render('admin.sessions.create'))

@section('content')

  <div class="page-header">
    <h3>Login</h3>
  </div>

  {!! Former::open()->route('admin.sessions.store') !!}

    {!! Former::email('email') !!}
    {!! Former::password('password') !!}
    {!! Former::actions()->primary_submit('Login') !!}

  {!! Former::close() !!}

@stop
