<?php

namespace NeonTsunami\Http\Controllers\Admin;

use NeonTsunami\User;
use NeonTsunami\Http\Requests\Users\StoreUserRequest;
use NeonTsunami\Http\Requests\Users\UpdateUserRequest;

class UsersController extends Controller
{
    /**
     * GET /admin/users
     * Display all of the users.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::latest()->paginate(25);

        return view('admin.users.index', compact('users'))
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
        return view('admin.users.create')
            ->withTitle('Create user');
    }

    /**
     * POST /admin/users
     * Store a new user in storage.
     *
     * @param  StoreUserRequest  $request
     * @return Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());

        return redirect()->route('admin.users.show', $user)
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
        return view('admin.users.show', compact('user'))
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
        return view('admin.users.edit', compact('user'))
            ->withTitle('Edit user');
    }

    /**
     * PUT /admin/users/id
     * Update a given user in storage.
     *
     * @param  User  $user
     * @param  UpdateUserRequest  $request
     * @return Response
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        $user->update($request->all());

        return redirect()->route('admin.users.show', $user)
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

        return redirect()->route('admin.users.index')
            ->withSuccess('The user was deleted.');
    }
}
