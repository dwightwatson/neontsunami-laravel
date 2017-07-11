@include('_header')
  <div class="container">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <a href="{{ route('admin.pages.index') }}" class="navbar-brand">Neon Tsunami</a>
        @if (Auth::check())
          <ul class="nav navbar-nav">
            <li class="{{ active('admin.posts.*') }}">
              <a href="{{ route('admin.posts.index') }}">Posts</a>
            </li>
            <li class="{{ active('admin.series.*') }}">
              <a href="{{ route('admin.series.index') }}">Series</a>
            </li>
            <li class="{{ active('admin.projects.*') }}">
              <a href="{{ route('admin.projects.index') }}">Projects</a>
            </li>
            <li class="{{ active('admin.users.*') }}">
              <a href="{{ route('admin.users.index') }}">Users</a>
            </li>
            <li class="{{ active('admin.pages.reports') }}">
              <a href="{{ route('admin.pages.reports') }}">Reports</a>
            </li>
          </ul>

          <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="{{ route('pages.index') }}">
                <span class="glyphicon glyphicon-chevron-left"></span> Back to site
              </a>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="glyphicon glyphicon-user"></span> {{ Auth::user()->full_name }} <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li>
                  <a href="{{ route('admin.users.show', auth()->user()) }}">Account</a>
                </li>
                <li>
                  <a href="{{ route('admin.sessions.destroy') }}" data-method="delete">Logout</a>
                </li>
              </ul>
            </li>
          </ul>
        @endif
      </div>
    </nav>

    @yield('breadcrumbs')

    @if (session()->has('success'))
      <div class="alert alert-success">{{ session()->get('success') }}</div>
    @endif

    @if (session()->has('info'))
      <div class="alert alert-info">{{ session()->get('info') }}</div>
    @endif

    @if (session()->has('error'))
      <div class="alert alert-danger">{{ session()->get('error') }}</div>
    @endif

    @yield('content')
  </div>
@include('_footer')
