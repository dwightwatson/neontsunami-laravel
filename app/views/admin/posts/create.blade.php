@extends('layouts.admin')

@section('breadcrumbs', Breadcrumbs::render('admin.posts.create'))

@section('content')
  <div class="page-header">
    <h3>New post</h3>
    <small>{{ link_to_route('admin.posts.index', 'Cancel post', null, ['class' => 'btn btn-default']) }}</small>
  </div>

  <div class="col-md-8 col-md-offset-2">
    {{ Former::open()->route('admin.posts.store') }}
      @include('admin.posts._form')
      {{ Former::actions()->primary_submit('Create post') }}
    {{ Former::close() }}
  </div>
@stop
