@extends('admin.app')

@section('breadcrumbs', Breadcrumbs::render('admin.users.index'))

@section('content')
  <div class="page-header">
    <h3>All users</h3>
    <small>
      <a href="{{ route('admin.users.create') }}" class="btn btn-default">New user</a>
    </small>
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
          <td>
            <a href="{{ route('admin.users.show', $user) }}">{{ $user->full_name }}</a>
          </td>
          <td>{{ $user->created_at->diffForHumans() }}</td>
        </tr>
      @endforeach
    </table>

    {{ $users->render() }}
  @endunless

@stop
