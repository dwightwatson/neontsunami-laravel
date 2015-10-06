@extends('app')

@section('content')
  <div class="page-header">
    <h3>Recent posts</h3>
  </div>

  @each('posts._post', $latestPosts, 'post')

  <a href="{!! route('posts.index') !!}">Read more recent posts <span class="glyphicon glyphicon-chevron-right"></span></a>

  <h4>Most popular posts</h4>
  @each('posts._post', $popularPosts, 'post')

  <a href="{!! route('posts.index') !!}">Read more posts <span class="glyphicon glyphicon-chevron-right"></span></a>
@stop
