@extends('admin.app')

@section('breadcrumbs', Breadcrumbs::render('admin.posts.index'))

@section('content')
  <div class="page-header">
    <h3>All posts</h3>
    <small>
      <a href="{{ route('admin.posts.create') }}" class="btn btn-default">New post</a>
    </small>
  </div>

  @unless ($posts->count())
    <div class="alert alert-info">There are no posts yet.</div>
  @else
    <table class="table table-striped table-bordered">
      <tr>
        <td>Title</td>
        <td>Author</td>
        <td>Views</td>
        <td>Published</td>
      </tr>
      @foreach ($posts as $post)
        <tr>
          <td>
            <a href="{{ route('admin.posts.show', $post) }}">{{ $post->title }}</a>
          </td>
          <td>
            <a href="{{ route('admin.users.show', $post->user) }}">{{ $post->user->full_name }}</a>
          </td>
          <td>
            {{ number_format($post->views) }}
          </td>
          <td>{{ $post->published_at ? $post->published_at->diffForHumans() : 'Unpublished' }}</td>
        </tr>
      @endforeach
    </table>

    {{ $posts->render() }}
  @endunless

@stop
