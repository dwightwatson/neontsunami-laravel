@extends('admin.app')

@section('breadcrumbs', Breadcrumbs::render('admin.users.create'))

@section('content')
  <div class="page-header">
    <h3>New user</h3>
    <small>
      <a href="{{ route('admin.users.index') }}" class="btn btn-default">Cancel user</a>
    </small>
  </div>

  <div class="col-md-8 col-md-offset-2">
    {{ Form::open(['route' => 'admin.users.store']) }}
      @include('admin.users._form')
      {{ Form::submit('Create user', ['class' => 'btn btn-primary']) }}
    {{ Form::close() }}
  </div>
@stop
