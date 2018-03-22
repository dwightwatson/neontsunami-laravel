<div class="series">
  <h4 class="series-name">
    <a href="{{ route('series.show', $series) }}">{{ $series->name }}</a>
  </h4>
  <p class="series-posts">{{ $series->posts()->published()->count() }} {{ str_plural('post', $series->posts()->count()) }}</p>
  {{ markdown($series->description) }}
</div>
