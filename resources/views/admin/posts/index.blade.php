@extends('admin.app')

@section('breadcrumbs', Breadcrumbs::render('admin.posts.index'))

@section('content')
  <div class="page-header">
    <h3>All posts</h3>
    <small>{!! link_to_route('admin.posts.create', 'New post', null, ['class' => 'btn btn-default']) !!}</small>
  </div>

  @unless ($posts->count())
    <div class="alert alert-info">There are no posts yet.</div>
  @else
    <table class="table table-striped table-bordered">
      <tr>
        <td>Title</td>
        <td>Author</td>
        <td>Published</td>
      </tr>
      @foreach ($posts as $post)
        <tr>
          <td>{!! link_to_route('admin.posts.show', $post->title, $post) !!}</td>
          <td>{!! link_to_route('admin.users.show', $post->user->full_name, $post->user) !!}</td>
          <td>{!! $post->published_at ? $post->published_at->diffForHumans() : 'Unpublished' !!}</td>
        </tr>
      @endforeach
    </table>

    {!! $posts->render() !!}
  @endunless

@stop
