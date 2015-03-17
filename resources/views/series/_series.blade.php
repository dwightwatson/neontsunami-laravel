<div class="series">
  <h4 class="series-name">{!! link_to_route('series.show', $series->name, $series) !!}</h4>
  <p class="series-posts">{{ $series->posts()->published()->count() }} {{ str_plural('post', $series->posts()->count()) }}</p>
  {!! markdown($series->description) !!}
</div>
