<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>{{ isset($title) ? e($title) . " &mdash; Neon Tsunami" : "Neon Tsunami" }}</title>
    <link rel="stylesheet" href="{{ asset('assets/application.css') }}">
    <meta name="description" content="{{ $description or 'A blog on web development, focused on frameworks like Laravel, Ruby on Rails and Angular by Dwight Watson.' }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">


    <meta name="csrf-param" content="_token"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-23727271-4', 'neontsunami.com');
      ga('require', 'displayfeatures');
      ga('send', 'pageview');
    </script>
  </head>
  <body class="{{ controller_name() }} {{ action_name() }}">
    <div class="container">
      <div class="row">
