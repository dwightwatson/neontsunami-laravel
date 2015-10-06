@extends('app')

@section('content')
  <div class="page-header">
    <h3>About</h3>
  </div>

  <img src="{!! asset('images/dwight-conrad-watson.jpg') !!}" alt="Dwight Conrad Watson" class="img-responsive">

  <p class="lead">I'm a web developer based in <strong>Sydney, Australia</strong> with a keen interest in frameworks like <a href="http://laravel.com/" title="Laravel">Laravel</a>, <a href="http://rubyonrails.org/" title="Ruby on Rails">Ruby On Rails</a> and <a href="https://angularjs.org/" title="AngularJS">AngularJS</a>. I manage a number of high-traffic websites and apps including <a href="https://studentvip.com.au">StudentVIP</a>, <a href="https://lostoncampus.com.au">Lost On Campus</a> and <a href="https://www.timetableexchange.com.au">Timetable Exchange</a>. I also enjoy contributing to and maintaining my own <a href="https://github.com/dwightwatson">open-source projects</a>.</p>

  <p>I built this blog to document some of the interesting problems I deal with in my day to day work as a web developer, as well as showcase the solutions and packages I've built to solve common issues. I've released the source code for this blog as an {!! link_to('https://github.com/dwightwatson/neontsunami', 'open source repository') !!} to assist others in looking how a fully fleshed &amp; tested Laravel app comes together and I'm particularly proud of {!! link_to('https://github.com/dwightwatson/validating', 'my validating package') !!}.</p>

  <p>If you're interested in getting in touch, feel free to hit me up on {!! link_to('http://au.linkedin.com/in/dwightconradwatson', 'LinkedIn') !!} or {!! link_to('http://www.twitter.com/DwightConrad', 'Twitter') !!}.</p>
@stop
