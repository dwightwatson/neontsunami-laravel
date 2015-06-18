@extends('admin.app')

@section('breadcrumbs', Breadcrumbs::render('admin.series.create'))

@section('content')
  <div class="page-header">
    <h3>New series</h3>
    <small>{!! link_to_route('admin.series.index', 'Cancel series', null, ['class' => 'btn btn-default']) !!}</small>
  </div>

  <div class="col-md-8 col-md-offset-2">
    {!! Former::open()->route('admin.series.store') !!}
      @include('admin.series._form')
      {!! Former::actions()->primary_submit('Create series') !!}
    {!! Former::close() !!}
  </div>
@stop
