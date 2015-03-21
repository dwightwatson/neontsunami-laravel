@extends('layouts.application')

@section('content')
  <h3>Recent posts</h3>
  @include('posts._post', ['post' => $latestPost])

  <a href="{!! route('posts.index') !!}">Read more recent posts <span class="glyphicon glyphicon-chevron-right"></span></a>

  <h4>Most popular posts</h4>
  @each('posts._post', $popularPosts, 'post')

  <a href="{!! route('posts.index') !!}">Read more posts <span class="glyphicon glyphicon-chevron-right"></span></a>
@stop
