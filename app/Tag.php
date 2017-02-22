<?php

namespace App;

class Tag extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tags';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug'];

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
     * Get tags that have been used more than 3 times and
     * include that count with the tag.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeUsed($query)
    {
        return $query->selectRaw('tags.*, COUNT(id) AS count')
            ->join('post_tag', 'post_tag.tag_id', '=', 'tags.id')
            ->groupBy('slug');
    }

    /**
     * Filter the tags by a search term.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  string                              $search
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'LIKE', "%{$search}%");
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors and mutators
    |--------------------------------------------------------------------------
    */
    public function getHashtagAttribute()
    {
        return "#{$this->slug}";
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function posts()
    {
        return $this->belongsToMany(Post::class)->withTimestamps();
    }
}
