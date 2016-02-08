@extends('admin.app')

@section('breadcrumbs', Breadcrumbs::render('admin.projects.index'))

@section('content')
  <div class="page-header">
    <h3>All projects</h3>
    <small>
      <a href="{{ route('admin.projects.create') }}" class="btn btn-default">New project</a>
    </small>
  </div>

  @unless ($projects->count())
    <div class="alert alert-info">There are no projects yet.</div>
  @else
    <table class="table table-striped table-bordered">
      <tr>
        <td>Name</td>
        <td>Created</td>
      </tr>
      @foreach ($projects as $project)
        <tr>
          <td>
            <a href="{{ route('admin.projects.show', $project) }}">{{ $project->name }}</a>
          </td>
          <td>{{ $project->created_at->diffForHumans() }}</td>
        </tr>
      @endforeach
    </table>

    {{ $projects->render() }}
  @endunless

@stop
