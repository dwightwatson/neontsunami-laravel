@extends('layouts.admin')

@section('breadcrumbs', Breadcrumbs::render('admin.projects.edit', $project))

@section('content')
  <div class="page-header">
    <h3>Edit project</h3>
    <small>{!! link_to_route('admin.projects.show', 'Cancel edit', $project, ['class' => 'btn btn-default']) !!}</small>
  </div>

  <div class="col-md-8 col-md-offset-2">
    {!! Former::open()->route('admin.projects.update', $project)->method('put')->populate($project) !!}
      @include('admin.projects._form')
      {!! Former::actions()->primary_submit('Save project') !!}
    {!! Former::close() !!}
  </div>
@stop
