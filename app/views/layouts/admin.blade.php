@include('layouts._header')
  <div class="container">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <a href="{{ route('admin.pages.index') }}" class="navbar-brand">Neon Tsunami</a>
        @if(Auth::check())
          <ul class="nav navbar-nav">
            <li class="{{ Active::route('admin.posts.*') }}">
              {{ link_to_route('admin.posts.index', 'Posts') }}
            </li>
            <li class="{{ Active::route('admin.series.*') }}">
              {{ link_to_route('admin.series.index', 'Series') }}
            </li>
            <li class="{{ Active::route('admin.projects.*') }}">
              {{ link_to_route('admin.projects.index', 'Projects') }}
            </li>
            <li class="{{ Active::route('admin.users.*') }}">
              {{ link_to_route('admin.users.index', 'Users') }}
            </li>
            <li class="{{ Active::route('admin.pages.reports') }}">
              {{ link_to_route('admin.pages.reports', 'Reports') }}
            </li>
          </ul>

          <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="{{ route('pages.index') }}">
                <span class="glyphicon glyphicon-chevron-left"></span> Back to site
              </a>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> {{{ Auth::user()->full_name }}} <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li>{{ link_to_route('admin.sessions.destroy', 'Logout', null, ['data-method' => 'delete']) }}</li>
              </ul>
            </li>
          </ul>
        @endif
      </div>
    </nav>

    @yield('breadcrumbs')

    @if(Session::has('success'))
      <div class="alert alert-success">{{{ Session::get('success') }}}</div>
    @endif

    @if(Session::has('info'))
      <div class="alert alert-info">{{{ Session::get('info') }}}</div>
    @endif

    @if(Session::has('error'))
      <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
    @endif

    @yield('content')
  </div>
@include('layouts._footer')
