<?php

namespace Tests\Feature\Admin;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SessionsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCreate()
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
    }

    public function testStoreWithCorrectCredentials()
    {
        $user = factory(User::class)->create([
            'email'    => 'test@example.com',
            'password' => 'password'
        ]);

        $response = $this->post('/admin/login', [
            'email'    => $user->email,
            'password' => 'password'
        ]);

        $response->assertRedirect('/admin');

        $this->assertTrue(auth()->check());
        $this->assertEquals(auth()->user()->email, $user->email);
    }

    public function testStoreWithIncorrectCredentials()
    {
        $user = factory(User::class)->create([
            'email' => 'text@example.com',
        ]);

        $response = $this->post('/admin/login', [
            'email'    => $user->email,
            'password' => 'foo'
        ]);

        $response->assertRedirect('/admin/login');

        $this->assertFalse(auth()->check());
    }

    public function testStoreWithoutCredentials()
    {
        $this->from('/admin/login');

        $response = $this->post('/admin/login', []);

        $response->assertRedirect('/admin/login');

        $this->assertFalse(auth()->check());
    }

    public function testDestroy()
    {
        $response = $this->delete('/admin/logout');

        $response->assertRedirect('/admin/login');

        $this->assertFalse(auth()->check());
    }
}
