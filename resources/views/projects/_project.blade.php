<div class="project">
  <h4 class="project-name">{!! link_to_route('projects.show', $project->name, $project) !!}</h4>
  {!! markdown(str_limit($project->description, 200)) !!}
</div>
