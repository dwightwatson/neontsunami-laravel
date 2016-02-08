@extends('admin.app')

@section('breadcrumbs', Breadcrumbs::render('admin.series.show', $series))

@section('content')
  <div class="page-header">
    <h3>{{ $series->name }}</h3>
    <small>
      <a href="{{ route('admin.series.edit', $series) }}" class="btn btn-default">Edit series</a>
      <a href="{{ route('admin.series.destroy', $series) }}" class="btn btn-danger" data-method="delete" data-confirm="Are you sure you want to delete this series?">Delete series</a>
    </small>
  </div>

  <div class="series-description">
    {{ $series->description }}
  </div>
@stop
