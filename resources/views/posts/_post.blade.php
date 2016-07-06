<article class="post">
  <h4 class="post-title">
    <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
  </h4>
  <p class="post-published">Published {{ $post->published_at->diffForHumans() }}</p>
  <div class="post-content">
  <p>
    {{ str_limit(strip_tags(commonmark($post->content)), 500) }}
    <a href="{{ route('posts.show', $post) }}">Read more...</a>
  </p>
  </div>
  @if ($post->tags->count())
    <div class="post-tags">
      @foreach ($post->tags as $tag)
        <a href="{{ route('tags.show', $tag) }}">{{ $tag->hashtag }}</a>
      @endforeach
    </div>
  @endif
</article>
