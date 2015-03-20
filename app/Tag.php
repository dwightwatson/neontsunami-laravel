<?php namespace NeonTsunami;

class Tag extends Model {

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
     * @return this
     */
    public function scopeUsed()
    {
        return $this->selectRaw('tags.*, COUNT(id) AS count')
            ->join('post_tag', 'post_tag.tag_id', '=', 'tags.id')
            ->groupBy('slug');
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
        return $this->belongsToMany('NeonTsunami\Post')->withTimestamps();
    }

}
