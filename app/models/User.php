<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends BaseModel implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = array('first_name', 'last_name', 'email');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	/**
	 * The rules by which to validate the model.
	 *
	 * @var array
	 */
	protected $rules = [
		'first_name' => 'required',
		'last_name'  => 'required',
		'email'      => 'required|email|unique:users,email',
		'password'   => 'required'
	];

	/*
	|--------------------------------------------------------------------------
	| Accessors and mutators
	|--------------------------------------------------------------------------
	*/
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = Hash::make($value);
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

	public function tags()
	{
		return $this->hasManyThrough('Tag', 'Post');
	}

}
