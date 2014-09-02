<?php namespace Admin;

use BaseController;

class AdminController extends BaseController {

    /**
     * Construct the controller.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->beforeFilter('auth');
    }

}
