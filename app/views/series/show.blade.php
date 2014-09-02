@extends('layouts.application')

@section('content')
  <h3>{{{ $series->name }}}</h3>
  <p class="lead">{{{ $series->description }}}</p>

  <h4>{{ $posts->count() }} {{ Str::plural('post', $posts->count()) }} in this series</h4>
  @each('posts._post', $posts, 'post')

  {{ $posts->links() }}

  <a href="{{ route('series.index') }}">Browse more series <span class="glyphicon glyphicon-chevron-right"></span></a>
@stop
