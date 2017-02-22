<?php

namespace Tests\Feature\Admin;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
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
        $response = $this->get('/admin/users');

        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $response = $this->get('/admin/users/create');

        $response->assertStatus(200);
    }

    public function testStore()
    {
        $user = factory(User::class)->make();

        $response = $this->post('/admin/users', $user->getAttributes());

        $user = User::latest()->first();

        $response->assertRedirect("admin/users/{$user->id}");
    }

    public function testStoreFails()
    {
        $response = $this->post('/admin/users', []);

        $response->assertRedirect('/admin/users/create');
    }

    public function testShow()
    {
        $user = factory(User::class)->create();

        $response = $this->get("/admin/users/{$user->id}");

        $response->assertStatus(200)
            ->assertSee($user->first_name);
    }

    public function testEdit()
    {
        $user = factory(User::class)->create();

        $response = $this->get("admin/users/{$user->id}/edit");

        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $user = factory(User::class)->create(['first_name' => 'foo']);

        $response = $this->put("/admin/users/{$user->id}", ['first_name' => 'bar']);

        $response->assertRedirect("/admin/users/{$user->id}");

        $this->assertEquals('bar', $user->fresh()->first_name);
    }

    public function testUpdateFails()
    {
        $user = factory(User::class)->create();

        $response = $this->put("/admin/users/{$user->id}", ['email' => 'invalid']);

        $response->assertRedirect("/admin/users/{$user->id}/edit");
    }

    public function testDestroy()
    {
        $user = factory(User::class)->create();

        $response = $this->delete("/admin/users/{$user->id}");

        $response->assertRedirect('/admin/users');

        $this->assertEquals(0, User::count());
    }
}
