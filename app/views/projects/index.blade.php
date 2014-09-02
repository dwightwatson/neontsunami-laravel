@extends('layouts.application')

@section('content')
  <h3>Projects</h3>
  <p class="lead">I like to contribute to open source, both in the way of relentless issues and pull-requests on other repositories, but also in the way of maintaining my own. If you use <a href="http://laravel.com/">Laravel</a> or <a href="http://ellislab.com/codeigniter">CodeIgniter</a>, I've probably got something that might be of interest to you.</p>

  @unless($projects->count())
    <div class="alert alert-info">
      <strong>Oops!</strong> There are no project yet, please come back soon for more content.
    </div>
  @else
    @each('projects._project', $projects, 'project')
    {{ $projects->links() }}
  @endunless
@stop
