@extends('app')

@section('content')
  <h3>Posts</h3>
  <p class="lead">I like to document the things I learn, problems I come across and solve and thoughts about most things web related. My blog posts range usually within the realms of PHP and Ruby, with a focus on Laravel 4 and Ruby On Rails. They go into awesome new or not-well-known features of these frameworks as well as discussing some real world approaches to web development. I'm interested in developing, testing, deploying and scaling.</p>
  <p>If there's something you'd like me to write about, shoot me a tweet.</p>

  @unless ($posts->count())
    <div class="alert alert-info">
      <strong>Oops!</strong> There are no posts yet, please come back soon for more content.
    </div>
  @else
    @each('posts._post', $posts, 'post')
    {!! $posts->render() !!}
  @endunless
@stop
