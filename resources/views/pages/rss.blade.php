{!! '<?xml version="1.0"?>' !!}
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    <title>Neon Tsunami</title>
    <link>{{ route('pages.index') }}</link>
    <atom:link href="{{ route('pages.rss') }}" rel="self" type="application/rss+xml" />
    <description></description>
    <copyright>{{ route('pages.index') }}</copyright>
    <ttl>30</ttl>

    @foreach ($posts as $post)
      <item>
        <title>{{ $post->title }}</title>
        <description>
          {!! htmlspecialchars($post->parsed_content) !!}
        </description>
        <link>{{ route('posts.show', $post) }}</link>
        <guid isPermaLink="true">{{ route('posts.show', $post) }}</guid>
        <pubDate>{{ $post->published_at }}</pubDate>
      </item>
    @endforeach
  </channel>
</rss>
