<?php

class Series extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'series';

    /**
     * The rules by which to validate the model.
     *
     * @var array
     */
    protected $rules = [
        'name'        => 'required',
        'slug'        => 'required|unique:series,slug',
        'description' => 'required'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    /*
    |--------------------------------------------------------------------------
    | Accessors and mutators
    |--------------------------------------------------------------------------
    */
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
        return $this->hasMany('Post');
    }

}
