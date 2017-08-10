@include('_header')
  <div class="row">
    <header class="col-sm-4 col-md-3">
      <h1><a href="{{ route('pages.index') }}">Neon Tsunami</a></h1>
      <h2>A blog on Laravel &amp; Rails</h2>
      <p class="author">By Dwight Conrad Watson</p>
    </header>
  </div>

  <div class="row">
    <div class="col-sm-4 col-md-3">
      <ul class="menu">
        <li class="{{ active('posts.index') }}">
          <a href="{{ route('posts.index') }}">Posts</a>
        </li>
        <li class="{{ active('series.*') }}">
          <a href="{{ route('series.index') }}">Series</a>
        </li>
        <li class="{{ active('tags.*') }}">
          <a href="{{ route('tags.index') }}">Tags</a>
        </li>
        <li class="{{ active('projects.*') }}">
          <a href="{{ route('projects.index') }}">Projects</a>
        </li>
        <li class="{{ active('pages.about') }}">
          <a href="{{ route('pages.about') }}">About</a>
        </li>
        <li class="{{ active('pages.work') }}">
          <a href="{{ route('pages.work') }}">Work</a>
        </li>
        <li>
          <a href="https://github.com/dwightwatson/neontsunami">Fork</a>
        </li>
        <li>
          <a href="{{ route('pages.rss') }}">RSS</a>
        </li>
      </ul>

      <autocomplete algolia-logo="{{ asset('images/algolia.jpg') }}"></autocomplete>
    </div>

    <section id="content" class="col-sm-8 col-md-6">
      @yield('content')

      <footer>
        <p class="copyright">Copyright Dwight Watson {{ date('Y') }}</p>
        <ul class="list-inline">
          <li>
            <a href="https://www.facebook.com/dwightconradwatson">Facebook</a>
          </li>
          <li>
            <a href="http://au.linkedin.com/in/dwightconradwatson">LinkedIn</a>
          </li>
          <li>
            <a href="https://github.com/dwightwatson">GitHub</a>
          </li>
          <li>
            <a href="http://www.twitter.com/DwightConrad">Twitter</a>
          </li>
          <li>
            <a href="https://plus.google.com/u/0/101067519899037222061?rel=author">Google+</a>
          </li>
        </ul>
      </footer>
    </section>
  </div>

@include('_footer')
