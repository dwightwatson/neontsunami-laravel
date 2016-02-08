@extends('admin.app')

@section('breadcrumbs', Breadcrumbs::render('admin.series.index'))

@section('content')
  <div class="page-header">
    <h3>All series</h3>
    <small>
      <a href="{{ route('admin.series.create') }}" class="btn btn-default">New series</a>
    </small>
  </div>

  @unless ($series->count())
    <div class="alert alert-info">There are no series yet.</div>
  @else
    <table class="table table-striped table-bordered">
      <tr>
        <td>Name</td>
        <td>Created</td>
      </tr>
      @foreach ($series as $series)
        <tr>
          <td>
            <a href="{{ route('admin.series.show', $series) }}">{{ $series->name }}</a>
          </td>
          <td>{{ $series->created_at->diffForHumans() }}</td>
        </tr>
      @endforeach
    </table>

    {{ $series->render() }}
  @endunless

@stop
