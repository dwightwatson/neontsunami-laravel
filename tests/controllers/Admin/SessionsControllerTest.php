<?php

namespace Admin;

use NeonTsunami\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SessionsControllerTest extends \TestCase
{
    use DatabaseTransactions;

    public function testCreate()
    {
        $this->action('GET', 'Admin\SessionsController@create');

        $this->assertResponseOk();
    }

    public function testStoreWithCorrectCredentials()
    {
        $user = factory(User::class)->create([
            'email'    => 'test@example.com',
            'password' => 'password'
        ]);

        $this->action('POST', 'Admin\SessionsController@store', [
            'email'    => $user->email,
            'password' => 'password'
        ]);

        $this->assertRedirectedToRoute('admin.pages.index');
        $this->assertTrue(auth()->check());
        $this->assertEquals(auth()->user()->email, $user->email);
    }

    public function testStoreWithIncorrectCredentials()
    {
        $user = factory(User::class)->create([
            'email' => 'text@example.com',
        ]);

        $this->action('POST', 'Admin\SessionsController@store', [
            'email'    => $user->email,
            'password' => 'foo'
        ]);

        $this->assertRedirectedToRoute('admin.sessions.create');
        $this->assertSessionHas('error', 'Your login credentials were invalid.');
    }

    public function testStoreWithoutCredentials()
    {
        $this->action('POST', 'Admin\SessionsController@store');

        $this->assertRedirectedToRoute('admin.sessions.create');
        $this->assertSessionHasErrors(['email', 'password']);
        $this->assertFalse(auth()->check());
    }

    public function testDestroy()
    {
        $this->action('DELETE', 'Admin\SessionsController@destroy');

        $this->assertRedirectedToRoute('admin.sessions.create');
        $this->assertFalse(auth()->check());
    }
}
