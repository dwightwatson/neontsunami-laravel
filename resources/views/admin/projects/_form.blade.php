<div class="form-group {{ Form::hasErrors('name') }}">
  {{ Form::label('name', null, ['class' => 'control-label']) }}
  {{ Form::text('name', null, ['class' => 'form-control']) }}
  {{ Form::errors('name') }}
</div>

<div class="form-group {{ Form::hasErrors('slug') }}">
  {{ Form::label('slug', null, ['class' => 'control-label']) }}
  {{ Form::text('slug', null, ['class' => 'form-control']) }}
  {{ Form::errors('slug') }}
</div>

<div class="form-group {{ Form::hasErrors('url') }}">
  {{ Form::label('url', 'URL', ['class' => 'control-label']) }}
  {{ Form::text('url', null, ['class' => 'form-control']) }}
  {{ Form::errors('url') }}
</div>

<div class="form-group {{ Form::hasErrors('description') }}">
  {{ Form::label('description', null, ['class' => 'control-label']) }}
  {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => 5]) }}
  {{ Form::errors('description') }}
</div>
