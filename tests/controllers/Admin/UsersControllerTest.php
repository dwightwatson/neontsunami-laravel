<?php

namespace Admin;

use NeonTsunami\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersControllerTest extends \TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->be(new User);
    }

    public function testIndex()
    {
        $this->visit('admin/users');
    }

    public function testCreate()
    {
        $this->visit('admin/users/create');
    }

    public function testStore()
    {
        $user = factory(User::class)->make();

        $this->visit('admin/users/create')
            ->submitForm('Create user', $user->getAttributes());

        $user = User::latest()->first();

        $this->seePageIs("admin/users/{$user->id}");
    }

    public function testStoreFails()
    {
        $this->visit('admin/users/create')
            ->submitForm('Create user')
            ->seePageIs('admin/users/create');
    }

    public function testShow()
    {
        $user = factory(User::class)->create();

        $this->visit("admin/users/{$user->id}")
            ->see($user->name);
    }

    public function testEdit()
    {
        $user = factory(User::class)->create();

        $this->visit("admin/users/{$user->id}/edit");
    }

    public function testUpdate()
    {
        $user = factory(User::class)->create(['first_name' => 'foo']);

        $this->visit("admin/users/{$user->id}/edit")
            ->submitForm('Save user', ['first_name' => 'bar'])
            ->seePageIs("admin/users/{$user->id}")
            ->see('bar');

        $this->assertEquals('bar', $user->fresh()->first_name);
    }

    public function testUpdateFails()
    {
        $user = factory(User::class)->create();

        $this->visit("admin/users/{$user->id}/edit")
            ->submitForm('Save user', ['first_name' => null])
            ->seePageIs("admin/users/{$user->id}/edit");
    }

    public function testDestroy()
    {
        $user = factory(User::class)->create();

        $this->action('DELETE', 'Admin\UsersController@destroy', $user);

        $this->assertRedirectedToRoute('admin.users.index');
        $this->assertEquals(0, User::count());
    }
}
