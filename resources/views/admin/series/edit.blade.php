@extends('layouts.admin')

@section('breadcrumbs', Breadcrumbs::render('admin.series.edit', $series))

@section('content')
  <div class="page-header">
    <h3>Edit series</h3>
    <small>{!! link_to_route('admin.series.show', 'Cancel edit', $series, ['class' => 'btn btn-default']) !!}</small>
  </div>

  <div class="col-md-8 col-md-offset-2">
    {!! Former::open()->route('admin.series.update', $series)->method('put')->populate($series) !!}
      @include('admin.series._form')
      {!! Former::actions()->primary_submit('Save series') !!}
    {!! Former::close() !!}
  </div>
@stop
