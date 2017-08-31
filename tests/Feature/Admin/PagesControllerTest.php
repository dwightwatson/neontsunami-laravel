<?php

namespace Tests\Feature\Admin;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PagesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $response = $this->actingAs(new User)->get('/admin');

        $response->assertStatus(200);
    }

    public function testReports()
    {
        $response = $this->actingAs(new User)->get('/admin/reports');

        $response->assertStatus(200);
    }
}
