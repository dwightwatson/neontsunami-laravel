<div class="project">
  <h4 class="project-name">
    <a href="{{ route('projects.show', $project) }}">{{ $project->name }}</a>
  </h4>
  {{ markdown(str_limit($project->description, 200)) }}
</div>
