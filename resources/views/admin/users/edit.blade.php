@extends('admin.app')

@section('breadcrumbs', Breadcrumbs::render('admin.users.edit', $user))

@section('content')
  <div class="page-header">
    <h3>Edit user</h3>
    <small>
      <a href="{{ route('admin.users.show', $user) }}" class="btn btn-default">Cancel edit</a>
    </small>
  </div>

  <div class="col-md-8 col-md-offset-2">
    {!! Former::open()->route('admin.users.update', $user)->method('put')->populate($user) !!}
      @include('admin.users._form')
      {!! Former::actions()->primary_submit('Save user') !!}
    {!! Former::close() !!}
  </div>
@stop
