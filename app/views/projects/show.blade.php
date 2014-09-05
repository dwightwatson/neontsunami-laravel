@extends('layouts.application')

@section('content')
  <h3>{{{ $project->name }}}</h3>
  <p class="lead">{{{ $project->description }}}</p>

  <a href="{{{ $project->url }}}" title="{{{ $project->name }}}">See this project <span class="glyphicon glyphicon-chevron-right"></span></a>
@stop
