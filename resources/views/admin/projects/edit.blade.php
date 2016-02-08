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
    {!! Former::open()->route('admin.projects.update', $project)->method('put')->populate($project) !!}
      @include('admin.projects._form')
      {!! Former::actions()->primary_submit('Save project') !!}
    {!! Former::close() !!}
  </div>
@stop
