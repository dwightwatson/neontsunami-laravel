<?php

class BaseController extends Controller {

    /**
     * Construct the controller.
     *
     * @return void
     */
    public function __construct()
    {
        $this->beforeFilter('csrf', ['on' => ['delete', 'patch', 'post', 'put']]);
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if ( ! is_null($this->layout))
        {
            $this->layout = View::make($this->layout);
        }
    }

}
