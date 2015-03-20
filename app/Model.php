<?php namespace NeonTsunami;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class Model extends BaseModel {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

}
