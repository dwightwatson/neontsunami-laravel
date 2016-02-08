@extends('admin.app')

@section('breadcrumbs', Breadcrumbs::render('admin.users.create'))

@section('content')
  <div class="page-header">
    <h3>New user</h3>
    <small>
      <a href="{{ route('admin.users.index') }}" class="btn btn-default">Cancel user</a>
    </small>
  </div>

  <div class="col-md-8 col-md-offset-2">
    {!! Former::open()->route('admin.users.store') !!}
      @include('admin.users._form')
      {!! Former::actions()->primary_submit('Create user') !!}
    {!! Former::close() !!}
  </div>
@stop
