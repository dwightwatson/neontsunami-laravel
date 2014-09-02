<div class="project">
  <a href="{{ route('projects.show', $project->slug) }}" class="project-name">{{{ $project->name }}}</a>
  <p>{{ markdown(Str::limit($project->description, 100)) }}</p>
</div>