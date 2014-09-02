@extends('layouts.admin')

@section('breadcrumbs', Breadcrumbs::render('admin.series.index'))

@section('content')
  <div class="page-header">
    <h3>All series</h3>
    <small>{{ link_to_route('admin.series.create', 'New series', null, ['class' => 'btn btn-default']) }}</small>
  </div>

  @unless($series->count())
    <div class="alert alert-info">There are no series yet.</div>
  @else
    <table class="table table-striped table-bordered">
      <tr>
        <td>Name</td>
        <td>Created</td>
      </tr>
      @foreach($series as $series)
        <tr>
          <td>{{ link_to_route('admin.series.show', $series->name, $series->slug) }}</td>
          <td>{{ $series->created_at->diffForHumans() }}</td>
        </tr>
      @endforeach
    </table>
  @endunless

@stop
