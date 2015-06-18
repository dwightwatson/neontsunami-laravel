@extends('admin.app')

@section('breadcrumbs', Breadcrumbs::render('admin.users.create'))

@section('content')
  <div class="page-header">
    <h3>New user</h3>
    <small>{!! link_to_route('admin.users.index', 'Cancel user', null, ['class' => 'btn btn-default']) !!}</small>
  </div>

  <div class="col-md-8 col-md-offset-2">
    {!! Former::open()->route('admin.users.store') !!}
      @include('admin.users._form')
      {!! Former::actions()->primary_submit('Create user') !!}
    {!! Former::close() !!}
  </div>
@stop
