@extends('admin.app')

@section('breadcrumbs', Breadcrumbs::render('admin.projects.show', $project))

@section('content')
  <div class="page-header">
    <h3>{{ $project->name }}</h3>
    <small>
      <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-default">Edit project</a>
      <a href="{{ route('admin.projects.destroy', $project) }}" class="btn btn-danger" data-method="delete" data-confirm="Are you sure you want to delete this project?">Delete project</a>
    </small>
  </div>

  <div class="project-description">
    {!! markdown($project->description) !!}
  </div>
@stop
