<?php namespace Admin;

use Auth;

use Redirect;
use Request;
use Validator;
use View;

class SessionsController extends AdminController {

    /**
     * Construct the controller.
     *
     * @return void
     */
    public function __construct()
    {
        // Re-register filters here because they cannot be overridden through
        // the constructor.
        $this->beforeFilter('csrf', ['on' => ['delete', 'patch', 'post', 'put']]);
        $this->beforeFilter('auth', ['only' => 'destroy']);
    }

    /**
     * GET /admin/login
     * Display the form for logging in a user.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('admin.sessions.create')
            ->withTitle('Login');
    }

    /**
     * POST /admin/login
     * Attempt to login a user.
     *
     * @return Response
     */
    public function store()
    {
        $credentials = Request::only('email', 'password');

        $validation = Validator::make($credentials, [
            'email'    => 'required|email|exists:users',
            'password' => 'required'
        ]);

        if ($validation->fails())
        {
            return Redirect::route('admin.sessions.create')
                ->withErrors($validation)
                ->withInput(Request::except('password'));
        }

        // Attempt to login and remember the user.
        if (Auth::attempt($credentials, true))
        {
            return Redirect::intended(route('admin.pages.index'));
        }

        return Redirect::route('admin.sessions.create')
            ->withError("Your login credentials were invalid.")
            ->withInput(Request::except('password'));
    }

    /**
     * DELETE /admin/logout
     * Log out a user.
     *
     * @return Response
     */
    public function destroy()
    {
        Auth::logout();

        return Redirect::route('admin.sessions.create')
            ->withSuccess("You have been logged out.");
    }

}
