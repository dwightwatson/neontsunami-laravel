<?php

namespace Admin;

use NeonTsunami\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SessionsControllerTest extends \TestCase
{
    use DatabaseTransactions;

    public function testCreate()
    {
        $this->visit('admin/login');
    }

    public function testStoreWithCorrectCredentials()
    {
        $user = factory(User::class)->create([
            'email'    => 'test@example.com',
            'password' => 'password'
        ]);

        $this->visit('admin/login')
            ->submitForm('Login', [
                'email'    => $user->email,
                'password' => 'password'
            ])->seePageIs('admin');

        $this->assertTrue(auth()->check());
        $this->assertEquals(auth()->user()->email, $user->email);
    }

    public function testStoreWithIncorrectCredentials()
    {
        $user = factory(User::class)->create([
            'email' => 'text@example.com',
        ]);

        $this->visit('admin/login')
            ->submitForm('Login', [
                'email'    => $user->email,
                'password' => 'foo'
            ])->seePageIs('admin/login')
            ->see('Your login credentials were invalid');

        $this->assertFalse(auth()->check());
    }

    public function testStoreWithoutCredentials()
    {
        $this->visit('admin/login')
            ->submitForm('Login')
            ->seePageIs('admin/login');

        $this->assertFalse(auth()->check());
    }

    public function testDestroy()
    {
        $this->action('DELETE', 'Admin\SessionsController@destroy');

        $this->assertRedirectedToRoute('admin.sessions.create');
        $this->assertFalse(auth()->check());
    }
}
