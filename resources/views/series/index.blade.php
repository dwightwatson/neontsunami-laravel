@extends('app')

@section('content')
  <h3>Series</h3>
  <p class="lead">Some posts are part of an ongoing series around a certain topic. Please feel free to follow a series of blog posts if you want to learn more about it.</p>

  @unless ($series->count())
    <div class="alert alert-info">
      <strong>Oops!</strong> There are no series yet, please come back soon for more content.
    </div>
  @else
    @each('series._series', $series, 'series')
    {!! $series->render() !!}
  @endunless
@stop
