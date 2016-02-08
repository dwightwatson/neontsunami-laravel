@extends('admin.app')

@section('breadcrumbs', Breadcrumbs::render('admin.projects.edit', $project))

@section('content')
  <div class="page-header">
    <h3>Edit project</h3>
    <small>
      <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-default">Cancel edii</a>
    </small>
  </div>

  <div class="col-md-8 col-md-offset-2">
    {{ Form::model($project, ['route' => ['admin.projects.update', $project], 'method' => 'put']) }}
      @include('admin.projects._form')
      {{ Form::submit('Save project', ['class' => 'btn btn-primary']) }}
    {{ Form::close() }}
  </div>
@stop
