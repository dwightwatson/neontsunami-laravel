<div class="form-group {{ Form::hasErrors('title') }}">
  {{ Form::label('title', null, ['class' => 'control-label']) }}
  {{ Form::text('title', null, ['class' => 'form-control']) }}
  {{ Form::errors('title') }}
</div>

<div class="form-group {{ Form::hasErrors('slug') }}">
  {{ Form::label('slug', null, ['class' => 'control-label']) }}
  {{ Form::text('slug', null, ['class' => 'form-control']) }}
  {{ Form::errors('slug') }}
</div>

<div class="form-group {{ Form::hasErrors('content') }}">
  {{ Form::label('content', null, ['class' => 'control-label']) }}
  {{ Form::textarea('content', null, ['class' => 'form-control', 'rows' => 10]) }}
  {{ Form::errors('content') }}
</div>

<div class="form-group {{ Form::hasErrors('tags') }}">
  {{ Form::label('tags', null, ['class' => 'control-label']) }}
  {{ Form::text('tags', null, ['class' => 'form-control']) }}
  {{ Form::errors('tags') }}
</div>

<div class="form-group {{ Form::hasErrors('series_id') }}">
  {{ Form::label('series_id', 'Series', ['class' => 'control-label']) }}
  {{ Form::select('series_id', $series, null, ['class' => 'form-control']) }}
  {{ Form::errors('series_id') }}
</div>

<div class="form-group {{ Form::hasErrors('published_at') }}">
  {{ Form::label('published_at', null, ['class' => 'control-label']) }}
  {{ Form::datetime('published_at', null, ['class' => 'form-control']) }}
  {{ Form::errors('published_at') }}
</div>
