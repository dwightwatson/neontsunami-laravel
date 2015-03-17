@extends('layouts.application')

@section('content')
  <h3>{{ $tag->hashtag }}</h3>
  <p class="lead">{{ $posts->count() }} {{ str_plural('post', $posts->count()) }} found with this tag.</h4>

  @each('posts._post', $posts, 'post')

  {!! $posts->render() !!}
@stop
