@extends('app')

@section('content')
  <h3>Tags</h3>
  <p class="lead">Tag cloud built using my {!! link_to('https://github.com/dwightwatson/taggly', 'Taggly') !!} package.</p>

  @unless ($tags->count())
    <div class="alert alert-info">
      <strong>Oops!</strong> There are no tags yet, please come back soon for more content.
    </div>
  @else
    <div class="clearfix">
      {!! Taggly::cloud($taggly) !!}
    </div>
  @endunless

@stop
