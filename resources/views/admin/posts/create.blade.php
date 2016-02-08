@extends('admin.app')

@section('breadcrumbs', Breadcrumbs::render('admin.posts.create'))

@section('content')
  <div class="page-header">
    <h3>New post</h3>
    <small>
      <a href="{{ route('admin.posts.index') }}" class="btn btn-default">Cancel post</a>
    </small>
  </div>

  <div class="col-md-8 col-md-offset-2">
    {{ Form::open(['route' => 'admin.posts.store']) }}
      @include('admin.posts._form')
      {{ Form::submit('Create post', ['class' => 'btn btn-primary']) }}
    {{ Form::close() }}
  </div>
@stop
