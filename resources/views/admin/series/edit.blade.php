@extends('admin.app')

@section('breadcrumbs', Breadcrumbs::render('admin.series.edit', $series))

@section('content')
  <div class="page-header">
    <h3>Edit series</h3>
    <small>
      <a href="{{ route('admin.series.show', $series) }}" class="btn btn-default">Cancel edit</a>
    </small>
  </div>

  <div class="col-md-8 col-md-offset-2">
    {!! Former::open()->route('admin.series.update', $series)->method('put')->populate($series) !!}
      @include('admin.series._form')
      {!! Former::actions()->primary_submit('Save series') !!}
    {!! Former::close() !!}
  </div>
@stop
