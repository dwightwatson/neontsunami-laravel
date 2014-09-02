<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Watson\Validating\ValidatingTrait;

class BaseModel extends Eloquent {

    use SoftDeletingTrait, ValidatingTrait;

    protected $dates = ['deleted_at'];

}
