{!! Former::input('title') !!}
{!! Former::input('slug') !!}
{!! Former::textarea('content')->rows(10) !!}
{!! Former::text('tags') !!}
{!! Former::select('series_id')->options($series)->label('Series') !!}
{!! Former::datetime('published_at') !!}
