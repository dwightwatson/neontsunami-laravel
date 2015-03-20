@extends('layouts.admin')

@section('breadcrumbs', Breadcrumbs::render('admin.users.index'))

@section('content')
  <div class="page-header">
    <h3>All users</h3>
    <small>{!! link_to_route('admin.users.create', 'New users', null, ['class' => 'btn btn-default']) !!}</small>
  </div>

  @unless ($users->count())
    <div class="alert alert-info">There are no users yet.</div>
  @else
    <table class="table table-striped table-bordered">
      <tr>
        <td>Name</td>
        <td>Created</td>
      </tr>
      @foreach ($users as $user)
        <tr>
          <td>{!! link_to_route('admin.users.show', $user->first_name, $user) !!}</td>
          <td>{{ $user->created_at->diffForHumans() }}</td>
        </tr>
      @endforeach
    </table>
  @endunless

@stop
