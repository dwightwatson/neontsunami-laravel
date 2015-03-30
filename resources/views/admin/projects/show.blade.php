@extends('layouts.admin')

@section('breadcrumbs', Breadcrumbs::render('admin.projects.show', $project))

@section('content')
  <div class="page-header">
    <h3>{{ $project->name }}</h3>
    <small>{!! link_to_route('admin.projects.edit', 'Edit project', $project, ['class' => 'btn btn-default']) !!} {!! link_to_route('admin.projects.destroy', 'Delete project', $project, ['class' => 'btn btn-danger', 'data-method' => 'destroy', 'data-confirm' => 'Are you sure you want to delete this project?']) !!}</small>
  </div>

  <div class="project-description">
    {!! markdown($project->description) !!}
  </div>
@stop
