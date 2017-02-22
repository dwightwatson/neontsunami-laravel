<?php

namespace Tests\Feature\Admin;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ControllerTest extends TestCase
{
    public function testRedirectsGuests()
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/admin/login');
    }

    public function testAllowsAuthenticatedAccess()
    {
        $response = $this->actingAs(new User)->get('/admin');

        $response->assertStatus(200);
    }
}
