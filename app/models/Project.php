<?php

class Project extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects';

    /**
     * The rules by which to validate the model.
     *
     * @var array
     */
    protected $rules = [
        'name'        => 'required',
        'slug'        => 'required|unique:projects,slug',
        'description' => 'required',
        'url'         => 'url'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeAlphabetical($query)
    {
        return $query->orderBy('name');
    }

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

}
