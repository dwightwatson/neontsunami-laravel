<?php namespace Admin;

use NeonTsunami\User;

use Laracasts\TestDummy\Factory;
use Laracasts\TestDummy\DbTestCase;

class UsersControllerTest extends DbTestCase {

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
        $user = Factory::build(User::class);

        $input = array_only($user->getAttributes(), $user->getFillable());

        $this->action('POST', 'Admin\UsersController@store', $input);

        $this->assertRedirectedToRoute('admin.users.show', User::first());
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
        $user = Factory::create(User::class);

        $this->action('GET', 'Admin\UsersController@show', $user);

        $this->assertResponseOk();
        $this->assertViewHas('user');
    }

    public function testEdit()
    {
        $user = Factory::create(User::class);

        $this->action('GET', 'Admin\UsersController@edit', $user);

        $this->assertResponseOk();
        $this->assertViewHas('user');
    }

    public function testUpdate()
    {
        $user = Factory::create(User::class, ['first_name' => 'foo']);

        $input = array_only($user->getAttributes(), $user->getFillable());

        $input['first_name'] = 'bar';

        $this->action('PUT', 'Admin\UsersController@update', $user, $input);

        $this->assertRedirectedToRoute('admin.users.show', $user);
        $this->assertEquals('bar', User::find($user->id)->first_name);
    }

    public function testUpdateFails()
    {
        $user = Factory::create(User::class, ['first_name' => 'foo']);

        $this->action('PUT', 'Admin\UsersController@update', $user);

        $this->assertRedirectedToRoute('admin.users.edit', $user);
        $this->assertHasOldInput();
        $this->assertSessionHasErrors();
    }

    public function testDestroy()
    {
        $user = Factory::create(User::class);

        $this->action('DELETE', 'Admin\UsersController@destroy', $user);

        $this->assertRedirectedToRoute('admin.users.index');
        $this->assertEquals(0, User::count());
    }

}
