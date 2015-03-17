<article class="post">
  <h4 class="post-title">{!! link_to_route('posts.show', $post->title, $post) !!}</h4
  >
  <p class="post-published">Published {{ $post->published_at->diffForHumans() }}</p>
  <div class="post-content">
  <p>{{ str_limit(strip_tags(markdown($post->content)), 500) }} {!! link_to_route('posts.show', 'read more...', $post) !!}</p>
  </div>
  @if ($post->tags->count())
    <div class="post-tags">
      @foreach ($post->tags as $tag)
        {!! link_to_route('tags.show', $tag->hashtag, $tag) !!}
      @endforeach
    </div>
  @endif
</article>
