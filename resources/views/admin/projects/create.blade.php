@extends('admin.app')

@section('breadcrumbs', Breadcrumbs::render('admin.projects.create'))

@section('content')
  <div class="page-header">
    <h3>New project</h3>
    <small>
      <a href="{{ route('admin.projects.index') }}" class="btn btn-default">Cancel project</a>
    </small>
  </div>

  <div class="col-md-8 col-md-offset-2">
    {{ Form::open(['route' => 'admin.projects.store']) }}
      @include('admin.projects._form')
      {{ Form::submit('Create project', ['class' => 'btn btn-primary']) }}
    {{ Form::close() }}
  </div>
@stop
