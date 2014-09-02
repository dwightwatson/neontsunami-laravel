@extends('layouts.application')

@section('content')
  <div class="page-header">
    <h3>{{{ $post->title }}} </h3>
    <p class="post-published">Posted {{{ $post->published_at->diffForHumans() }}}</p>
  </div>

  <div class="post">
    {{ markdown($post->content) }}

    @if($post->tags->count())
      <div class="post-tags">
        @foreach($post->tags as $tag)
          {{ link_to_route('tags.show', $tag->hashtag, $tag->slug) }}
        @endforeach
      </div>
    @endif
  </div>

  {{ link_to_route('posts.index', '&larr; See more posts') }}
@stop
