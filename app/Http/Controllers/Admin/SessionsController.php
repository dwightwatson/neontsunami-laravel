<?php namespace NeonTsunami\Http\Controllers\Admin;

use Validator;
use Illuminate\Auth\Guard as Auth;
use Illuminate\Http\Request;

class SessionsController extends Controller {

	/**
	 * Construct the controller.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth', ['only' => 'destroy']);
	}

	/**
	 * GET /admin/login
	 * Display the form for logging in a user.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('admin.sessions.create')
			->withTitle('Login');
	}

	/**
	 * POST /admin/login
	 * Attempt to login a user.
	 *
	 * @param  Request  $request
	 * @param  Auth     $auth
	 * @return Response
	 */
	public function store(Request $request, Auth $auth)
	{
		$this->validate($request, [
			'email'    => 'required|email|exists:users',
			'password' => 'required'
		]);

		// Attempt to login and remember the user.
		if ($auth->attempt($request->only('email', 'password'), true))
		{
			return redirect()->intended(route('admin.pages.index'));
		}

		return redirect()->route('admin.sessions.create')
			->withError("Your login credentials were invalid.")
			->withInput($request->except('password'));
	}

	/**
	 * DELETE /admin/logout
	 * Log out a user.
	 *
	 * @param  Auth  $auth
	 * @return Response
	 */
	public function destroy(Auth $auth)
	{
		$auth->logout();

		return redirect()->route('admin.sessions.create')
			->withSuccess("You have been logged out.");
	}

	/**
	 * Get the URL we should redirect to.
	 *
	 * @return string
	 */
	protected function getRedirectUrl()
	{
		return route('admin.sessions.create');
	}

}
