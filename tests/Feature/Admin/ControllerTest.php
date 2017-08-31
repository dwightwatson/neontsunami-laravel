<?php

namespace Tests\Feature\Admin;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRedirectsGuests()
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/admin/login');

        $this->assertGuest();
    }

    public function testAllowsAuthenticatedAccess()
    {
        $response = $this->actingAs(new User)->get('/admin');

        $response->assertStatus(200);

        $this->assertAuthenticated();
    }
}
