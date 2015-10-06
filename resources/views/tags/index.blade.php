@extends('app')

@section('content')
  <div class="page-header">
    <h3>Tags</h3>
  </div>

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
