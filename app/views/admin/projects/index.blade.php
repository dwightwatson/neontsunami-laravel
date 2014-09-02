@extends('layouts.admin')

@section('breadcrumbs', Breadcrumbs::render('admin.projects.index'))

@section('content')
  <div class="page-header">
    <h3>All projects</h3>
    <small>{{ link_to_route('admin.projects.create', 'New projects', null, ['class' => 'btn btn-default']) }}</small>
  </div>

  @unless($projects->count())
    <div class="alert alert-info">There are no projects yet.</div>
  @else
    <table class="table table-striped table-bordered">
      <tr>
        <td>Name</td>
        <td>Created</td>
      </tr>
      @foreach($projects as $project)
        <tr>
          <td>{{ link_to_route('admin.projects.show', $project->name, $project->slug) }}</td>
          <td>{{ $project->created_at->diffForHumans() }}</td>
        </tr>
      @endforeach
    </table>
  @endunless

@stop
