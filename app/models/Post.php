<?php

use Carbon\Carbon;
use Illuminate\Support\Str;

class Post extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The rules by which to validate the model.
     *
     * @var array
     */
    protected $rules = [
        'user_id'      => 'required|exists:users,id',
        'series_id'    => 'exists:series,id',
        'title'        => 'required',
        'slug'         => 'required|unique:posts,slug',
        'content'      => 'required'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'content'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['published_at', 'deleted_at'];

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', Carbon::now());
    }

    public function scopeRelated($query, Post $post)
    {
        $tags = $post->tags->modelKeys();

        return $query->whereHas('tags', function($query) use ($tags)
        {
            $query->whereIn('id', $tags);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors and mutators
    |--------------------------------------------------------------------------
    */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function series()
    {
        return $this->belongsTo('Series');
    }

    public function tags()
    {
        return $this->belongsToMany('Tag')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

}
