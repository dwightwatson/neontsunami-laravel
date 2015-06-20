<?php

namespace Admin;

use NeonTsunami\User;
use TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->be(new User);
    }

    public function testIndex()
    {
        $this->action('GET', 'Admin\UsersController@index');

        $this->assertResponseOk();
        $this->assertViewHas('users');
    }

    public function testCreate()
    {
        $this->action('GET', 'Admin\UsersController@create');

        $this->assertResponseOk();
    }

    public function testStore()
    {
        $user = factory(User::class)->make();

        $input = array_only($user->getAttributes(), $user->getFillable());

        $this->action('POST', 'Admin\UsersController@store', $input);

        $this->assertRedirectedToRoute('admin.users.show', User::latest()->first());
    }

    public function testStoreFails()
    {
        $this->action('POST', 'Admin\UsersController@store');

        $this->assertRedirectedToRoute('admin.users.create');
        $this->assertHasOldInput();
        $this->assertSessionHasErrors();
    }

    public function testShow()
    {
        $user = factory(User::class)->create();

        $this->action('GET', 'Admin\UsersController@show', $user);

        $this->assertResponseOk();
        $this->assertViewHas('user');
    }

    public function testEdit()
    {
        $user = factory(User::class)->create();

        $this->action('GET', 'Admin\UsersController@edit', $user);

        $this->assertResponseOk();
        $this->assertViewHas('user');
    }

    public function testUpdate()
    {
        $user = factory(User::class)->create(['first_name' => 'foo']);

        $input = array_only($user->getAttributes(), $user->getFillable());

        $input['first_name'] = 'bar';

        $this->action('PUT', 'Admin\UsersController@update', $user, $input);

        $this->assertRedirectedToRoute('admin.users.show', $user);
        $this->assertEquals('bar', $user->fresh()->first_name);
    }

    public function testUpdateFails()
    {
        $user = factory(User::class)->create(['first_name' => 'foo']);

        $this->action('PUT', 'Admin\UsersController@update', $user);

        $this->assertRedirectedToRoute('admin.users.edit', $user);
        $this->assertHasOldInput();
        $this->assertSessionHasErrors();
    }

    public function testDestroy()
    {
        $user = factory(User::class)->create();

        $this->action('DELETE', 'Admin\UsersController@destroy', $user);

        $this->assertRedirectedToRoute('admin.users.index');
        $this->assertEquals(0, User::count());
    }
}
