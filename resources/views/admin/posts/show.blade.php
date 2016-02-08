@extends('admin.app')

@section('breadcrumbs', Breadcrumbs::render('admin.posts.show', $post))

@section('content')
  <div class="page-header">
    <h3>{{ $post->title }}</h3>
    <small>
      <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-default">Edit post</a>
      <a href="{{ route('admin.posts.destroy', $post) }}" class="btn btn-danger" data-method="delete" data-confirm="Are you sure you want to delete this post?">Delete post</a>
    </small>
  </div>

  <p class="lead">
    Created {{ $post->created_at->diffForHumans() }}
    @if ($post->published_at)
      , published {{ $post->published_at->diffForHumans() }}.
    @endif
  </p>
  <div class="post-content">
    {!! markdown($post->content) !!}
  </div>
@stop
