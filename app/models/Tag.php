<?php

use Illuminate\Support\Str;

class Tag extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tags';

    /**
     * The rules by which to validate the model.
     *
     * @var array
     */
    protected $rules = [
        'name' => 'required',
        'slug' => 'required|unique:tags,slug'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug'];

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
        $this->attributes['slug'] = Str::slug($value);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function posts()
    {
        return $this->belongsToMany('Post')->withTimestamps();
    }

}
