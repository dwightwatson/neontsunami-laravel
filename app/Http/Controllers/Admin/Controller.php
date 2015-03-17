<?php namespace NeonTsunami\Http\Controllers\Admin;

use NeonTsunami\Http\Controllers\Controller as BaseController;

abstract class Controller extends BaseController {

    public function __construct()
    {
        $this->middleware('auth');
    }

}
