@extends('layouts.admin')

@section('breadcrumbs', Breadcrumbs::render('admin.posts.show', $post))

@section('content')
  <div class="page-header">
    <h3>{{{ $post->title }}}</h3>
    <small>{{ link_to_route('admin.posts.edit', 'Edit post', $post->slug, ['class' => 'btn btn-default']) }} {{ link_to_route('admin.posts.destroy', 'Delete post', $post->slug, ['class' => 'btn btn-danger', 'data-method' => 'destroy', 'data-confirm' => 'Are you sure you want to delete this post?']) }}</small>
  </div>

  <p class="lead">Created {{ $post->created_at->diffForHumans() }}, published {{ $post->published_at->diffForHumans() }}.</p>
  <div class="post-content">
    {{ markdown($post->content) }}
  </div>
@stop
