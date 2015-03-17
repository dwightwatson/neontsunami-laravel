@include('layouts._header')
  <header class="col-sm-3">
    <h1>{!! link_to_route('pages.index', 'Neon Tsunami') !!}</h1>
    <h2>A blog on Laravel &amp; Rails</h2>

    <ul class="menu">
      <li class="{!! Active::route('posts.index') !!}">
        {!! link_to_route('posts.index', 'Posts') !!}
      </li>
      <li class="{!! Active::route('series.*') !!}">
        {!! link_to_route('series.index', 'Series') !!}
      </li>
      <li class="{!! Active::route('tags.*') !!}">
        {!! link_to_route('tags.index', 'Tags') !!}
      </li>
      <li class="{!! Active::route('projects.*') !!}">
        {!! link_to_route('projects.index', 'Projects') !!}
      </li>
      <li class="{!! Active::route('pages.about') !!}">
        {!! link_to_route('pages.about', 'About') !!}
      </li>
      <li>
        {!! link_to('https://github.com/dwightwatson/neontsunami', 'Fork') !!}
      </li>
      <li>{!! link_to_route('pages.rss', 'RSS') !!}</li>
    </ul>
  </header>

  <section id="content" class="col-sm-8 col-md-6">
    @yield('content')

    <footer>
      <p class="copyright">Copyright Dwight Watson {{ date('Y') }}</p>
      <ul class="list-inline">
        <li>{!! link_to('https://www.facebook.com/dwightconradwatson', 'Facebook') !!}</li>
        <li>{!! link_to('http://au.linkedin.com/in/dwightconradwatson', 'LinkedIn') !!}</li>
        <li>{!! link_to('https://github.com/dwightwatson', 'GitHub') !!}</li>
        <li>{!! link_to('http://www.twitter.com/DwightConrad', 'Twitter') !!}</li>
        <li>{!! link_to('https://plus.google.com/u/0/101067519899037222061?rel=author', 'Google+') !!}</li>
      </ul>
    </footer>
  </section>
@include('layouts._footer')
