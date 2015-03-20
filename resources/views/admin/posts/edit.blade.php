@extends('layouts.admin')

@section('breadcrumbs', Breadcrumbs::render('admin.posts.edit', $post))

@section('content')
  <div class="page-header">
    <h3>Edit post</h3>
    <small>{!! link_to_route('admin.posts.show', 'Cancel edit', $post, ['class' => 'btn btn-default']) !!}</small>
  </div>

  <div class="col-md-8 col-md-offset-2">
    {!! Former::open()->route('admin.posts.update', $post)->method('put')->populate($post) !!}
      @include('admin.posts._form')
      {!! Former::actions()->primary_submit('Save post') !!}
    {!! Former::close() !!}
  </div>
@stop
