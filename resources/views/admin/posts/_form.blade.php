<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
  <label for="title" class="control-label">Title</label>
  <input type="text" name="title" id="title" class="form-control" value="{{ $post->title or old('title') }}">
  @if ($errors->has('title'))
    <span class="help-block">{{ $errors->first('title') }}</strong></span>
  @endif
</div>

<div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
  <label for="slug" class="control-label">Slug</label>
  <input type="text" name="slug" id="slug" class="form-control" value="{{ $post->slug or old('slug') }}">
  @if ($errors->has('slug'))
    <span class="help-block">{{ $errors->first('slug') }}</strong></span>
  @endif
</div>

<div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
  <label for="Content" class="control-label">Content</label>
  <textarea name="content" id="content" class="form-control" rows="10">{{ $post->content or old('content') }}</textarea>
  @if ($errors->has('content'))
    <span class="help-block">{{ $errors->first('content') }}</strong></span>
  @endif
</div>

<div class="form-group{{ $errors->has('tags') ? ' has-error' : '' }}">
  <label for="tags" class="control-label">Tags</label>
  <input type="text" name="tags" id="tags" class="form-control" value="{{ isset($post) ? $post->tags->pluck('name')->implode(',') : old('tags') }}">
  @if ($errors->has('tags'))
    <span class="help-block">{{ $errors->first('tags') }}</strong></span>
  @endif
</div>

@if ($series->count())
  <div class="form-group{{ $errors->has('series_id') ? ' has-error' : '' }}">
    <label for="series_id" class="control-label">Series</label>
    <select name="series_id" id="series_id" class="form-control">
      <option>Select...</option>
      @foreach ($series as $singleSeries)
        <option value="{{ $singleSeries->id }}"{{ ($post->series_id or old('series_id')) == $singleSeries->id ? 'selected' : null }}>{{ $singleSeries->name }}</option>
      @endforeach
    </select>
    @if ($errors->has('series_id'))
      <span class="help-block">{{ $errors->first('series_id') }}</strong></span>
    @endif
  </div>
@endif

<div class="form-group{{ $errors->has('published_at') ? ' has-error' : '' }}">
  <label for="published_at" class="control-label">Published At</label>
  <input type="datetime" name="published_at" id="published_at" class="form-control" value="{{ isset($post) ? $post->published_at->toDateTimeString() : now()->format('Y-m-d H:i:s') }}">
  @if ($errors->has('published_at'))
    <span class="help-block">{{ $errors->first('published_at') }}</strong></span>
  @endif
</div>
