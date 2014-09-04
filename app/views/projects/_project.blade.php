<div class="project">
  <h4 class="project-name">{{ link_to_route('projects.show', $project->name, $project->slug) }}</h4>
  {{ markdown(Str::limit($project->description, 100)) }}
</div>
