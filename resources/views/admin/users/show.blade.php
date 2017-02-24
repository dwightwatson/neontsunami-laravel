@extends('admin.app')

@section('breadcrumbs', Breadcrumbs::render('admin.users.show', $user))

@section('content')
  <div class="page-header">
    <h3>{{ $user->full_name }}</h3>
    <small>
      <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-default">Edit user</a>
      <a href="{{ route('admin.users.destroy', $user) }}" class="btn btn-danger" data-method="delete" data-method="Are you sure you want to delete this user?">Delete user</a>
    </small>
  </div>
@stop
