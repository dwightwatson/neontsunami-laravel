<?php namespace Admin;

use User;
use Redirect, Request, View;

class UsersController extends AdminController {

    /**
     * User instance.
     *
     * @var User
     */
    protected $user;

    /**
     * Construct the controller.
     *
     * @param  User  $user
     * @return void
     */
    public function __construct(User $user)
    {
        parent::__construct();

        $this->user = $user;
    }

    /**
     * GET /admin/users
     * Display all of the users.
     *
     * @return Response
     */
    public function index()
    {
        $users = $this->user->latest()
            ->paginate(25);

        return View::make('admin.users.index', compact('users'))
            ->withTitle('All users');
    }

    /**
     * GET /admin/users/create
     * Display the form for creating a new user.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('admin.users.create')
            ->withTitle('Create user');
    }

    /**
     * POST /admin/users
     * Store a new user in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Request::input();

        $user = $this->user->fill($input);

        if ( ! $user->save())
        {
            return Redirect::route('admin.users.create')
                ->withInput()
                ->withErrors($user->getErrors());
        }

        return Redirect::route('admin.users.show', $user->id)
            ->withSuccess('The user was created.');
    }

    /**
     * GET /admin/users/id
     * Display a specified user.
     *
     * @param  User  $user
     * @return Response
     */
    public function show(User $user)
    {
        return View::make('admin.users.show', compact('user'))
            ->withTitle('Show user');
    }

    /**
     * GET /admin/users/id/edit
     * Display the form for editing a user.
     *
     * @param  User  $user
     * @return Response
     */
    public function edit(User $user)
    {
        return View::make('admin.users.edit', compact('user'))
            ->withTitle('Edit user');
    }

    /**
     * PUT /admin/users/id
     * Update a given user in storage.
     *
     * @param  User  $user
     * @return Response
     */
    public function update(User $user)
    {
        $input = Request::input();

        if ( ! $user->update($input))
        {
            return Redirect::route('admin.users.edit', $user->id)
                ->withErrors($user->getErrors())
                ->witHInput();
        }

        return Redirect::route('admin.users.show', $user->id)
            ->withSuccess('The user was updated');
    }

    /**
     * DELETE /admin/users/id
     * Remove a user from storage.
     *
     * @param  User  $user
     * @return Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return Redirect::route('admin.users.index')
            ->withSuccess('The user was deleted.');
    }

}
