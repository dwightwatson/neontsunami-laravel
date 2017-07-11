@extends('app')

@section('content')
  <div class="page-header">
    <h3>{{ $series->name }}</h3>
  </div>

  <p class="lead">{{ $series->description }}</p>

  <h4>{{ $posts->total() }} {{ str_plural('post', $posts->total()) }} in this series</h4>
  @each('posts._post', $posts, 'post')

  {{ $posts->render() }}

  <a href="{{ route('series.index') }}">Browse more series <span class="glyphicon glyphicon-chevron-right"></span></a>
@stop
