@extends('admin.app')

@section('breadcrumbs', Breadcrumbs::render('admin.pages.index'))

@section('content')

  <div class="row">
    <div class="col-md-3">
      <div class="panel panel-default">
        <div class="panel-heading">
          <span class="glyphicon glyphicon-file"></span> Posts
          <span class="badge pull-right">{{ $postsCount ? number_format($postsCount) : null }}</span>
        </div>
        <ul class="list-group">
          <a href="{{ route('admin.posts.index') }}" class="list-group-item">All posts</a>
          <a href="{{ route('admin.posts.create') }}" class="list-group-item">New post</a>
        </ul>
      </div>
    </div>

    <div class="col-md-3">
      <div class="panel panel-default">
        <div class="panel-heading">
          <span class="glyphicon glyphicon-list"></span> Series
          <span class="badge pull-right">{{ $seriesCount ? number_format($seriesCount) : null }}</span>
        </div>
        <ul class="list-group">
          <a href="{{ route('admin.series.index') }}" class="list-group-item">All series</a>
          <a href="{{ route('admin.series.create') }}" class="list-group-item">New series</a>
        </ul>
      </div>
    </div>

    <div class="col-md-3">
      <div class="panel panel-default">
        <div class="panel-heading">
          <span class="glyphicon glyphicon-briefcase"></span> Projects
          <span class="badge pull-right">{{ $projectsCount ? number_format($projectsCount) : null }}</span>
        </div>
        <ul class="list-group">
          <a href="{{ route('admin.projects.index') }}" class="list-group-item">All projects</a>
          <a href="{{ route('admin.projects.create') }}" class="list-group-item">New project</a>
        </ul>
      </div>
    </div>

    <div class="col-md-3">
      <div class="panel panel-default">
        <div class="panel-heading">
          <span class="glyphicon glyphicon-user"></span> Users
          <span class="badge pull-right">{{ $usersCount ? number_format($usersCount) : null }}</span>
        </div>
        <ul class="list-group">
          <a href="{{ route('admin.users.index') }}" class="list-group-item">All users</a>
          <a href="{{ route('admin.users.create') }}" class="list-group-item">New user</a>
        </ul>
      </div>
    </div>
  </div>

@stop
