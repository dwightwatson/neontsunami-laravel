<?php

namespace App;

use Laravel\Scout\Searchable;

class Post extends Model
{
    use Searchable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['series_id', 'title', 'slug', 'content', 'published_at'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['published_at', 'deleted_at'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        if ($this->isPublished()) {
            return $this->toArray();
        }

        return [];
    }

    public function publish()
    {
        $this->published_at = $this->freshTimestamp();
        $this->save();
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', $this->freshTimestamp());
    }

    public function scopeRelated($query, Post $post)
    {
        $tags = $post->tags->modelKeys();

        return $query->whereHas('tags', function ($query) use ($tags) {
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
        $this->attributes['slug'] = str_slug($value);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function isPublished()
    {
        return ! $this->isUnpublished() && $this->published_at <= $this->freshTimestamp();
    }

    public function isUnpublished()
    {
        return is_null($this->published_at);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->orderBy('name')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
