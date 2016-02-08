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
    {{ Form::model($post, ['route' => ['admin.posts.update', $post], 'method' => 'put']) }}
      @include('admin.posts._form')
      {{ Form::submit('Save post', ['class' => 'btn btn-primary']) }}
    {{ Form::close() }}
  </div>
@stop
