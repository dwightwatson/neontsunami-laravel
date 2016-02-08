<div class="form-group {{ Form::hasErrors('first_name') }}">
  {{ Form::label('first_name', null, ['class' => 'control-label']) }}
  {{ Form::text('first_name', null, ['class' => 'form-control']) }}
  {{ Form::errors('first_name') }}
</div>

<div class="form-group {{ Form::hasErrors('last_name') }}">
  {{ Form::label('last_name', null, ['class' => 'control-label']) }}
  {{ Form::text('last_name', null, ['class' => 'form-control']) }}
  {{ Form::errors('last_name') }}
</div>

<div class="form-group {{ Form::hasErrors('email') }}">
  {{ Form::label('email', null, ['class' => 'control-label']) }}
  {{ Form::email('email', null, ['class' => 'form-control']) }}
  {{ Form::errors('email') }}
</div>

<div class="form-group {{ Form::hasErrors('password') }}">
  {{ Form::label('password', null, ['class' => 'control-label']) }}
  {{ Form::password('password', ['class' => 'form-control']) }}
  {{ Form::errors('password') }}
</div>
