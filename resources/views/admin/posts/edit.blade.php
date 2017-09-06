@extends('admin.app')

@section('breadcrumbs', Breadcrumbs::render('admin.posts.edit', $post))

@section('content')
  <div class="page-header">
    <h3>Edit post</h3>
    <small>
      <a href="{{ route('admin.posts.show', $post) }}" class="btn-btn-default">Cancel edit</a>
    </small>
  </div>

  <div class="col-md-8 col-md-offset-2">
    <form method="post" action="{{ route('admin.posts.update', $post) }}">
      {{ csrf_field() }}
      {{ method_field('put') }}
      @include('admin.posts._form')
      <input type="submit" class="btn btn-primary" value="Save post">
    </form>
  </div>
@stop
