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
    {{ Form::model($series, ['route' => ['admin.series.update', $series], 'method' => 'put']) }}
      @include('admin.series._form')
      {{ Form::submit('Save series', ['class' => 'btn btn-primary']) }}
    {{ Form::close() }}
  </div>
@stop
