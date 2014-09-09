<?php

use Laracasts\TestDummy\Factory;

class AdminUsersControllerTest extends TestCase {

    public function setUp()
    {
        parent::setUp();

        $this->be(new User);
    }

    public function testIndex()
    {
        $this->action('GET', 'Admin\UsersController@index');

        $this->assertResponseOk();
        $this->assertViewIs('admin.users.index');
        $this->assertViewHas('users');
    }

    public function testCreate()
    {
        $this->action('GET', 'Admin\UsersController@create');

        $this->assertResponseOk();
        $this->assertViewIs('admin.users.create');
    }

    public function testStore()
    {
        $user = Factory::build('User');

        $input = array_only($user->getAttributes(), $user->getFillable());

        $this->action('POST', 'Admin\UsersController@store', $input);

        $this->assertRedirectedToRoute('admin.users.show', User::first()->id);
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
        $user = Factory::create('User');

        $this->action('GET', 'Admin\UsersController@show', $user->id);

        $this->assertResponseOk();
        $this->assertViewIs('admin.users.show');
        $this->assertViewHas('user');
    }

    public function testEdit()
    {
        $user = Factory::create('User');

        $this->action('GET', 'Admin\UsersController@edit', $user->id);

        $this->assertResponseOk();
        $this->assertViewIs('admin.users.edit');
        $this->assertViewHas('user');
    }

    public function testUpdate()
    {
        // @todo
    }

    public function testUpdateFails()
    {
        Factory::create('User', ['first_name' => 'foo']);

        $user = User::first();

        $this->action('PUT', 'Admin\UsersController@update', $user->id, [
            'first_name' => null
        ]);

        $this->assertRedirectedToRoute('admin.users.edit', $user->id);
        $this->assertHasOldInput();
        $this->assertSessionHasErrors();
    }

    public function testDestroy()
    {
        $user = Factory::create('User');

        $this->action('DELETE', 'Admin\UsersController@destroy', $user->id);

        $this->assertRedirectedToRoute('admin.users.index');
        $this->assertEquals(0, User::count());
    }

}
