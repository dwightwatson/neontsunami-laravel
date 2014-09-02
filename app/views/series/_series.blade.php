<div class="series">
  <h4 class="series-title">
  {{ link_to_route('series.show', $series->name, $series->slug) }} <small>{{ $series->posts()->count() }} {{ Str::plural('post', $series->posts()->count()) }}</small></h4>
  {{ markdown($series->description) }}
</div>
