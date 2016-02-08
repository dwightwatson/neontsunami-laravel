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
    {!! Former::open()->route('admin.posts.update', $post)->method('put')->populate($post) !!}
      @include('admin.posts._form')
      {!! Former::actions()->primary_submit('Save post') !!}
    {!! Former::close() !!}
  </div>
@stop
