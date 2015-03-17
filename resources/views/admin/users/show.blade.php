@extends('layouts.admin')

@section('breadcrumbs', Breadcrumbs::render('admin.users.show', $user))

@section('content')
  <div class="page-header">
    <h3>{{ $user->name }}</h3>
    <small>{!! link_to_route('admin.users.edit', 'Edit user', $user, ['class' => 'btn btn-default']) !!} {!! link_to_route('admin.users.destroy', 'Delete user', $user, ['class' => 'btn btn-danger', 'data-method' => 'destroy', 'data-confirm' => 'Are you sure you want to delete this user?']) !!}</small>
  </div>
@stop
