@extends('app')

@section('content')
  <div class="page-header">
    <h3>{{ $project->name }}</h3>
  </div>

  <p class="lead">{!! markdown($project->description) !!}</p>

  <a href="{{ $project->url }}" title="{{ $project->name }}" target="_blank">See this project <span class="glyphicon glyphicon-chevron-right"></span></a>
@stop
