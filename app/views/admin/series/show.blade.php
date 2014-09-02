@extends('layouts.admin')

@section('breadcrumbs', Breadcrumbs::render('admin.series.show', $series))

@section('content')
  <div class="page-header">
    <h3>{{{ $series->name }}}</h3>
    <small>{{ link_to_route('admin.series.edit', 'Edit series', $series->slug, ['class' => 'btn btn-default']) }} {{ link_to_route('admin.series.destroy', 'Delete series', $series->slug, ['class' => 'btn btn-danger', 'data-method' => 'destroy', 'data-confirm' => 'Are you sure you want to delete this series?']) }}</small>
  </div>

  <div class="series-description">
    {{{ $series->description }}}
  </div>
@stop
